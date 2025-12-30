<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ====================== HOMEPAGE & DASHBOARD ======================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ====================== OBAT ROUTES (CRUD) ======================
Route::prefix('obat')->name('obat.')->group(function () {
    Route::get('/', [ObatController::class, 'index'])->name('index');
    Route::get('/create', [ObatController::class, 'create'])->name('create');
    Route::post('/', [ObatController::class, 'store'])->name('store');
    Route::get('/{obat}', [ObatController::class, 'show'])->name('show');
    Route::get('/{obat}/edit', [ObatController::class, 'edit'])->name('edit');
    Route::put('/{obat}', [ObatController::class, 'update'])->name('update');
    Route::delete('/{obat}', [ObatController::class, 'destroy'])->name('destroy');

    // Export routes
    Route::get('/export/pdf', [ObatController::class, 'exportPdf'])->name('export-pdf');
});

// ====================== TRANSAKSI ROUTES ======================
Route::prefix('transaksi')->name('transaksi.')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('index');
    Route::get('/create', [TransaksiController::class, 'create'])->name('create');
    Route::post('/', [TransaksiController::class, 'store'])->name('store');
    Route::get('/{id}/struk', [TransaksiController::class, 'struk'])->name('struk');
    Route::get('/{id}/print', [TransaksiController::class, 'printStruk'])->name('print');
    Route::delete('/{id}', [TransaksiController::class, 'destroy'])->name('destroy');

    // Additional transaction routes
    Route::get('/today', [TransaksiController::class, 'today'])->name('today');
    Route::get('/search', [TransaksiController::class, 'search'])->name('search');
});

// ====================== DISTRIBUTOR ROUTES (CRUD) ======================
Route::prefix('distributor')->name('distributor.')->group(function () {
    Route::get('/', [DistributorController::class, 'index'])->name('index');
    // Maps routes
    Route::get('/maps', [DistributorController::class, 'maps'])->name('maps');
    Route::get('/maps/{id}', [DistributorController::class, 'mapDetail'])->name('map-detail');
    Route::get('/create', [DistributorController::class, 'create'])->name('create');
    Route::post('/', [DistributorController::class, 'store'])->name('store');
    Route::get('/{distributor}', [DistributorController::class, 'show'])->name('show');
    Route::get('/{distributor}/edit', [DistributorController::class, 'edit'])->name('edit');
    Route::put('/{distributor}', [DistributorController::class, 'update'])->name('update');
    Route::delete('/{distributor}', [DistributorController::class, 'destroy'])->name('destroy');

});

// ====================== LAPORAN ROUTES ======================
Route::prefix('laporan')->name('laporan.')->group(function () {
    // Stock Report
    Route::get('/stok', [LaporanController::class, 'stok'])->name('stok');
    Route::get('/stok/print', [LaporanController::class, 'printStok'])->name('print-stok');

    // Sales Report
    Route::get('/penjualan', [LaporanController::class, 'penjualan'])->name('penjualan');
    Route::get('/penjualan/print', [LaporanController::class, 'printPenjualan'])->name('print-penjualan');

    Route::get('/export-excel', [LaporanController::class, 'exportExcel'])
        ->name('export-excel');

    // Medicine Transaction History
    Route::get('/obat/{id}/transaksi', [LaporanController::class, 'obatTransaksi'])->name('obat-transaksi');

    // Additional Reports
    Route::get('/harian', [LaporanController::class, 'harian'])->name('harian');
    Route::get('/bulanan', [LaporanController::class, 'bulanan'])->name('bulanan');
    Route::get('/tahunan', [LaporanController::class, 'tahunan'])->name('tahunan');
});

// ====================== API DOCUMENTATION ROUTE ======================
Route::get('/api-docs', function () {
    return view('api.docs');
})->name('api.docs');

// ====================== ABOUT/HELP ROUTES ======================
Route::get('/about', function () {
    return view('about', [
        'title' => 'Tentang Aplikasi',
        'version' => '1.0.0',
        'developer' => 'Tim Pengembang Apotek',
        'features' => [
            'Manajemen Obat Lengkap',
            'Transaksi Real-time',
            'Laporan Otomatis',
            'Maps Distributor',
            'API untuk Mobile'
        ]
    ]);
})->name('about');

Route::get('/help', function () {
    return view('help', [
        'title' => 'Bantuan & Panduan',
        'sections' => [
            [
                'title' => 'Memulai Transaksi',
                'steps' => [
                    'Pilih menu "Transaksi"',
                    'Klik tombol "Transaksi Baru"',
                    'Pilih obat dan isi jumlah',
                    'Masukkan jumlah bayar',
                    'Klik "Proses Transaksi"'
                ]
            ],
            [
                'title' => 'Menambahkan Obat Baru',
                'steps' => [
                    'Pilih menu "Obat"',
                    'Klik tombol "Tambah Obat"',
                    'Isi data obat dengan lengkap',
                    'Pastikan kode obat unik',
                    'Simpan data obat'
                ]
            ],
            [
                'title' => 'Melihat Laporan',
                'steps' => [
                    'Pilih menu "Laporan"',
                    'Pilih jenis laporan',
                    'Atur filter tanggal',
                    'Klik "Tampilkan"',
                    'Cetak jika diperlukan'
                ]
            ]
        ]
    ]);
})->name('help');

// ====================== FALLBACK ROUTE ======================
Route::fallback(function () {
    return redirect('/')->with('error', 'Halaman tidak ditemukan!');
});

// ====================== TEST ROUTES (Development Only) ======================
if (env('APP_DEBUG')) {
    Route::get('/test/seed', function () {
        Artisan::call('db:seed');
        return 'Database seeded successfully!';
    });

    Route::get('/test/migrate', function () {
        Artisan::call('migrate:fresh');
        return 'Database migrated successfully!';
    });

    Route::get('/test/clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return 'Cache cleared successfully!';
    });
}
