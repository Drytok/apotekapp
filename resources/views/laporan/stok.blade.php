@extends('layouts.app')

@section('title', 'Laporan Stok Obat')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Laporan Stok Obat</h5>
            <div>
                <a href="{{ route('laporan.print-stok') }}" class="btn btn-success">
                    <i class="bi bi-printer"></i> Cetak
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Nilai Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obats as $index => $obat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $obat->kode_obat }}</td>
                                <td>{{ $obat->nama_obat }}</td>
                                <td>{{ $obat->satuan_obat }}</td>
                                <td>Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}</td>
                                <td>{{ $obat->stock_obat }}</td>
                                <td>Rp {{ number_format($obat->harga_obat * $obat->stock_obat, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td colspan="6" class="text-end"><strong>Total Nilai Stok:</strong></td>
                            <td><strong>Rp {{ number_format($totalNilai, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
