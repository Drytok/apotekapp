<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Obat - {{ date('d/m/Y') }}</title>
    <style>
        /* Print-friendly styles */
        @page {
            margin: 20px;
            size: A4 portrait;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Header Styles */
        .header {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 22px;
            margin: 5px 0;
            color: #333;
        }

        .header h2 {
            font-size: 16px;
            margin: 5px 0;
            color: #666;
        }

        .header p {
            margin: 3px 0;
            font-size: 11px;
            color: #777;
        }

        /* Info Box */
        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            min-width: 150px;
        }

        .info-value {
            flex-grow: 1;
            text-align: right;
        }

        /* Table Styles */
        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background-color: #343a40;
            color: white;
        }

        th {
            font-weight: bold;
            text-align: left;
            padding: 8px 6px;
            border: 1px solid #dee2e6;
            font-size: 11px;
        }

        td {
            padding: 6px;
            border: 1px solid #dee2e6;
            font-size: 11px;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        /* Status badges */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 3px;
            text-align: center;
            min-width: 50px;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        /* Summary Section */
        .summary {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 15px;
            margin-top: 30px;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #495057;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .summary-item {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 10px;
            text-align: center;
        }

        .summary-number {
            font-size: 18px;
            font-weight: bold;
            color: #435ebe;
        }

        .summary-label {
            font-size: 11px;
            color: #6c757d;
            margin-top: 5px;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            border-top: 2px solid #333;
            padding-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 10px;
        }

        .signature {
            margin-top: 40px;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid #333;
            margin: 0 auto;
            padding-top: 5px;
        }

        /* Print-specific styles */
        @media print {
            body {
                font-size: 10px;
            }

            .header h1 {
                font-size: 18px;
            }

            .header h2 {
                font-size: 14px;
            }

            th,
            td {
                padding: 4px 3px;
                font-size: 9px;
            }

            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .no-print {
                display: none !important;
            }

            .page-break {
                page-break-before: always;
            }
        }

        /* Stock level indicators */
        .stock-high {
            color: #28a745;
            font-weight: bold;
        }

        .stock-medium {
            color: #ffc107;
            font-weight: bold;
        }

        .stock-low {
            color: #dc3545;
            font-weight: bold;
        }

        .stock-critical {
            background-color: #f8d7da;
            color: #721c24;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>APOTEK SEHAT</h1>
            <h2>LAPORAN STOK OBAT</h2>
            <p>Jl. Kesehatan No. 123, Jakarta - Telp: (021) 1234-5678</p>
            <p>Email: info@apoteksehat.com | Website: www.apoteksehat.com</p>
            <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
        </div>

        <!-- Report Info -->
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Periode Laporan:</span>
                <span class="info-value">{{ date('d F Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Total Jenis Obat:</span>
                <span class="info-value">{{ $obats->count() }} jenis</span>
            </div>
            <div class="info-row">
                <span class="info-label">Total Nilai Stok:</span>
                <span class="info-value">Rp {{ number_format($totalNilai, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Dicetak Oleh:</span>
                <span class="info-value">Sistem Aplikasi Apotek</span>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="summary">
            <div class="summary-title">Ringkasan Stok Obat</div>
            <div class="summary-grid">
                @php
                    $stokAman = $obats->where('stock_obat', '>=', 20)->count();
                    $stokHatiHati = $obats->whereBetween('stock_obat', [10, 19])->count();
                    $stokKritis = $obats->where('stock_obat', '<', 10)->count();
                    $stokHabis = $obats->where('stock_obat', 0)->count();

                    $totalUnit = $obats->sum('stock_obat');
                @endphp

                <div class="summary-item">
                    <div class="summary-number">{{ $obats->count() }}</div>
                    <div class="summary-label">Jenis Obat</div>
                </div>
                <div class="summary-item">
                    <div class="summary-number">{{ $totalUnit }}</div>
                    <div class="summary-label">Total Unit</div>
                </div>
                <div class="summary-item">
                    <div class="summary-number">{{ $stokAman }}</div>
                    <div class="summary-label">Stok Aman</div>
                </div>
                <div class="summary-item">
                    <div class="summary-number">{{ $stokKritis }}</div>
                    <div class="summary-label">Stok Kritis</div>
                </div>
            </div>
        </div>

        <!-- Stock Status Legend -->
        <div style="margin-bottom: 15px; font-size: 10px;">
            <strong>Keterangan Status Stok:</strong>
            <span class="badge badge-success" style="margin: 0 5px;">Aman (≥ 20)</span>
            <span class="badge badge-warning" style="margin: 0 5px;">Hati-hati (10-19)</span>
            <span class="badge badge-danger" style="margin: 0 5px;">Kritis (< 10)</span>
                    <span class="badge badge-info" style="margin: 0 5px;">Habis (0)</span>
        </div>

        <!-- Main Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th width="100">Kode Obat</th>
                        <th>Nama Obat</th>
                        <th width="80">Satuan</th>
                        <th width="100" class="text-right">Harga Satuan</th>
                        <th width="80" class="text-center">Stok</th>
                        <th width="100" class="text-center">Status</th>
                        <th width="120" class="text-right">Nilai Stok</th>
                        <th width="80" class="text-center">% dari Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($obats as $index => $obat)
                        @php
                            $nilaiStok = $obat->harga_obat * $obat->stock_obat;
                            $persentase = $totalNilai > 0 ? ($nilaiStok / $totalNilai) * 100 : 0;

                            if ($obat->stock_obat >= 20) {
                                $statusClass = 'badge-success';
                                $statusText = 'Aman';
                                $stockClass = 'stock-high';
                            } elseif ($obat->stock_obat >= 10) {
                                $statusClass = 'badge-warning';
                                $statusText = 'Hati-hati';
                                $stockClass = 'stock-medium';
                            } elseif ($obat->stock_obat > 0) {
                                $statusClass = 'badge-danger';
                                $statusText = 'Kritis';
                                $stockClass = 'stock-low';
                            } else {
                                $statusClass = 'badge-info';
                                $statusText = 'Habis';
                                $stockClass = 'stock-critical';
                            }
                        @endphp
                        <tr class="{{ $stockClass }}">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-bold">{{ $obat->kode_obat }}</td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td class="text-center">{{ $obat->satuan_obat }}</td>
                            <td class="text-right">Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}</td>
                            <td class="text-center text-bold">{{ $obat->stock_obat }}</td>
                            <td class="text-center">
                                <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td class="text-right text-bold">Rp {{ number_format($nilaiStok, 0, ',', '.') }}</td>
                            <td class="text-center">{{ number_format($persentase, 1) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: #e9ecef; font-weight: bold;">
                        <td colspan="4" class="text-right">TOTAL:</td>
                        <td class="text-right">-</td>
                        <td class="text-center">{{ $totalUnit }}</td>
                        <td class="text-center">-</td>
                        <td class="text-right">Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
                        <td class="text-center">100%</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Stock Analysis -->
        <div style="margin-top: 30px; page-break-inside: avoid;">
            <h3 style="font-size: 14px; margin-bottom: 10px; border-bottom: 1px solid #333; padding-bottom: 5px;">
                Analisis Stok Obat
            </h3>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                <div>
                    <h4 style="font-size: 12px; margin-bottom: 5px;">Stok Terbanyak (Top 5)</h4>
                    <ol style="margin: 0; padding-left: 15px; font-size: 11px;">
                        @foreach ($obats->sortByDesc('stock_obat')->take(5) as $obat)
                            <li>{{ $obat->nama_obat }} ({{ $obat->stock_obat }} unit)</li>
                        @endforeach
                    </ol>
                </div>

                <div>
                    <h4 style="font-size: 12px; margin-bottom: 5px;">Nilai Stok Tertinggi (Top 5)</h4>
                    <ol style="margin: 0; padding-left: 15px; font-size: 11px;">
                        @foreach ($obats->sortByDesc(function ($obat) {
            return $obat->harga_obat * $obat->stock_obat;
        })->take(5) as $obat)
                            @php $nilai = $obat->harga_obat * $obat->stock_obat; @endphp
                            <li>{{ $obat->nama_obat }} (Rp {{ number_format($nilai, 0, ',', '.') }})</li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <!-- Critical Stock Warning -->
            @if ($stokKritis > 0 || $stokHabis > 0)
                <div
                    style="background-color: #fff3cd; border: 1px solid #ffeaa7; border-left: 4px solid #f39c12; 
                        padding: 10px; margin-top: 15px; border-radius: 4px;">
                    <h4 style="font-size: 12px; margin: 0 0 8px 0; color: #856404;">
                        ⚠️ PERHATIAN: OBAT DENGAN STOK RENDAH
                    </h4>
                    <p style="margin: 0; font-size: 11px; color: #856404;">
                        Terdapat <strong>{{ $stokKritis + $stokHabis }} obat</strong> dengan stok rendah atau habis
                        yang memerlukan perhatian segera:
                    </p>
                    <ul style="margin: 8px 0 0 0; padding-left: 15px; font-size: 11px; color: #856404;">
                        @foreach ($obats->where('stock_obat', '<', 10)->sortBy('stock_obat') as $obat)
                            <li>
                                {{ $obat->nama_obat }} (Kode: {{ $obat->kode_obat }}) -
                                Stok: <strong>{{ $obat->stock_obat }}</strong> unit -
                                Status: <strong>{{ $obat->stock_obat == 0 ? 'HABIS' : 'KRITIS' }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-grid">
                <div>
                    <strong>Informasi:</strong><br>
                    Laporan ini dibuat otomatis oleh sistem.<br>
                    Data bersifat real-time pada saat dicetak.
                </div>
                <div>
                    <strong>Validasi:</strong><br>
                    Periksa stok fisik secara berkala.<br>
                    Update data stok setiap ada perubahan.
                </div>
                <div>
                    <strong>Siklus Stok:</strong><br>
                    Rekomendasi restock: setiap 2 minggu.<br>
                    Minimum stok: 10 unit per obat.
                </div>
            </div>

            <div style="margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; margin-top: 30px;">
                    <div style="width: 30%;">
                        <div class="signature-line"></div>
                        <div style="text-align: center; margin-top: 5px; font-size: 10px;">
                            Penanggung Jawab Gudang
                        </div>
                    </div>
                    <div style="width: 30%;">
                        <div class="signature-line"></div>
                        <div style="text-align: center; margin-top: 5px; font-size: 10px;">
                            Manager Apotek
                        </div>
                    </div>
                    <div style="width: 30%;">
                        <div class="signature-line"></div>
                        <div style="text-align: center; margin-top: 5px; font-size: 10px;">
                            Direktur
                        </div>
                    </div>
                </div>
            </div>

            <p style="margin-top: 30px; font-size: 9px; color: #999;">
                ** Dokumen ini sah dan dapat digunakan sebagai acuan manajemen stok **<br>
                Laporan No: STK-{{ date('Ymd') }}-{{ str_pad($obats->count(), 3, '0', STR_PAD_LEFT) }} |
                Halaman: 1/1 | Dicetak oleh: Sistem Aplikasi Apotek v1.0
            </p>
        </div>

        <!-- Print Controls (Only in browser) -->
        <div class="no-print" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
            <button onclick="window.print()"
                style="background-color: #435ebe; color: white; border: none; 
                    padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">
                🖨️ Cetak Laporan
            </button>
            <button onclick="window.close()"
                style="background-color: #dc3545; color: white; border: none; 
                    margin-left: 10px; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">
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

        // Close window after print (in some browsers)
        window.onafterprint = function() {
            // Optional: close window after printing
            // setTimeout(function() {
            //     window.close();
            // }, 500);
        };

        // Add page numbers if needed
        function addPageNumbers() {
            var totalPages = Math.ceil(document.body.scrollHeight / window.innerHeight);
            for (var i = 1; i <= totalPages; i++) {
                var pageNum = document.createElement('div');
                pageNum.style.position = 'absolute';
                pageNum.style.bottom = '20px';
                pageNum.style.right = '20px';
                pageNum.style.fontSize = '10px';
                pageNum.style.color = '#666';
                pageNum.innerHTML = 'Halaman ' + i + ' dari ' + totalPages;
                pageNum.className = 'page-number';
                document.body.appendChild(pageNum);
            }
        }

        // Call function after page loads
        setTimeout(addPageNumbers, 500);
    </script>
</body>

</html>
