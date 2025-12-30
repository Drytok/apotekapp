<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::orderBy('nama_obat')->get();
        return view('obat.index', compact('obats'));
    }

    public function create()
    {
        $satuanOptions = ['Tablet', 'Kapsul', 'Botol', 'Tube', 'Box', 'Strip', 'Sachet', 'Vial'];
        return view('obat.create', compact('satuanOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_obat' => 'required|unique:obats|max:45',
            'nama_obat' => 'required|max:255',
            'satuan_obat' => 'required|max:45',
            'harga_obat' => 'required|numeric|min:0',
            'stock_obat' => 'required|integer|min:0'
        ]);

        Obat::create($request->all());
        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan!');
    }

    public function show(Obat $obat)
    {
        $transaksiDetails = $obat->transaksiDetails()->with('transaksi')->latest()->take(10)->get();
        return view('obat.show', compact('obat', 'transaksiDetails'));
    }

    public function edit(Obat $obat)
    {
        $satuanOptions = ['Tablet', 'Kapsul', 'Botol', 'Tube', 'Box', 'Strip', 'Sachet', 'Vial'];
        return view('obat.edit', compact('obat', 'satuanOptions'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'kode_obat' => 'required|max:45|unique:obats,kode_obat,' . $obat->id,
            'nama_obat' => 'required|max:255',
            'satuan_obat' => 'required|max:45',
            'harga_obat' => 'required|numeric|min:0',
            'stock_obat' => 'required|integer|min:0'
        ]);

        $obat->update($request->all());
        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui!');
    }

    public function destroy(Obat $obat)
    {
        // Cek apakah obat sudah digunakan di transaksi
        if ($obat->transaksiDetails()->exists()) {
            return redirect()->route('obat.index')
                ->with('error', 'Obat tidak dapat dihapus karena sudah digunakan dalam transaksi!');
        }

        $obat->delete();
        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus!');
    }

    public function exportPdf()
    {
        $obats = Obat::orderBy('nama_obat')->get();
        $totalNilai = $obats->sum('nilai_stok');

        $pdf = PDF::loadView('obat.export_pdf', compact('obats', 'totalNilai'));
        return $pdf->download('data-obat-' . date('Y-m-d') . '.pdf');
    }
}
