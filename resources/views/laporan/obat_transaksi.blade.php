@extends('layouts.app')

@section('title', 'Riwayat Transaksi Obat - ' . $obat->nama_obat)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('obat.index') }}">Obat</a></li>
    <li class="breadcrumb-item"><a href="{{ route('obat.show', $obat->id) }}">{{ $obat->nama_obat }}</a></li>
    <li class="breadcrumb-item active">Riwayat Transaksi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Medicine Info Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-capsule me-2"></i>Informasi Obat</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="badge bg-info fs-5 mb-2">{{ $obat->kode_obat }}</div>
                    <h5>{{ $obat->nama_obat }}</h5>
                </div>
                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="40%">Satuan</th>
                        <td>: <span class="badge bg-secondary">{{ $obat->satuan_obat }}</span></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>: <span class="text-success fw-bold">Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}</span></td>
                    </tr>
                    <tr>
                        <th>Stok Saat Ini</th>
                        <td>: 
                            @if($obat->stock_obat >= 20)
                                <span class="badge bg-success">{{ $obat->stock_obat }}</span>
                            @elseif($obat->stock_obat >= 10)
                                <span class="badge bg-warning">{{ $obat->stock_obat }}</span>
                            @else
                                <span class="badge bg-danger">{{ $obat->stock_obat }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Ringkasan Penjualan</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="display-4 fw-bold text-primary">{{ $totalTerjual }}</div>
                    <div class="text-muted">Total Terjual</div>
                </div>
                <div class="text-center mb-3">
                    <div class="fw-bold text-success fs-3">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="text-muted">Total Pendapatan</div>
                </div>
                <div class="row text-center">
                    <div class="col-6 border-end">
                        <div class="fw-bold">{{ $transaksiDetails->count() }}</div>
                        <small class="text-muted">Transaksi</small>
                    </div>
                    <div class="col-6">
                        @php
                            $average = $transaksiDetails->count() > 0 ? $totalTerjual / $transaksiDetails->count() : 0;
                        @endphp
                        <div class="fw-bold">{{ number_format($average, 1) }}</div>
                        <small class="text-muted">Rata-rata per Transaksi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('obat.show', $obat->id) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
                    </a>
                    <a href="{{ route('transaksi.create') }}?obat={{ $obat->id }}" class="btn btn-success">
                        <i class="bi bi-cart-plus me-1"></i> Jual Lagi
                    </a>
                    <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i> Edit Obat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>Riwayat Transaksi
                    <span class="badge bg-info">{{ $obat->nama_obat }}</span>
                </h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" 
                            data-bs-toggle="dropdown">
                        <i class="bi bi-download me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#" onclick="exportToPDF()">
                                <i class="bi bi-file-pdf me-2"></i> PDF
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="exportToExcel()">
                                <i class="bi bi-file-excel me-2"></i> Excel
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                @if($transaksiDetails->count() > 0)
                <!-- Filter Section -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="searchInput" 
                               placeholder="Cari no. transaksi atau pembeli...">
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="sortSelect">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="highest">Jumlah Tertinggi</option>
                            <option value="lowest">Jumlah Terendah</option>
                        </select>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="transactionsTable">
                        <thead class="table-dark">
                            <tr>
                                <th width="50">No</th>
                                <th>Tanggal</th>
                                <th>No. Transaksi</th>
                                <th>Nama Pembeli</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end">Subtotal</th>
                                <th width="100" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiDetails as $index => $detail)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $detail->transaksi->tanggal_transaksi->translatedFormat('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('transaksi.struk', $detail->transaksi_id) }}" 
                                       class="text-decoration-none">
                                        <span class="badge bg-info">{{ $detail->transaksi->kode_transaksi }}</span>
                                    </a>
                                </td>
                                <td>{{ $detail->transaksi->nama_pembeli }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $detail->jumlah }}</span>
                                </td>
                                <td class="text-end">
                                    Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                </td>
                                <td class="text-end fw-bold text-success">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('transaksi.struk', $detail->transaksi_id) }}" 
                                       class="btn btn-sm btn-info" title="Lihat Struk">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end fw-bold">TOTAL:</td>
                                <td class="text-center fw-bold">
                                    <span class="badge bg-primary">{{ $totalTerjual }}</span>
                                </td>
                                <td class="text-end fw-bold">-</td>
                                <td class="text-end fw-bold text-success">
                                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Sales Chart -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Grafik Penjualan per Bulan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="80"></canvas>
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-cart-x display-1 text-muted"></i>
                    <h4 class="mt-3 text-muted">Belum Ada Transaksi</h4>
                    <p class="text-muted">Obat ini belum pernah dijual</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    $(document).ready(function() {
        // Search functionality
        $('#searchInput').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('#transactionsTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Sort functionality
        $('#sortSelect').on('change', function() {
            let value = $(this).val();
            let rows = $('#transactionsTable tbody tr').toArray();
            
            rows.sort(function(a, b) {
                let aData = $(a).find('td').eq(4).text(); // Jumlah
                let bData = $(b).find('td').eq(4).text();
                let aDate = $(a).find('td').eq(1).text();
                let bDate = $(b).find('td').eq(1).text();
                
                switch(value) {
                    case 'newest':
                        return new Date(bDate) - new Date(aDate);
                    case 'oldest':
                        return new Date(aDate) - new Date(bDate);
                    case 'highest':
                        return parseInt(bData) - parseInt(aData);
                    case 'lowest':
                        return parseInt(aData) - parseInt(bData);
                    default:
                        return 0;
                }
            });
            
            $('#transactionsTable tbody').empty().append(rows);
        });

        @if($transaksiDetails->count() > 0)
        // Prepare chart data
        let monthlyData = {};
        @foreach($transaksiDetails as $detail)
            @php
                $monthYear = $detail->transaksi->tanggal_transaksi->format('Y-m');
            @endphp
            monthlyData['{{ $monthYear }}'] = (monthlyData['{{ $monthYear }}'] || 0) + {{ $detail->jumlah }};
        @endforeach
        
        let months = Object.keys(monthlyData).sort();
        let quantities = months.map(month => monthlyData[month]);
        
        // Create chart
        let ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: quantities,
                    backgroundColor: 'rgba(67, 94, 190, 0.7)',
                    borderColor: '#435ebe',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan-Tahun'
                        }
                    }
                }
            }
        });
        @endif

        // Export functions
        function exportToPDF() {
            let medicineName = '{{ $obat->nama_obat }}';
            let medicineCode = '{{ $obat->kode_obat }}';
            let totalSold = {{ $totalTerjual }};
            let totalRevenue = {{ $totalPendapatan }};
            
            alert('Fitur export PDF untuk "' + medicineName + '" akan segera tersedia!');
        }

        function exportToExcel() {
            let medicineName = '{{ $obat->nama_obat }}';
            let medicineCode = '{{ $obat->kode_obat }}';
            
            alert('Fitur export Excel untuk "' + medicineName + '" akan segera tersedia!');
        }
    });
</script>
@endpush
@endsection