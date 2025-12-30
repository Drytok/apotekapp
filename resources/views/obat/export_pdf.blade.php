<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Obat - {{ date('d/m/Y') }}</title>
    <style>
        /* PDF Export Styles */
        @page {
            margin: 15px;
            size: A4 portrait;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
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
        
        /* Header */
        .header {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 20px;
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
            font-size: 10px;
            color: #777;
        }
        
        /* Metadata */
        .metadata {
            display: flex;
            justify-content: space-between;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .meta-item {
            flex: 1;
            min-width: 150px;
            margin: 3px 0;
        }
        
        .meta-label {
            font-weight: bold;
            display: inline-block;
            min-width: 120px;
        }
        
        /* Summary Box */
        .summary-box {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .summary-item {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
            text-align: center;
        }
        
        .summary-number {
            font-size: 16px;
            font-weight: bold;
            color: #435ebe;
        }
        
        .summary-label {
            font-size: 10px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        /* Table Styles */
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
            font-size: 10px;
        }
        
        td {
            padding: 6px;
            border: 1px solid #dee2e6;
            font-size: 10px;
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
        
        .text-bold {
            font-weight: bold;
        }
        
        /* Stock Status */
        .stock-status {
            display: inline-block;
            padding: 2px 6px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 3px;
            text-align: center;
            min-width: 60px;
        }
        
        .status-aman {
            background-color: #28a745;
            color: white;
        }
        
        .status-hati-hati {
            background-color: #ffc107;
            color: #212529;
        }
        
        .status-kritis {
            background-color: #dc3545;
            color: white;
        }
        
        .status-habis {
            background-color: #6c757d;
            color: white;
        }
        
        /* Category Colors */
        .category-highlight {
            background-color: #e8f5e9;
        }
        
        .category-warning {
            background-color: #fff3cd;
        }
        
        .category-danger {
            background-color: #f8d7da;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            border-top: 2px solid #333;
            padding-top: 15px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
        
        .footer-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .legend {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px;
            margin-top: 20px;
            font-size: 9px;
        }
        
        .legend-title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #495057;
        }
        
        .legend-items {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 2px;
        }
        
        /* Print-specific */
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
            
            th, td {
                padding: 5px 4px;
                font-size: 9px;
            }
            
            .no-print {
                display: none !important;
            }
        }
        
        /* Medicine details */
        .medicine-code {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #435ebe;
        }
        
        .medicine-name {
            font-weight: 500;
        }
        
        .unit-badge {
            display: inline-block;
            padding: 1px 5px;
            font-size: 9px;
            background-color: #6c757d;
            color: white;
            border-radius: 3px;
        }
        
        /* Value formatting */
        .value-high {
            color: #28a745;
            font-weight: bold;
        }
        
        .value-medium {
            color: #ffc107;
            font-weight: bold;
        }
        
        .value-low {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>APOTEK SEHAT</h1>
            <h2>DATA MASTER OBAT</h2>
            <p>Jl. Kesehatan No. 123, Jakarta - Telp: (021) 1234-5678</p>
            <p>Email: info@apoteksehat.com | Website: www.apoteksehat.com</p>
            <p>Export Date: {{ date('d F Y H:i:s') }}</p>
            <p>Report ID: OBAT-EXPORT-{{ date('Ymd-His') }}</p>
        </div>
        
        <!-- Metadata -->
        <div class="metadata">
            <div class="meta-item">
                <span class="meta-label">Total Jenis Obat:</span>
                {{ $obats->count() }}
            </div>
            <div class="meta-item">
                <span class="meta-label">Total Unit Stok:</span>
                {{ $obats->sum('stock_obat') }}
            </div>
            <div class="meta-item">
                <span class="meta-label">Total Nilai Stok:</span>
                Rp {{ number_format($totalNilai, 0, ',', '.') }}
            </div>
            <div class="meta-item">
                <span class="meta-label">Export Type:</span>
                Complete Database
            </div>
            <div class="meta-item">
                <span class="meta-label">Data Status:</span>
                Real-time
            </div>
            <div class="meta-item">
                <span class="meta-label">Generated By:</span>
                System Administrator
            </div>
        </div>
        
        <!-- Summary -->
        <div class="summary-box">
            @php
                $stokAman = $obats->where('stock_obat', '>=', 20)->count();
                $stokHatiHati = $obats->whereBetween('stock_obat', [10, 19])->count();
                $stokKritis = $obats->where('stock_obat', '<', 10)->where('stock_obat', '>', 0)->count();
                $stokHabis = $obats->where('stock_obat', 0)->count();
                
                $avgPrice = $obats->avg('harga_obat');
                $maxPrice = $obats->max('harga_obat');
                $minPrice = $obats->min('harga_obat');
            @endphp
            
            <div class="summary-item">
                <div class="summary-number">{{ $obats->count() }}</div>
                <div class="summary-label">Jenis Obat</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ $stokAman }}</div>
                <div class="summary-label">Stok Aman</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ $stokKritis + $stokHabis }}</div>
                <div class="summary-label">Perlu Restock</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">Rp {{ number_format($avgPrice, 0, ',', '.') }}</div>
                <div class="summary-label">Rata-rata Harga</div>
            </div>
        </div>
        
        <!-- Legend -->
        <div class="legend">
            <div class="legend-title">Keterangan Status Stok:</div>
            <div class="legend-items">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #28a745;"></div>
                    <span>Aman (≥ 20 unit)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #ffc107;"></div>
                    <span>Hati-hati (10-19 unit)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #dc3545;"></div>
                    <span>Kritis (1-9 unit)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #6c757d;"></div>
                    <span>Habis (0 unit)</span>
                </div>
            </div>
        </div>
        
        <!-- Main Table -->
        <table>
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th width="100">Kode Obat</th>
                    <th>Nama Obat</th>
                    <th width="70">Satuan</th>
                    <th width="90" class="text-right">Harga Satuan</th>
                    <th width="70" class="text-center">Stok</th>
                    <th width="80" class="text-center">Status</th>
                    <th width="100" class="text-right">Nilai Stok</th>
                    <th width="70" class="text-center">Last Update</th>
                    <th width="80" class="text-center">Kategori</th>
                </tr>
            </thead>
            <tbody>
                @foreach($obats as $index => $obat)
                @php
                    $nilaiStok = $obat->harga_obat * $obat->stock_obat;
                    
                    // Determine status
                    if ($obat->stock_obat >= 20) {
                        $statusClass = 'status-aman';
                        $statusText = 'AMAN';
                        $rowClass = 'category-highlight';
                    } elseif ($obat->stock_obat >= 10) {
                        $statusClass = 'status-hati-hati';
                        $statusText = 'HATI-HATI';
                        $rowClass = 'category-warning';
                    } elseif ($obat->stock_obat > 0) {
                        $statusClass = 'status-kritis';
                        $statusText = 'KRITIS';
                        $rowClass = 'category-danger';
                    } else {
                        $statusClass = 'status-habis';
                        $statusText = 'HABIS';
                        $rowClass = 'category-danger';
                    }
                    
                    // Price category
                    if ($obat->harga_obat >= 50000) {
                        $priceClass = 'value-high';
                    } elseif ($obat->harga_obat >= 20000) {
                        $priceClass = 'value-medium';
                    } else {
                        $priceClass = 'value-low';
                    }
                    
                    // Last update info
                    $lastUpdate = $obat->updated_at->diffForHumans();
                @endphp
                <tr class="{{ $rowClass }}">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-bold medicine-code">{{ $obat->kode_obat }}</td>
                    <td class="medicine-name">{{ $obat->nama_obat }}</td>
                    <td class="text-center">
                        <span class="unit-badge">{{ $obat->satuan_obat }}</span>
                    </td>
                    <td class="text-right {{ $priceClass }}">
                        Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}
                    </td>
                    <td class="text-center text-bold">{{ $obat->stock_obat }}</td>
                    <td class="text-center">
                        <span class="stock-status {{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                    <td class="text-right text-bold">
                        Rp {{ number_format($nilaiStok, 0, ',', '.') }}
                    </td>
                    <td class="text-center" title="{{ $obat->updated_at->format('d/m/Y H:i') }}">
                        {{ $lastUpdate }}
                    </td>
                    <td class="text-center">
                        @if($nilaiStok > 1000000)
                            <span style="color: #28a745;">HIGH VALUE</span>
                        @elseif($nilaiStok > 500000)
                            <span style="color: #ffc107;">MEDIUM</span>
                        @else
                            <span style="color: #6c757d;">LOW</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #e9ecef; font-weight: bold;">
                    <td colspan="5" class="text-right">TOTAL:</td>
                    <td class="text-center">{{ $obats->sum('stock_obat') }}</td>
                    <td class="text-center">-</td>
                    <td class="text-right">Rp {{ number_format($totalNilai, 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
        
        <!-- Stock Analysis -->
        <div style="page-break-inside: avoid; margin-top: 30px;">
            <h3 style="font-size: 14px; border-bottom: 2px solid #333; padding-bottom: 5px; margin-bottom: 10px;">
                ANALISIS STOK OBAT
            </h3>
            
            <!-- By Status -->
            <div style="margin-bottom: 20px;">
                <h4 style="font-size: 12px; margin-bottom: 8px;">Distribusi Status Stok</h4>
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th width="100" class="text-center">Jumlah Obat</th>
                            <th width="100" class="text-center">Persentase</th>
                            <th width="150" class="text-center">Total Unit</th>
                            <th width="150" class="text-right">Total Nilai</th>
                            <th>Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $statusGroups = [
                                'Aman' => $obats->where('stock_obat', '>=', 20),
                                'Hati-hati' => $obats->whereBetween('stock_obat', [10, 19]),
                                'Kritis' => $obats->where('stock_obat', '<', 10)->where('stock_obat', '>', 0),
                                'Habis' => $obats->where('stock_obat', 0),
                            ];
                        @endphp
                        
                        @foreach($statusGroups as $statusName => $group)
                        @php
                            $count = $group->count();
                            $percentage = $obats->count() > 0 ? ($count / $obats->count()) * 100 : 0;
                            $totalUnits = $group->sum('stock_obat');
                            $totalValue = $group->sum(function($obat) {
                                return $obat->harga_obat * $obat->stock_obat;
                            });
                        @endphp
                        <tr>
                            <td><strong>{{ $statusName }}</strong></td>
                            <td class="text-center">{{ $count }}</td>
                            <td class="text-center">{{ number_format($percentage, 1) }}%</td>
                            <td class="text-center">{{ $totalUnits }}</td>
                            <td class="text-right">Rp {{ number_format($totalValue, 0, ',', '.') }}</td>
                            <td style="font-size: 9px;">
                                @if($statusName == 'Aman')
                                    <span style="color: #28a745;">✓ Stok cukup</span>
                                @elseif($statusName == 'Hati-hati')
                                    <span style="color: #ffc107;">⚠️ Perlu monitoring</span>
                                @elseif($statusName == 'Kritis')
                                    <span style="color: #dc3545;">❗ Restock segera</span>
                                @else
                                    <span style="color: #dc3545;">🚨 RESTOCK DARURAT</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Top and Bottom 5 -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <div>
                    <h4 style="font-size: 12px; margin-bottom: 8px;">📈 5 OBAT NILAI TERTINGGI</h4>
                    <table style="width: 100%; font-size: 9px;">
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th class="text-right">Nilai Stok</th>
                                <th class="text-center">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($obats->sortByDesc(function($obat) { return $obat->harga_obat * $obat->stock_obat; })->take(5) as $obat)
                            @php
                                $nilai = $obat->harga_obat * $obat->stock_obat;
                                $percentage = $totalNilai > 0 ? ($nilai / $totalNilai) * 100 : 0;
                            @endphp
                            <tr>
                                <td>{{ $obat->nama_obat }}</td>
                                <td class="text-right text-bold">Rp {{ number_format($nilai, 0, ',', '.') }}</td>
                                <td class="text-center">{{ number_format($percentage, 1) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div>
                    <h4 style="font-size: 12px; margin-bottom: 8px;">⚠️ OBAT STOK KRITIS</h4>
                    <table style="width: 100%; font-size: 9px;">
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th class="text-center">Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($obats->where('stock_obat', '<', 10)->sortBy('stock_obat')->take(5) as $obat)
                            <tr>
                                <td>{{ $obat->nama_obat }}</td>
                                <td class="text-center text-bold">{{ $obat->stock_obat }}</td>
                                <td>
                                    @if($obat->stock_obat == 0)
                                        <span style="color: #dc3545;">HABIS</span>
                                    @else
                                        <span style="color: #ffc107;">KRITIS</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Recommendations -->
        <div style="margin-top: 30px; page-break-inside: avoid;">
            <h3 style="font-size: 14px; border-bottom: 2px solid #333; padding-bottom: 5px; margin-bottom: 10px;">
                REKOMENDASI MANAJEMEN STOK
            </h3>
            
            <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 15px;">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div>
                        <h4 style="font-size: 12px; color: #28a745; margin-bottom: 8px;">✅ TINDAKAN SEGERA</h4>
                        <ul style="margin: 0; padding-left: 15px; font-size: 10px;">
                            <li>Restock {{ $stokKritis + $stokHabis }} obat dengan stok kritis/habis</li>
                            <li>Prioritaskan obat dengan nilai stok tinggi</li>
                            <li>Review harga obat dengan nilai ekstrem</li>
                            <li>Update data stok fisik vs sistem</li>
                        </ul>
                    </div>
                    <div>
                        <h4 style="font-size: 12px; color: #007bff; margin-bottom: 8px;">📅 RENCANA JANGKA PANJANG</h4>
                        <ul style="margin: 0; padding-left: 15px; font-size: 10px;">
                            <li>Optimalkan level stok minimum/maksimum</li>
                            <li>Implementasi sistem pemesanan otomatis</li>
                            <li>Analisis pola penjualan per obat</li>
                            <li>Negosiasi harga dengan distributor</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-info">
                <div>
                    <strong>INFORMASI DOKUMEN</strong><br>
                    ID: OBAT-{{ date('Ymd') }}-{{ str_pad($obats->count(), 3, '0', STR_PAD_LEFT) }}<br>
                    Tipe: Master Data Export<br>
                    Status: Final
                </div>
                <div>
                    <strong>VALIDASI</strong><br>
                    Diperiksa oleh Sistem<br>
                    Timestamp: {{ date('Y-m-d H:i:s') }}<br>
                    Checksum: {{ md5($obats->count() . $totalNilai . date('Ymd')) }}
                </div>
                <div>
                    <strong>DISTRIBUSI</strong><br>
                    1. Manajemen<br>
                    2. Gudang<br>
                    3. Keuangan<br>
                    4. Arsip
                </div>
            </div>
            
            <div style="margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px; font-size: 8px; color: #999;">
                <p style="margin: 0;">
                    <strong>PERNYATAAN:</strong> Dokumen ini berisi data sensitif. Penggunaan dan distribusi hanya untuk keperluan internal.<br>
                    Dokumen ini sah sebagai referensi resmi manajemen stok obat. Valid sampai update data berikutnya.<br>
                    Generated by: Apotek Management System v1.0 | Export Time: {{ round(microtime(true) - LARAVEL_START, 3) }}s
                </p>
            </div>
        </div>
    </div>
</body>
</html>