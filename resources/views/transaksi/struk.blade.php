@extends('layouts.app')

@section('title', 'Struk Transaksi - ' . $transaksi->kode_transaksi)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
    <li class="breadcrumb-item active">Struk Transaksi</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white border-bottom-0">
                    <div class="text-center">
                        <h4 class="mb-0 fw-bold">APOTEK SEHAT</h4>
                        <p class="mb-0 text-muted">Jl. Kesehatan No. 123, Jakarta</p>
                        <p class="mb-0 text-muted">Telp: (021) 12345678</p>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Receipt Header -->
                    <div class="text-center mb-4">
                        <h5 class="fw-bold mb-1">STRUK PEMBAYARAN</h5>
                        <p class="text-muted mb-0">No: {{ $transaksi->kode_transaksi }}</p>
                        <p class="text-muted">
                            {{ $transaksi->tanggal_transaksi->translatedFormat('d F Y H:i:s') }}
                        </p>
                    </div>

                    <!-- Customer Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nama Pembeli:</strong></p>
                            <p class="mb-0">{{ $transaksi->nama_pembeli }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="mb-1"><strong>Kasir:</strong> Admin</p>
                            <p class="mb-0"><strong>Shift:</strong>
                                {{ date('H') < 12 ? 'Pagi' : (date('H') < 18 ? 'Siang' : 'Malam') }}</p>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Obat</th>
                                    <th width="10%" class="text-center">Qty</th>
                                    <th width="20%" class="text-end">Harga</th>
                                    <th width="25%" class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi->details as $index => $detail)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $detail->obat->nama_obat }}</td>
                                        <td class="text-center">{{ $detail->jumlah }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Summary -->
                    <div class="row justify-content-end">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>Total Harga:</strong></td>
                                    <td class="text-end">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Bayar:</strong></td>
                                    <td class="text-end">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kembalian:</strong></td>
                                    <td class="text-end fw-bold text-success">Rp
                                        {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-5">
                        <p class="mb-2">Terima kasih telah berbelanja di Apotek Sehat</p>
                        <p class="text-muted mb-0">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
                        <p class="text-muted">Simpan struk ini sebagai bukti pembelian</p>
                        <div class="border-top pt-3 mt-3">
                            <p class="mb-0"><strong>Info Penting:</strong></p>
                            <p class="text-muted mb-0 small">
                                Untuk informasi dan keluhan, hubungi (021) 12345678<br>
                                Jam operasional: 08:00 - 22:00 WIB
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <div>
                            <a href="{{ route('transaksi.print', $transaksi->id) }}" target="_blank"
                                class="btn btn-success me-2">
                                <i class="bi bi-printer me-1"></i> Cetak Struk
                            </a>
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="bi bi-printer-fill me-1"></i> Print Halaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style media="print">
        @media print {
            body * {
                visibility: hidden;
            }

            .card,
            .card * {
                visibility: visible;
            }

            .card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none;
                box-shadow: none;
            }

            .card-footer,
            .btn {
                display: none !important;
            }

            @page {
                size: auto;
                margin: 0;
            }
        }

        /* Receipt styling */
        .receipt-container {
            max-width: 80mm;
            margin: 0 auto;
            font-family: 'Courier New', monospace;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .receipt-items {
            width: 100%;
            font-size: 12px;
        }

        .receipt-total {
            border-top: 2px dashed #000;
            padding-top: 10px;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>

    <div class="d-none d-print-block">
        <!-- Receipt for thermal printing -->
        <div class="receipt-container">
            <div class="receipt-header">
                <h3 style="font-size: 18px; margin: 5px 0;">APOTEK SEHAT</h3>
                <p style="margin: 2px 0; font-size: 10px;">Jl. Kesehatan No. 123, Jakarta</p>
                <p style="margin: 2px 0; font-size: 10px;">Telp: (021) 12345678</p>
                <p style="margin: 2px 0; font-size: 10px;">================================</p>
                <p style="margin: 2px 0; font-size: 11px;"><strong>STRUK PEMBAYARAN</strong></p>
                <p style="margin: 2px 0; font-size: 10px;">No: {{ $transaksi->kode_transaksi }}</p>
                <p style="margin: 2px 0; font-size: 10px;">
                    {{ $transaksi->tanggal_transaksi->format('d/m/Y H:i:s') }}
                </p>
            </div>

            <div style="margin-bottom: 10px;">
                <p style="margin: 3px 0; font-size: 10px;"><strong>Pembeli:</strong> {{ $transaksi->nama_pembeli }}</p>
                <p style="margin: 3px 0; font-size: 10px;"><strong>Kasir:</strong> Admin</p>
            </div>

            <table class="receipt-items" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; border-bottom: 1px dashed #000; padding: 3px 0; font-size: 10px;">Item
                        </th>
                        <th style="text-align: center; border-bottom: 1px dashed #000; padding: 3px 0; font-size: 10px;">Qty
                        </th>
                        <th style="text-align: right; border-bottom: 1px dashed #000; padding: 3px 0; font-size: 10px;">
                            Harga</th>
                        <th style="text-align: right; border-bottom: 1px dashed #000; padding: 3px 0; font-size: 10px;">
                            Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->details as $detail)
                        <tr>
                            <td style="text-align: left; padding: 3px 0; font-size: 10px;">{{ $detail->obat->nama_obat }}
                            </td>
                            <td style="text-align: center; padding: 3px 0; font-size: 10px;">{{ $detail->jumlah }}</td>
                            <td style="text-align: right; padding: 3px 0; font-size: 10px;">
                                {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td style="text-align: right; padding: 3px 0; font-size: 10px;">
                                {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="receipt-total">
                <table style="width: 100%; font-size: 11px;">
                    <tr>
                        <td>Total:</td>
                        <td style="text-align: right;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Bayar:</td>
                        <td style="text-align: right;">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kembali:</strong></td>
                        <td style="text-align: right;"><strong>Rp
                                {{ number_format($transaksi->kembalian, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>

            <div style="text-align: center; margin-top: 15px; font-size: 9px;">
                <p style="margin: 2px 0;">Terima kasih telah berbelanja</p>
                <p style="margin: 2px 0;">Simpan struk ini sebagai bukti</p>
                <p style="margin: 2px 0;">================================</p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Print receipt
                $('#printReceipt').click(function() {
                    let printWindow = window.open('', '_blank');
                    printWindow.document.write(`
                <html>
                <head>
                    <title>Struk {{ $transaksi->kode_transaksi }}</title>
                    <style>
                        body { font-family: 'Courier New', monospace; margin: 0; padding: 10px; }
                        .receipt { width: 80mm; margin: 0 auto; }
                        .text-center { text-align: center; }
                        .text-right { text-align: right; }
                        table { width: 100%; border-collapse: collapse; }
                        td, th { padding: 3px 0; }
                        .border-top { border-top: 1px dashed #000; }
                        .border-bottom { border-bottom: 1px dashed #000; }
                    </style>
                </head>
                <body>
                    <div class="receipt">
                        <div class="text-center">
                            <h3>APOTEK SEHAT</h3>
                            <p>Jl. Kesehatan No. 123, Jakarta</p>
                            <p>Telp: (021) 12345678</p>
                            <p>==============================</p>
                            <h4>STRUK PEMBAYARAN</h4>
                            <p>No: {{ $transaksi->kode_transaksi }}</p>
                            <p>{{ $transaksi->tanggal_transaksi->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <p><strong>Pembeli:</strong> {{ $transaksi->nama_pembeli }}</p>
                        <p><strong>Kasir:</strong> Admin</p>
                        <table>
                            <thead>
                                <tr class="border-bottom">
                                    <th>Item</th>
                                    <th class="text-right">Qty</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi->details as $detail)
                                <tr>
                                    <td>{{ $detail->obat->nama_obat }}</td>
                                    <td class="text-right">{{ $detail->jumlah }}</td>
                                    <td class="text-right">{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="border-top">
                            <tr>
                                <td>Total:</td>
                                <td class="text-right">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Bayar:</td>
                                <td class="text-right">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kembali:</strong></td>
                                <td class="text-right"><strong>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                        <div class="text-center" style="margin-top: 20px;">
                            <p>Terima kasih telah berbelanja</p>
                            <p>Simpan struk ini sebagai bukti</p>
                            <p>==============================</p>
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
                });
            });
        </script>
    @endpush
@endsection
