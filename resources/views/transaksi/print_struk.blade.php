<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk {{ $transaksi->kode_transaksi }}</title>
    <style>
        /* Thermal Printer Style */
        @page {
            size: 80mm auto;
            margin: 0;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.2;
            color: #000;
            margin: 0;
            padding: 5px;
            width: 80mm;
            background-color: #fff;
        }
        
        .receipt {
            width: 100%;
            max-width: 80mm;
            margin: 0 auto;
        }
        
        /* Header */
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        
        .store-name {
            font-size: 14px;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }
        
        .store-address {
            font-size: 10px;
            margin: 1px 0;
        }
        
        .store-contact {
            font-size: 10px;
            margin: 1px 0;
        }
        
        /* Receipt Info */
        .receipt-info {
            text-align: center;
            margin-bottom: 8px;
        }
        
        .receipt-title {
            font-size: 12px;
            font-weight: bold;
            margin: 3px 0;
        }
        
        .receipt-number {
            font-size: 11px;
            margin: 2px 0;
        }
        
        .receipt-date {
            font-size: 10px;
            margin: 2px 0;
        }
        
        /* Customer Info */
        .customer-info {
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px dashed #000;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }
        
        .info-label {
            font-weight: bold;
        }
        
        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        
        .items-table th {
            text-align: left;
            padding: 3px 0;
            border-bottom: 1px dashed #000;
            font-size: 10px;
        }
        
        .items-table td {
            padding: 2px 0;
            vertical-align: top;
            font-size: 11px;
        }
        
        .item-name {
            width: 55%;
        }
        
        .item-qty {
            width: 10%;
            text-align: center;
        }
        
        .item-price {
            width: 15%;
            text-align: right;
        }
        
        .item-total {
            width: 20%;
            text-align: right;
            font-weight: bold;
        }
        
        /* Payment Summary */
        .payment-summary {
            margin-bottom: 10px;
            padding-top: 5px;
            border-top: 1px dashed #000;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        
        .summary-label {
            font-weight: bold;
        }
        
        .summary-value {
            font-weight: bold;
        }
        
        .total-row {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 4px 0;
            margin: 5px 0;
            font-size: 13px;
        }
        
        .change-row {
            background-color: #f0f0f0;
            padding: 3px 5px;
            border-radius: 3px;
            margin-top: 5px;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            padding-top: 8px;
            border-top: 1px dashed #000;
            font-size: 9px;
        }
        
        .thank-you {
            font-weight: bold;
            margin: 3px 0;
        }
        
        .terms {
            font-size: 8px;
            margin: 2px 0;
            color: #666;
        }
        
        .barcode-area {
            text-align: center;
            margin: 8px 0;
        }
        
        .barcode {
            font-family: 'Libre Barcode 128', cursive;
            font-size: 24px;
            letter-spacing: 2px;
        }
        
        .signature {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px solid #000;
        }
        
        .signature-line {
            width: 60%;
            margin: 5px auto;
            border-top: 1px solid #000;
        }
        
        /* Print Controls */
        .print-controls {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .print-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
            margin-right: 5px;
        }
        
        .close-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
        }
        
        /* QR Code Styling */
        .qr-container {
            text-align: center;
            margin: 10px 0;
        }
        
        .qr-label {
            font-size: 8px;
            margin-top: 3px;
            color: #666;
        }
        
        /* Cashier Info */
        .cashier-info {
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            margin-bottom: 5px;
            padding-bottom: 3px;
            border-bottom: 1px dotted #ccc;
        }
        
        /* Item Details */
        .item-details {
            font-size: 10px;
            color: #555;
        }
        
        /* For browser preview */
        @media screen {
            body {
                background-color: #f5f5f5;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            
            .receipt {
                background-color: white;
                padding: 15px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                border-radius: 5px;
            }
        }
        
        /* For print */
        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 0;
            }
            
            .print-controls {
                display: none !important;
            }
            
            .receipt {
                padding: 5px;
                box-shadow: none;
                border-radius: 0;
            }
            
            /* Force black and white for thermal printers */
            * {
                color: #000 !important;
                background-color: #fff !important;
            }
        }
        
        /* Cut line */
        .cut-line {
            text-align: center;
            margin: 10px 0;
            color: #000;
            font-size: 10px;
            letter-spacing: 5px;
        }
        
        /* Item separator */
        .item-separator {
            border-bottom: 1px dotted #ccc;
            margin: 2px 0;
        }
    </style>
    
    <!-- Barcode Font -->
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128&display=swap" rel="stylesheet">
</head>
<body>
    <div class="receipt">
        <!-- Store Header -->
        <div class="header">
            <div class="store-name">APOTEK SEHAT</div>
            <div class="store-address">Jl. Kesehatan No. 123, Jakarta</div>
            <div class="store-contact">Telp: (021) 1234-5678</div>
            <div class="store-contact">NPWP: 01.234.567.8-912.000</div>
        </div>
        
        <!-- Receipt Info -->
        <div class="receipt-info">
            <div class="receipt-title">STRUK PEMBAYARAN</div>
            <div class="receipt-number">{{ $transaksi->kode_transaksi }}</div>
            <div class="receipt-date">
                {{ $transaksi->tanggal_transaksi->translatedFormat('d F Y H:i:s') }}
            </div>
        </div>
        
        <!-- Cashier Info -->
        <div class="cashier-info">
            <div>
                <span class="info-label">Kasir:</span> Admin
            </div>
            <div>
                <span class="info-label">Shift:</span> 
                @php
                    $hour = $transaksi->created_at->hour;
                    if ($hour < 12) echo 'PAGI';
                    elseif ($hour < 18) echo 'SIANG';
                    else echo 'MALAM';
                @endphp
            </div>
        </div>
        
        <!-- Customer Info -->
        <div class="customer-info">
            <div class="info-row">
                <span class="info-label">Pelanggan:</span>
                <span>{{ $transaksi->nama_pembeli }}</span>
            </div>
        </div>
        
        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th class="item-name">ITEM</th>
                    <th class="item-qty">QTY</th>
                    <th class="item-price">HARGA</th>
                    <th class="item-total">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->details as $detail)
                <tr>
                    <td class="item-name">
                        {{ $detail->obat->nama_obat }}
                        <div class="item-details">
                            {{ $detail->obat->kode_obat }} | {{ $detail->obat->satuan_obat }}
                        </div>
                    </td>
                    <td class="item-qty">{{ $detail->jumlah }}</td>
                    <td class="item-price">{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td class="item-total">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if(!$loop->last)
                <tr>
                    <td colspan="4" class="item-separator"></td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        
        <!-- Payment Summary -->
        <div class="payment-summary">
            <div class="summary-row">
                <span class="summary-label">Total Item:</span>
                <span>{{ $transaksi->details->count() }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total Qty:</span>
                <span>{{ $transaksi->details->sum('jumlah') }}</span>
            </div>
            
            <div class="summary-row">
                <span class="summary-label">Subtotal:</span>
                <span>{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
            
            <div class="summary-row">
                <span class="summary-label">Pajak (0%):</span>
                <span>0</span>
            </div>
            
            <div class="total-row summary-row">
                <span class="summary-label">TOTAL:</span>
                <span class="summary-value">{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
            
            <div class="summary-row">
                <span class="summary-label">TUNAI:</span>
                <span>{{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
            </div>
            
            <div class="change-row summary-row">
                <span class="summary-label">KEMBALI:</span>
                <span class="summary-value">{{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <!-- QR Code Area -->
        <div class="qr-container">
            <div style="font-family: monospace; font-size: 8px; letter-spacing: 1px; margin: 5px 0;">
                {{ str_repeat('*', 20) }}
            </div>
            <div class="barcode">
                *{{ $transaksi->kode_transaksi }}*
            </div>
            <div class="qr-label">
                SCAN UNTUK VERIFIKASI
            </div>
        </div>
        
        <!-- Cut Line -->
        <div class="cut-line">
            - - - - - - - - - - - - - - - -
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">TERIMA KASIH</div>
            <div class="terms">
                Barang yang sudah dibeli tidak dapat<br>
                ditukar atau dikembalikan
            </div>
            <div class="terms">
                Struk ini adalah bukti pembayaran yang sah
            </div>
            
            <!-- Signature -->
            <div class="signature">
                <div>Diterima oleh,</div>
                <div class="signature-line"></div>
                <div style="font-size: 8px;">( {{ $transaksi->nama_pembeli }} )</div>
            </div>
            
            <!-- Receipt Info -->
            <div style="margin-top: 10px; font-size: 7px; color: #888;">
                Struk: {{ $transaksi->kode_transaksi }} | 
                Kasir: Admin | 
                {{ date('Y-m-d H:i:s') }}
            </div>
        </div>
    </div>
    
    <!-- Print Controls (Browser Only) -->
    <div class="print-controls no-print">
        <button onclick="printReceipt()" class="print-btn">🖨️ Cetak Struk</button>
        <button onclick="window.close()" class="close-btn">✕ Tutup</button>
    </div>
    
    <script>
        // Auto print when opened in new window
        window.onload = function() {
            // Check if opened in new window (no referrer or from same origin)
            if (window.opener === null || window.location.href.indexOf('print') > -1) {
                setTimeout(function() {
                    window.print();
                }, 500);
            }
        };
        
        // Print receipt with thermal printer settings
        function printReceipt() {
            let printWindow = window.open('', '_blank');
            
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Struk {{ $transaksi->kode_transaksi }}</title>
                    <style>
                        body {
                            font-family: 'Courier New', monospace;
                            font-size: 12px;
                            line-height: 1.2;
                            margin: 0;
                            padding: 5px;
                            width: 80mm;
                        }
                        .receipt {
                            width: 100%;
                        }
                        .store-name {
                            font-size: 14px;
                            font-weight: bold;
                            text-align: center;
                            margin: 2px 0;
                        }
                        .store-address {
                            font-size: 10px;
                            text-align: center;
                            margin: 1px 0;
                        }
                        .receipt-title {
                            font-size: 12px;
                            font-weight: bold;
                            text-align: center;
                            margin: 3px 0;
                        }
                        .receipt-number {
                            font-size: 11px;
                            text-align: center;
                            margin: 2px 0;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 5px 0;
                        }
                        th {
                            text-align: left;
                            padding: 3px 0;
                            border-bottom: 1px dashed #000;
                        }
                        td {
                            padding: 2px 0;
                        }
                        .text-right {
                            text-align: right;
                        }
                        .text-center {
                            text-align: center;
                        }
                        .total-row {
                            border-top: 2px solid #000;
                            border-bottom: 2px solid #000;
                            padding: 4px 0;
                            margin: 5px 0;
                            font-size: 13px;
                        }
                        .footer {
                            text-align: center;
                            padding-top: 8px;
                            border-top: 1px dashed #000;
                            font-size: 9px;
                        }
                        @media print {
                            @page {
                                size: 80mm auto;
                                margin: 0;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="receipt">
                        <div class="store-name">APOTEK SEHAT</div>
                        <div class="store-address">Jl. Kesehatan No. 123, Jakarta</div>
                        <div class="store-address">Telp: (021) 1234-5678</div>
                        
                        <div class="receipt-title">STRUK PEMBAYARAN</div>
                        <div class="receipt-number">{{ $transaksi->kode_transaksi }}</div>
                        <div class="text-center">
                            {{ $transaksi->tanggal_transaksi->format('d/m/Y H:i:s') }}
                        </div>
                        
                        <div style="margin: 5px 0;">
                            <strong>Pelanggan:</strong> {{ $transaksi->nama_pembeli }}<br>
                            <strong>Kasir:</strong> Admin
                        </div>
                        
                        <table>
                            <thead>
                                <tr>
                                    <th>ITEM</th>
                                    <th>QTY</th>
                                    <th class="text-right">HARGA</th>
                                    <th class="text-right">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi->details as $detail)
                                <tr>
                                    <td>{{ $detail->obat->nama_obat }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td class="text-right">{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div style="margin: 10px 0;">
                            <div style="display: flex; justify-content: space-between;">
                                <span>Subtotal:</span>
                                <span>{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Pajak:</span>
                                <span>0</span>
                            </div>
                            <div class="total-row" style="display: flex; justify-content: space-between;">
                                <strong>TOTAL:</strong>
                                <strong>{{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Tunai:</span>
                                <span>{{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; background: #f0f0f0; padding: 3px;">
                                <strong>Kembali:</strong>
                                <strong>{{ number_format($transaksi->kembalian, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                        
                        <div class="footer">
                            <div><strong>TERIMA KASIH</strong></div>
                            <div>Barang tidak dapat ditukar/dikembalikan</div>
                            <div style="margin-top: 10px;">
                                {{ $transaksi->kode_transaksi }} | {{ date('H:i:s') }}
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        window.onload = function() {
                            window.print();
                            setTimeout(function() {
                                window.close();
                            }, 1000);
                        };
                    <\/script>
                </body>
                </html>
            `);
            
            printWindow.document.close();
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+P or Cmd+P to print
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                printReceipt();
            }
            // Escape to close
            if (e.key === 'Escape') {
                window.close();
            }
        });
        
        // Generate barcode-like text
        function generateBarcode(text) {
            // Simple barcode simulation
            let barcode = '';
            for (let i = 0; i < text.length; i++) {
                barcode += text.charAt(i) + ' ';
            }
            return barcode;
        }
        
        // Update barcode on load
        window.onload = function() {
            let barcodeElement = document.querySelector('.barcode');
            if (barcodeElement) {
                let barcodeText = generateBarcode('{{ $transaksi->kode_transaksi }}');
                barcodeElement.textContent = barcodeText;
            }
        };
    </script>
</body>
</html>