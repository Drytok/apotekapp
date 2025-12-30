@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('laporan.penjualan') }}">Laporan</a></li>
    <li class="breadcrumb-item active">Penjualan</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Laporan Penjualan</h5>
            <div>
                <a href="{{ route('laporan.print-penjualan', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                    target="_blank" class="btn btn-success btn-sm">
                    <i class="bi bi-printer me-1"></i> Cetak PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Section -->
            <div class="card mb-4 bg-light">
                <div class="card-body">
                    <form method="GET" action="{{ route('laporan.penjualan') }}" class="row g-3" id="filterForm">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ $startDate }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ $endDate }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="group_by" class="form-label">Kelompokkan Berdasarkan</label>
                            <select class="form-select" id="group_by" name="group_by">
                                <option value="day" {{ request('group_by') == 'day' ? 'selected' : '' }}>Harian</option>
                                <option value="month" {{ request('group_by') == 'month' ? 'selected' : '' }}>Bulanan
                                </option>
                                <option value="year" {{ request('group_by') == 'year' ? 'selected' : '' }}>Tahunan
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-1"></i> Tampilkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0">Total Transaksi</h6>
                                    <h4 class="mt-2 fw-bold">{{ $totalTransaksi }}</h4>
                                </div>
                                <i class="bi bi-receipt fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0">Total Penjualan</h6>
                                    <h4 class="mt-2 fw-bold">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h4>
                                </div>
                                <i class="bi bi-cash-coin fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0">Rata-rata Transaksi</h6>
                                    @php
                                        $average = $totalTransaksi > 0 ? $totalPenjualan / $totalTransaksi : 0;
                                    @endphp
                                    <h4 class="mt-2 fw-bold">Rp {{ number_format($average, 0, ',', '.') }}</h4>
                                </div>
                                <i class="bi bi-graph-up fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0">Periode Laporan</h6>
                                    <h6 class="mt-2 fw-bold">
                                        {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}<br>
                                        s/d<br>
                                        {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
                                    </h6>
                                </div>
                                <i class="bi bi-calendar-range fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($transaksis->count() > 0)
                <!-- Sales Chart -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Grafik Penjualan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="100"></canvas>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="salesTable">
                        <thead class="table-dark">
                            <tr>
                                <th width="50">No</th>
                                <th>No. Transaksi</th>
                                <th>Tanggal</th>
                                <th>Nama Pembeli</th>
                                <th class="text-end">Total Harga</th>
                                <th class="text-end">Bayar</th>
                                <th class="text-end">Kembalian</th>
                                <th class="text-center">Item</th>
                                <th width="100" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $index => $transaksi)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('transaksi.struk', $transaksi->id) }}"
                                            class="text-decoration-none">
                                            <span class="badge bg-info">{{ $transaksi->kode_transaksi }}</span>
                                        </a>
                                    </td>
                                    <td>{{ $transaksi->tanggal_transaksi->translatedFormat('d M Y H:i') }}</td>
                                    <td>{{ $transaksi->nama_pembeli }}</td>
                                    <td class="text-end fw-bold text-success">
                                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end">
                                        Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-light text-dark">
                                            Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $transaksi->details->count() }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('transaksi.struk', $transaksi->id) }}"
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
                                <td class="text-end fw-bold text-success">
                                    Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                                </td>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Sales by Medicine -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-capsule me-2"></i>Penjualan per Obat</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th class="text-center">Terjual</th>
                                        <th class="text-end">Total Penjualan</th>
                                        <th class="text-end">% dari Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $medicineSales = [];
                                        foreach ($transaksis as $transaksi) {
                                            foreach ($transaksi->details as $detail) {
                                                $medicineId = $detail->obat_id;
                                                if (!isset($medicineSales[$medicineId])) {
                                                    $medicineSales[$medicineId] = [
                                                        'nama' => $detail->obat->nama_obat,
                                                        'terjual' => 0,
                                                        'total' => 0,
                                                    ];
                                                }
                                                $medicineSales[$medicineId]['terjual'] += $detail->jumlah;
                                                $medicineSales[$medicineId]['total'] += $detail->subtotal;
                                            }
                                        }
                                        // Sort by total descending
                                        usort($medicineSales, function ($a, $b) {
                                            return $b['total'] - $a['total'];
                                        });
                                    @endphp
                                    @foreach ($medicineSales as $medicine)
                                        <tr>
                                            <td>{{ $medicine['nama'] }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $medicine['terjual'] }}</span>
                                            </td>
                                            <td class="text-end fw-bold">
                                                Rp {{ number_format($medicine['total'], 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                @php
                                                    $percentage =
                                                        $totalPenjualan > 0
                                                            ? ($medicine['total'] / $totalPenjualan) * 100
                                                            : 0;
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $percentage > 20 ? 'success' : ($percentage > 10 ? 'info' : 'secondary') }}">
                                                    {{ number_format($percentage, 1) }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-graph-up display-1 text-muted"></i>
                    <h4 class="mt-3 text-muted">Tidak Ada Data Penjualan</h4>
                    <p class="text-muted">Tidak ada transaksi pada periode yang dipilih</p>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <script>
            $(document).ready(function() {
                // Date validation
                $('#start_date, #end_date').on('change', function() {
                    let start = $('#start_date').val();
                    let end = $('#end_date').val();

                    if (start && end && new Date(start) > new Date(end)) {
                        alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                        $('#start_date').val('');
                        $('#end_date').val('');
                    }
                });

                @if ($transaksis->count() > 0)
                    // Prepare chart data
                    let salesData = {!! json_encode(
                        $transaksis->groupBy(function ($item) {
                                return \Carbon\Carbon::parse($item->tanggal_transaksi)->format('Y-m-d');
                            })->map(function ($group) {
                                return $group->sum('total_harga');
                            }),
                    ) !!};

                    let labels = Object.keys(salesData).sort();
                    let data = labels.map(date => salesData[date]);

                    // Create chart
                    let ctx = document.getElementById('salesChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Penjualan (Rp)',
                                data: data,
                                borderColor: '#435ebe',
                                backgroundColor: 'rgba(67, 94, 190, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + value.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            }
                        }
                    });
                @endif

                // Export functionality
                $('#exportExcel').click(function() {
                    let start = $('#start_date').val();
                    let end = $('#end_date').val();
                    let groupBy = $('#group_by').val();

                    window.location.href = '{{ route('laporan.export-excel') }}?start_date=' + start +
                        '&end_date=' + end + '&group_by=' + groupBy;
                });
            });
        </script>
    @endpush
@endsection
