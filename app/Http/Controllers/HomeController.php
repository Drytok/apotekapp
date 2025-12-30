<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Transaksi;
use App\Models\Distributor;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Statistik
        $totalObat = Obat::count();
        $totalTransaksi = Transaksi::count();
        $totalDistributor = Distributor::count();

        // Total penjualan bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $totalPenjualan = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->sum('total_harga');

        // Obat stok rendah (kurang dari 10)
        $stokRendah = Obat::where('stock_obat', '<', 10)
            ->orderBy('stock_obat', 'asc')
            ->take(5)
            ->get();

        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with('details')
            ->latest()
            ->take(5)
            ->get();

        // Obat terlaris bulan ini
        $obatTerlaris = \App\Models\TransaksiDetail::selectRaw('obat_id, SUM(jumlah) as total_terjual')
            ->with('obat')
            ->whereHas('transaksi', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth]);
            })
            ->groupBy('obat_id')
            ->orderBy('total_terjual', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalObat',
            'totalTransaksi',
            'totalDistributor',
            'totalPenjualan',
            'stokRendah',
            'transaksiTerbaru',
            'obatTerlaris'
        ));
    }
}
