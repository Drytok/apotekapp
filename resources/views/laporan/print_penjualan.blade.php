<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - {{ date('d/m/Y') }}</title>
    <style>
        /* Print-friendly styles */
        @page {
            margin: 15px;
            size: A4 landscape;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        /* Header Styles */
        .header {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            margin: 2px 0;
            color: #333;
        }

        .header h2 {
            font-size: 14px;
            margin: 2px 0;
            color: #666;
        }

        .header p {
            margin: 1px 0;
            font-size: 9px;
            color: #777;
        }

        /* Report Info */
        .report-info {
            display: flex;
            justify-content: space-between;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 3px;
            padding: 8px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .info-item {
            flex: 1;
            min-width: 150px;
            margin: 2px 0;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            min-width: 100px;
        }

        /* Summary Stats */
        .summary-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }

        .stat-box {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px;
            text-align: center;
        }

        .stat-number {
            font-size: 16px;
            font-weight: bold;
            color: #435ebe;
        }

        .stat-label {
            font-size: 9px;
            color: #6c757d;
            margin-top: 3px;
        }

        .stat-box.success {
            border-left: 4px solid #28a745;
        }

        .stat-box.primary {
            border-left: 4px solid #007bff;
        }

        .stat-box.warning {
            border-left: 4px solid #ffc107;
        }

        .stat-box.info {
            border-left: 4px solid #17a2b8;
        }

        /* Table Styles */
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        thead {
            background-color: #343a40;
            color: white;
        }

        th {
            font-weight: bold;
            text-align: left;
            padding: 5px 3px;
            border: 1px solid #dee2e6;
            white-space: nowrap;
        }

        td {
            padding: 4px 3px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-bold {
            font-weight: bold;
        }

        /* Status badges */
        .badge {
            display: inline-block;
            padding: 1px 4px;
            font-size: 8px;
            font-weight: bold;
            border-radius: 2px;
            text-align: center;
            min-width: 40px;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-primary {
            background-color: #007bff;
            color: white;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        /* Medicine Sales Section */
        .medicine-sales {
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            border-bottom: 2px solid #333;
            padding-bottom: 3px;
            margin-bottom: 8px;
            color: #495057;
        }

        .medicines-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .medicine-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 3px;
            padding: 6px;
        }

        .medicine-name {
            font-weight: bold;
            font-size: 9px;
            margin-bottom: 2px;
        }

        .medicine-details {
            display: flex;
            justify-content: space-between;
            font-size: 8px;
        }

        /* Charts (print as image) */
        .chart-placeholder {
            border: 1px dashed #ccc;
            padding: 10px;
            text-align: center;
            margin: 10px 0;
            background-color: #f9f9f9;
        }

        /* Footer */
        .footer {
            margin-top: 20px;
            border-top: 2px solid #333;
            padding-top: 10px;
            text-align: center;
            font-size: 8px;
            color: #666;
            page-break-inside: avoid;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 8px;
        }

        .signature {
            margin-top: 20px;
        }

        .signature-line {
            width: 150px;
            border-top: 1px solid #333;
            margin: 0 auto;
            padding-top: 3px;
        }

        /* Print-specific styles */
        @media print {
            body {
                font-size: 8px;
            }

            .header h1 {
                font-size: 16px;
            }

            .header h2 {
                font-size: 12px;
            }

            th,
            td {
                padding: 3px 2px;
                font-size: 8px;
            }

            .stat-number {
                font-size: 14px;
            }

            .no-print {
                display: none !important;
            }

            .page-break {
                page-break-before: always;
            }

            .avoid-break {
                page-break-inside: avoid;
            }
        }

        /* Transaction details styling */
        .transaction-details {
            font-size: 8px;
            color: #666;
        }

        .item-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .item-list li {
            padding: 1px 0;
            border-bottom: 1px dotted #eee;
        }

        /* Highlight rows */
        .highlight-row {
            background-color: #e8f5e8 !important;
        }

        .warning-row {
            background-color: #fff3cd !important;
        }

        /* Period info */
        .period-info {
            background-color: #e7f3ff;
            border: 1px solid #b8daff;
            border-radius: 3px;
            padding: 6px;
            margin-bottom: 10px;
            font-size: 9px;
        }

        .period-dates {
            font-weight: bold;
            color: #004085;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>APOTEK SEHAT</h1>
            <h2>LAPORAN PENJUALAN</h2>
            <p>Jl. Kesehatan No. 123, Jakarta - Telp: (021) 1234-5678</p>
            <p>Email: info@apoteksehat.com | Website: www.apoteksehat.com</p>
            <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
        </div>

        <!-- Period Info -->
        <div class="period-info">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong>Periode Laporan:</strong>
                    <span class="period-dates">
                        {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
                    </span>
                </div>
                <div>
                    <strong>Durasi:</strong>
                    {{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1 }} hari
                </div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="summary-stats">
            <div class="stat-box success">
                <div class="stat-number">{{ $totalTransaksi }}</div>
                <div class="stat-label">Total Transaksi</div>
            </div>
            <div class="stat-box primary">
                <div class="stat-number">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
                <div class="stat-label">Total Penjualan</div>
            </div>
            <div class="stat-box warning">
                <div class="stat-number">
                    @php
                        $averageTransaction = $totalTransaksi > 0 ? $totalPenjualan / $totalTransaksi : 0;
                    @endphp
                    Rp {{ number_format($averageTransaction, 0, ',', '.') }}
                </div>
                <div class="stat-label">Rata-rata per Transaksi</div>
            </div>
            <div class="stat-box info">
                <div class="stat-number">
                    @php
                        $totalItems = 0;
                        foreach ($transaksis as $transaksi) {
                            $totalItems += $transaksi->details->sum('jumlah');
                        }
                    @endphp
                    {{ $totalItems }}
                </div>
                <div class="stat-label">Total Item Terjual</div>
            </div>
        </div>

        <!-- Daily Summary -->
        @php
            $dailySales = [];
            $dailyTransactions = [];

            foreach ($transaksis as $transaksi) {
                $date = $transaksi->tanggal_transaksi->format('Y-m-d');

                if (!isset($dailySales[$date])) {
                    $dailySales[$date] = 0;
                    $dailyTransactions[$date] = 0;
                }

                $dailySales[$date] += $transaksi->total_harga;
                $dailyTransactions[$date]++;
            }

            ksort($dailySales);

            $peakDay = null;
            $lowDay = null;

            if (!empty($dailySales)) {
                $peakDay = array_search(max($dailySales), $dailySales);
                $lowDay = array_search(min($dailySales), $dailySales);
            }
        @endphp


        @if (count($dailySales) > 0)
            <div style="margin-bottom: 15px; page-break-inside: avoid;">
                <div class="section-title">Ringkasan Harian</div>
                <div style="font-size: 9px; background-color: #f8f9fa; padding: 6px; border-radius: 3px;">
                    <strong>Hari dengan penjualan tertinggi:</strong>
                    {{ \Carbon\Carbon::parse($peakDay)->translatedFormat('d F Y') }}
                    (Rp {{ number_format($dailySales[$peakDay], 0, ',', '.') }})<br>

                    <strong>Total hari berpenjualan:</strong> {{ count($dailySales) }} dari
                    {{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1 }} hari<br>

                    <strong>Rata-rata penjualan per hari:</strong>
                    Rp {{ number_format(array_sum($dailySales) / max(1, count($dailySales)), 0, ',', '.') }}
                </div>
            </div>
        @endif

        <!-- Main Transactions Table -->
        <div class="table-container">
            <div class="section-title">Daftar Transaksi</div>
            <table>
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th width="100">No. Transaksi</th>
                        <th width="80">Tanggal</th>
                        <th width="120">Nama Pembeli</th>
                        <th width="150">Detail Obat</th>
                        <th width="60" class="text-center">Item</th>
                        <th width="80" class="text-right">Total Harga</th>
                        <th width="80" class="text-right">Bayar</th>
                        <th width="80" class="text-right">Kembalian</th>
                        <th width="100" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksis as $index => $transaksi)
                        @php
                            $totalItems = $transaksi->details->sum('jumlah');
                            $isLargeTransaction = $transaksi->total_harga > $averageTransaction * 1.5;
                            $isSmallTransaction = $transaksi->total_harga < $averageTransaction * 0.5;
                        @endphp
                        <tr
                            class="{{ $isLargeTransaction ? 'highlight-row' : ($isSmallTransaction ? 'warning-row' : '') }}">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-bold">{{ $transaksi->kode_transaksi }}</td>
                            <td>{{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</td>
                            <td>{{ $transaksi->nama_pembeli }}</td>
                            <td>
                                <div class="transaction-details">
                                    <ul class="item-list">
                                        @foreach ($transaksi->details->take(2) as $detail)
                                            <li>{{ $detail->obat->nama_obat }} ({{ $detail->jumlah }})</li>
                                        @endforeach
                                        @if ($transaksi->details->count() > 2)
                                            <li>+ {{ $transaksi->details->count() - 2 }} obat lainnya</li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $totalItems }}</span>
                            </td>
                            <td class="text-right text-bold">
                                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="text-right">
                                Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}
                            </td>
                            <td class="text-right">
                                <span class="badge badge-info">Rp
                                    {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-center">
                                @if ($isLargeTransaction)
                                    <span class="badge badge-success">BESAR</span>
                                @elseif($isSmallTransaction)
                                    <span class="badge badge-warning">KECIL</span>
                                @else
                                    <span class="badge">NORMAL</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: #e9ecef; font-weight: bold;">
                        <td colspan="5" class="text-right">TOTAL:</td>
                        <td class="text-center">{{ $totalItems }}</td>
                        <td class="text-right">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Medicine Sales Analysis -->
        @php
            $medicineSales = [];
            foreach ($transaksis as $transaksi) {
                foreach ($transaksi->details as $detail) {
                    $medicineId = $detail->obat_id;
                    if (!isset($medicineSales[$medicineId])) {
                        $medicineSales[$medicineId] = [
                            'nama' => $detail->obat->nama_obat,
                            'terjual' => 0,
                            'pendapatan' => 0,
                        ];
                    }
                    $medicineSales[$medicineId]['terjual'] += $detail->jumlah;
                    $medicineSales[$medicineId]['pendapatan'] += $detail->subtotal;
                }
            }

            // Sort by revenue descending
            usort($medicineSales, function ($a, $b) {
                return $b['pendapatan'] - $a['pendapatan'];
            });

            $topMedicines = array_slice($medicineSales, 0, 5);
        @endphp

        @if (count($medicineSales) > 0)
            <div class="medicine-sales avoid-break">
                <div class="section-title">Analisis Penjualan per Obat</div>

                <!-- Top 5 Medicines -->
                <div style="margin-bottom: 15px;">
                    <div style="font-size: 10px; font-weight: bold; margin-bottom: 5px; color: #495057;">
                        🏆 5 OBAT TERLARIS (BERDASARKAN PENDAPATAN)
                    </div>
                    <div class="medicines-grid">
                        @foreach ($topMedicines as $medicine)
                            <div class="medicine-card">
                                <div class="medicine-name">{{ $medicine['nama'] }}</div>
                                <div class="medicine-details">
                                    <span>Terjual: <strong>{{ $medicine['terjual'] }}</strong></span>
                                    <span>Pendapatan: <strong>Rp
                                            {{ number_format($medicine['pendapatan'], 0, ',', '.') }}</strong></span>
                                </div>
                                <div style="font-size: 8px; color: #6c757d; margin-top: 2px;">
                                    {{ $totalPenjualan > 0 ? number_format(($medicine['pendapatan'] / $totalPenjualan) * 100, 1) : 0 }}%
                                    dari total
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Complete Medicine Sales Table -->
                <div style="margin-top: 15px;">
                    <div style="font-size: 10px; font-weight: bold; margin-bottom: 5px; color: #495057;">
                        📊 SELURUH PENJUALAN OBAT
                    </div>
                    <div style="max-height: 200px; overflow-y: auto;">
                        <table style="font-size: 8px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat</th>
                                    <th class="text-center">Terjual</th>
                                    <th class="text-right">Pendapatan</th>
                                    <th class="text-center">% dari Total</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medicineSales as $index => $medicine)
                                    @php
                                        $percentage =
                                            $totalPenjualan > 0 ? ($medicine['pendapatan'] / $totalPenjualan) * 100 : 0;
                                        $category = '';
                                        if ($percentage >= 20) {
                                            $category = 'SANGAT BAIK';
                                        } elseif ($percentage >= 10) {
                                            $category = 'BAIK';
                                        } elseif ($percentage >= 5) {
                                            $category = 'CUKUP';
                                        } else {
                                            $category = 'RENDAH';
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $medicine['nama'] }}</td>
                                        <td class="text-center">{{ $medicine['terjual'] }}</td>
                                        <td class="text-right">Rp
                                            {{ number_format($medicine['pendapatan'], 0, ',', '.') }}</td>
                                        <td class="text-center">{{ number_format($percentage, 1) }}%</td>
                                        <td class="text-center">{{ $category }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Performance Metrics -->
        <div style="margin-top: 20px; page-break-inside: avoid;">
            <div class="section-title">Metrik Kinerja</div>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                <div style="background-color: #f8f9fa; padding: 8px; border-radius: 3px;">
                    <div style="font-size: 9px; font-weight: bold; margin-bottom: 3px;">📈 Tren Penjualan</div>
                    <div style="font-size: 8px;">
                        @if (count($dailySales) >= 2)
                            @php
                                $salesArray = array_values($dailySales);
                                $firstDay = reset($dailySales);
                                $lastDay = end($dailySales);
                                $growth = $firstDay > 0 ? (($lastDay - $firstDay) / $firstDay) * 100 : 0;
                            @endphp
                            @if ($growth > 0)
                                <span style="color: #28a745;">▲ {{ number_format($growth, 1) }}% pertumbuhan</span>
                            @elseif($growth < 0)
                                <span style="color: #dc3545;">▼ {{ number_format(abs($growth), 1) }}% penurunan</span>
                            @else
                                <span style="color: #6c757d;">→ Stagnan</span>
                            @endif
                        @else
                            <span style="color: #6c757d;">Data tren tidak tersedia</span>
                        @endif
                    </div>
                </div>

                <div style="background-color: #f8f9fa; padding: 8px; border-radius: 3px;">
                    <div style="font-size: 9px; font-weight: bold; margin-bottom: 3px;">🎯 Target Pencapaian</div>
                    <div style="font-size: 8px;">
                        @php
                            $daysInPeriod =
                                \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1;
                            $dailyTarget = 1000000; // Contoh target harian 1 juta
                            $totalTarget = $dailyTarget * $daysInPeriod;
                            $achievementRate = $totalTarget > 0 ? ($totalPenjualan / $totalTarget) * 100 : 0;
                        @endphp
                        Target: Rp {{ number_format($totalTarget, 0, ',', '.') }}<br>
                        Pencapaian: <strong>{{ number_format($achievementRate, 1) }}%</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        @if (count($topMedicines) > 0)
            <div style="margin-top: 20px; page-break-inside: avoid;">
                <div class="section-title">Rekomendasi</div>
                <div style="background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 3px; padding: 8px;">
                    <div style="font-size: 9px; font-weight: bold; color: #155724; margin-bottom: 3px;">
                        💡 Saran Berdasarkan Analisis
                    </div>
                    <ul style="margin: 0; padding-left: 15px; font-size: 8px; color: #155724;">
                        <li>Tingkatkan stok untuk obat terlaris: <strong>{{ $topMedicines[0]['nama'] }}</strong></li>
                        <li>Promosikan obat dengan pendapatan tinggi di tempat strategis</li>
                        <li>Analisis hari dengan penjualan rendah untuk perbaikan strategi</li>
                        <li>Pertimbangkan diskon untuk obat dengan penjualan rendah</li>
                    </ul>
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div class="footer-grid">
                <div>
                    <strong>Informasi Laporan:</strong><br>
                    Laporan No: PNJ-{{ date('Ymd') }}-{{ str_pad($totalTransaksi, 3, '0', STR_PAD_LEFT) }}<br>
                    Jenis: Penjualan Periodik<br>
                    Status: Final
                </div>
                <div>
                    <strong>Validasi Data:</strong><br>
                    Diperiksa oleh sistem<br>
                    Tanggal validasi: {{ date('d/m/Y') }}<br>
                    Versi laporan: 1.0
                </div>
                <div>
                    <strong>Distribusi:</strong><br>
                    1. Manager Apotek<br>
                    2. Bagian Keuangan<br>
                    3. Arsip
                </div>
            </div>

            <div class="signature">
                <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                    <div style="width: 30%;">
                        <div class="signature-line"></div>
                        <div style="text-align: center; margin-top: 3px; font-size: 8px;">
                            Kasir
                        </div>
                    </div>
                    <div style="width: 30%;">
                        <div class="signature-line"></div>
                        <div style="text-align: center; margin-top: 3px; font-size: 8px;">
                            Manager Operasional
                        </div>
                    </div>
                    <div style="width: 30%;">
                        <div class="signature-line"></div>
                        <div style="text-align: center; margin-top: 3px; font-size: 8px;">
                            Direktur
                        </div>
                    </div>
                </div>
            </div>

            <p style="margin-top: 15px; font-size: 7px; color: #999;">
                ** Laporan ini merupakan dokumen resmi dan dapat digunakan untuk analisis kinerja **<br>
                Halaman: 1/1 | Dicetak oleh: Sistem Aplikasi Apotek v1.0 |
                Periode: {{ $startDate }} s/d {{ $endDate }}
            </p>
        </div>

        <!-- Print Controls (Only in browser) -->
        <div class="no-print"
            style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; background: white; padding: 10px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <button onclick="window.print()"
                style="background-color: #28a745; color: white; border: none; 
                    padding: 8px 15px; border-radius: 3px; cursor: pointer; font-size: 10px; font-weight: bold; margin-right: 5px;">
                🖨️ Cetak
            </button>
            <button onclick="window.close()"
                style="background-color: #dc3545; color: white; border: none; 
                    padding: 8px 15px; border-radius: 3px; cursor: pointer; font-size: 10px; font-weight: bold;">
                ✕ Tutup
            </button>
        </div>
    </div>

    <script>
        // Auto print when opened
        window.onload = function() {
            // Auto print after 1 second
            setTimeout(function() {
                window.print();
            }, 1000);
        };

        // Add page numbers
        function addPageNumbers() {
            var totalPages = Math.ceil(document.body.scrollHeight / window.innerHeight);
            for (var i = 1; i <= totalPages; i++) {
                var pageNum = document.createElement('div');
                pageNum.style.position = 'absolute';
                pageNum.style.bottom = '10px';
                pageNum.style.right = '10px';
                pageNum.style.fontSize = '8px';
                pageNum.style.color = '#666';
                pageNum.innerHTML = 'Hal ' + i + '/' + totalPages;
                pageNum.className = 'page-number';
                document.body.appendChild(pageNum);
            }
        }

        // Call function after page loads
        setTimeout(addPageNumbers, 500);

        // Add watermark for draft
        @if (isset($draft) && $draft)
            function addDraftWatermark() {
                var watermark = document.createElement('div');
                watermark.innerHTML = 'DRAFT - BELUM DISETUJUI';
                watermark.style.position = 'fixed';
                watermark.style.top = '50%';
                watermark.style.left = '50%';
                watermark.style.transform = 'translate(-50%, -50%) rotate(-45deg)';
                watermark.style.fontSize = '50px';
                watermark.style.color = 'rgba(255,0,0,0.1)';
                watermark.style.zIndex = '9999';
                watermark.style.pointerEvents = 'none';
                watermark.style.fontWeight = 'bold';
                watermark.style.letterSpacing = '5px';
                document.body.appendChild(watermark);
            }
            addDraftWatermark();
        @endif

        // Highlight large transactions
        function highlightTransactions() {
            var rows = document.querySelectorAll('tbody tr');
            var amounts = [];

            // Collect all transaction amounts
            rows.forEach(function(row) {
                var amountCell = row.querySelector('td:nth-child(7)'); // Total harga column
                if (amountCell) {
                    var amountText = amountCell.textContent.replace(/[^0-9]/g, '');
                    var amount = parseInt(amountText) || 0;
                    amounts.push(amount);
                }
            });

            // Calculate average
            var average = amounts.length > 0 ? amounts.reduce((a, b) => a + b, 0) / amounts.length : 0;

            // Apply highlights
            rows.forEach(function(row) {
                var amountCell = row.querySelector('td:nth-child(7)');
                if (amountCell) {
                    var amountText = amountCell.textContent.replace(/[^0-9]/g, '');
                    var amount = parseInt(amountText) || 0;

                    if (amount > average * 1.5) {
                        row.style.backgroundColor = '#e8f5e8';
                    } else if (amount < average * 0.5) {
                        row.style.backgroundColor = '#fff3cd';
                    }
                }
            });
        }

        // Call highlight function
        setTimeout(highlightTransactions, 100);
    </script>
</body>

</html>
