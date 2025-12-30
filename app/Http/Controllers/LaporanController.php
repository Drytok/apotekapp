<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function stok()
    {
        $obats = Obat::orderBy('nama_obat')->get();
        $totalNilai = $obats->sum(function ($obat) {
            return $obat->harga_obat * $obat->stock_obat;
        });

        return view('laporan.stok', compact('obats', 'totalNilai'));
    }

    public function penjualan(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $transaksis = Transaksi::with('details.obat')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $totalPenjualan = $transaksis->sum('total_harga');
        $totalTransaksi = $transaksis->count();

        return view('laporan.penjualan', compact('transaksis', 'totalPenjualan', 'totalTransaksi', 'startDate', 'endDate'));
    }

    public function obatTransaksi($id)
    {
        $obat = Obat::findOrFail($id);
        $transaksiDetails = $obat->transaksiDetails()
            ->with('transaksi')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalTerjual = $transaksiDetails->sum('jumlah');
        $totalPendapatan = $transaksiDetails->sum('subtotal');

        return view('laporan.obat_transaksi', compact('obat', 'transaksiDetails', 'totalTerjual', 'totalPendapatan'));
    }

    public function printStok()
    {
        $obats = Obat::orderBy('nama_obat')->get();
        $totalNilai = $obats->sum(function ($obat) {
            return $obat->harga_obat * $obat->stock_obat;
        });

        $pdf = PDF::loadView('laporan.print_stok', compact('obats', 'totalNilai'));
        return $pdf->download('laporan-stok-obat-' . date('Y-m-d') . '.pdf');
    }

    public function printPenjualan(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $transaksis = Transaksi::with('details.obat')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $totalPenjualan = $transaksis->sum('total_harga');
        $totalTransaksi = $transaksis->count();

        $pdf = PDF::loadView('laporan.print_penjualan', compact('transaksis', 'totalPenjualan', 'totalTransaksi', 'startDate', 'endDate'));
        return $pdf->download('laporan-penjualan-' . date('Y-m-d') . '.pdf');
    }
}
