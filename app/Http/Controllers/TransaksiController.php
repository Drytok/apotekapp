<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('details.obat')->latest();

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        } else {
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        $transaksis = $query->get();

        return view('transaksi.index', compact('transaksis', 'startDate', 'endDate'));
    }

    public function create()
    {
        $obats = Obat::where('stock_obat', '>', 0)
            ->orderBy('nama_obat')
            ->get();

        // Generate kode transaksi
        $lastTransaksi = Transaksi::latest()->first();
        $counter = $lastTransaksi ? intval(substr($lastTransaksi->kode_transaksi, -4)) + 1 : 1;
        $kodeTransaksi = 'TRX-' . date('Ymd') . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT);

        return view('transaksi.create', compact('obats', 'kodeTransaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_transaksi' => 'required|unique:transaksis',
            'nama_pembeli' => 'required|max:255',
            'tanggal_transaksi' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.obat_id' => 'required|exists:obats,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'bayar' => 'required|numeric|min:0'
        ]);

        // Cek stok untuk setiap item
        $errors = [];
        foreach ($request->items as $index => $item) {
            $obat = Obat::find($item['obat_id']);
            if ($obat->stock_obat < $item['jumlah']) {
                $errors[] = "Stok $obat->nama_obat tidak mencukupi. Stok tersedia: $obat->stock_obat";
            }
        }

        if (!empty($errors)) {
            return back()->withErrors(['items' => $errors])->withInput();
        }

        // Hitung total harga
        $totalHarga = 0;
        $itemsData = [];

        foreach ($request->items as $item) {
            $obat = Obat::find($item['obat_id']);
            $subtotal = $obat->harga_obat * $item['jumlah'];
            $totalHarga += $subtotal;

            $itemsData[] = [
                'obat_id' => $item['obat_id'],
                'obat' => $obat,
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $obat->harga_obat,
                'subtotal' => $subtotal
            ];
        }

        // Validasi pembayaran
        $bayar = $request->bayar;
        $kembalian = $bayar - $totalHarga;

        if ($kembalian < 0) {
            return back()->withErrors(['bayar' => 'Jumlah pembayaran kurang!'])->withInput();
        }

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'kode_transaksi' => $request->kode_transaksi,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'nama_pembeli' => $request->nama_pembeli,
            'total_harga' => $totalHarga,
            'bayar' => $bayar,
            'kembalian' => $kembalian
        ]);

        // Simpan detail transaksi dan update stok
        foreach ($itemsData as $item) {
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'obat_id' => $item['obat_id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga_satuan'],
                'subtotal' => $item['subtotal']
            ]);

            // Update stok obat
            $obat = Obat::find($item['obat_id']);
            $obat->decrement('stock_obat', $item['jumlah']);
        }

        return redirect()->route('transaksi.struk', $transaksi->id)
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with('details.obat')->findOrFail($id);
        return view('transaksi.struk', compact('transaksi'));
    }

    public function printStruk($id)
    {
        $transaksi = Transaksi::with('details.obat')->findOrFail($id);

        // Return PDF for thermal printer
        $pdf = PDF::loadView('transaksi.print_struk', compact('transaksi'));

        // Set paper size for thermal printer (80mm width)
        $pdf->setPaper([0, 0, 226.77, 700], 'portrait'); // 80mm width in points

        // Set filename
        $filename = 'struk-' . $transaksi->kode_transaksi . '.pdf';

        // Return PDF for streaming (preview in browser)
        return $pdf->stream($filename);

        // Or for direct download:
        // return $pdf->download($filename);
    }
    public function destroy($id)
    {
        $transaksi = Transaksi::with('details')->findOrFail($id);

        // Kembalikan stok
        foreach ($transaksi->details as $detail) {
            $obat = Obat::find($detail->obat_id);
            $obat->increment('stock_obat', $detail->jumlah);
        }

        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
