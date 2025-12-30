@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <!-- Statistik Cards -->
    <div class="col-md-3">
        <div class="stat-card blue">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="number">{{ $totalObat }}</div>
                    <div class="label">Total Obat</div>
                </div>
                <i class="bi bi-capsule"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="number">{{ $totalTransaksi }}</div>
                    <div class="label">Total Transaksi</div>
                </div>
                <i class="bi bi-cart-check"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card orange">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="number">{{ $totalDistributor }}</div>
                    <div class="label">Distributor</div>
                </div>
                <i class="bi bi-truck"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card red">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="number">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
                    <div class="label">Total Penjualan</div>
                </div>
                <i class="bi bi-currency-exchange"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Quick Actions -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center mb-3">
                        <a href="{{ route('obat.create') }}" class="btn btn-primary btn-lg rounded-circle p-3">
                            <i class="bi bi-plus-lg fs-4"></i>
                        </a>
                        <div class="mt-2">Tambah Obat</div>
                    </div>
                    <div class="col-md-3 text-center mb-3">
                        <a href="{{ route('transaksi.create') }}" class="btn btn-success btn-lg rounded-circle p-3">
                            <i class="bi bi-cart-plus fs-4"></i>
                        </a>
                        <div class="mt-2">Transaksi Baru</div>
                    </div>
                    <div class="col-md-3 text-center mb-3">
                        <a href="{{ route('distributor.create') }}" class="btn btn-warning btn-lg rounded-circle p-3">
                            <i class="bi bi-truck fs-4"></i>
                        </a>
                        <div class="mt-2">Tambah Distributor</div>
                    </div>
                    <div class="col-md-3 text-center mb-3">
                        <a href="{{ route('laporan.stok') }}" class="btn btn-info btn-lg rounded-circle p-3">
                            <i class="bi bi-printer fs-4"></i>
                        </a>
                        <div class="mt-2">Cetak Laporan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Obat Stok Rendah -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Obat Stok Rendah</h6>
            </div>
            <div class="card-body">
                @if($stokRendah->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Obat</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stokRendah as $obat)
                            <tr>
                                <td>{{ $obat->kode_obat }}</td>
                                <td>{{ $obat->nama_obat }}</td>
                                <td>
                                    <span class="badge bg-{{ $obat->stock_obat < 5 ? 'danger' : 'warning' }}">
                                        {{ $obat->stock_obat }}
                                    </span>
                                </td>
                                <td>
                                    @if($obat->stock_obat < 5)
                                        <span class="badge bg-danger">Kritis</span>
                                    @else
                                        <span class="badge bg-warning">Hampir Habis</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i> Restock
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-check-circle fs-1 text-success"></i>
                    <p class="mt-2">Semua stok obat dalam kondisi aman</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Transaksi Terbaru</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($transaksiTerbaru as $transaksi)
                    <a href="{{ route('transaksi.struk', $transaksi->id) }}" 
                       class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $transaksi->kode_transaksi }}</h6>
                            <small>{{ $transaksi->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ $transaksi->nama_pembeli }}</p>
                        <small class="text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</small>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua Transaksi
                </a>
            </div>
        </div>

        <!-- Info Sistem -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Info Sistem</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Versi:</strong> 1.0.0
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Framework:</strong> Laravel {{ app()->version() }}
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Database:</strong> MySQL
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Total Fitur:</strong> 10+
                    </li>
                </ul>
                <div class="alert alert-info mt-3">
                    <small>
                        <i class="bi bi-lightbulb me-1"></i>
                        <strong>Tips:</strong> Gunakan menu di samping untuk navigasi cepat
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection