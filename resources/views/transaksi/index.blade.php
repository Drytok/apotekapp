@extends('layouts.app')

@section('title', 'Data Transaksi')
@section('breadcrumb')
    <li class="breadcrumb-item active">Transaksi</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Data Transaksi</h5>
        <div>
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Transaksi Baru
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter Section -->
        <div class="card mb-4 bg-light">
            <div class="card-body">
                <form method="GET" action="{{ route('transaksi.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ $endDate }}">
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari (Nama/No. Transaksi)</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               placeholder="Cari transaksi..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($transaksis->count() > 0)
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0">Total Transaksi</h6>
                                <h4 class="mt-2 fw-bold">{{ $transaksis->count() }}</h4>
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
                                <h6 class="mb-0">Total Pendapatan</h6>
                                @php
                                    $totalPendapatan = $transaksis->sum('total_harga');
                                @endphp
                                <h4 class="mt-2 fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
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
                                    $rataRata = $transaksis->count() > 0 ? $totalPendapatan / $transaksis->count() : 0;
                                @endphp
                                <h4 class="mt-2 fw-bold">Rp {{ number_format($rataRata, 0, ',', '.') }}</h4>
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
                                <h6 class="mb-0">Periode</h6>
                                <h6 class="mt-2 fw-bold">
                                    {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
                                </h6>
                            </div>
                            <i class="bi bi-calendar-range fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="transaksiTable">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Pembeli</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Item</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $index => $transaksi)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <span class="badge bg-info">{{ $transaksi->kode_transaksi }}</span>
                        </td>
                        <td>{{ $transaksi->tanggal_transaksi->translatedFormat('d M Y') }}</td>
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
                               class="btn btn-info btn-sm" title="Lihat Struk">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('transaksi.print', $transaksi->id) }}" 
                               target="_blank" class="btn btn-success btn-sm" title="Cetak">
                                <i class="bi bi-printer"></i>
                            </a>
                            <form action="{{ route('transaksi.destroy', $transaksi->id) }}" 
                                  method="POST" class="d-inline" 
                                  onsubmit="return confirm('Hapus transaksi ini? Stok akan dikembalikan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td class="text-end fw-bold text-success">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </td>
                        <td colspan="4"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($transaksis instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan {{ $transaksis->firstItem() }} - {{ $transaksis->lastItem() }} dari {{ $transaksis->total() }} transaksi
            </div>
            {{ $transaksis->links() }}
        </div>
        @endif
        
        @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-1 text-muted"></i>
            <h4 class="mt-3 text-muted">Belum Ada Data Transaksi</h4>
            <p class="text-muted">Mulai lakukan transaksi pertama Anda</p>
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                <i class="bi bi-cart-plus me-1"></i> Buat Transaksi Pertama
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Date range picker
        $('#start_date, #end_date').on('change', function() {
            let start = $('#start_date').val();
            let end = $('#end_date').val();
            
            if (start && end && new Date(start) > new Date(end)) {
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                $('#start_date').val('');
                $('#end_date').val('');
            }
        });
        
        // Search functionality
        $('#search').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('#transaksiTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        
        // Export buttons
        $('#exportPdf').click(function() {
            let start = $('#start_date').val();
            let end = $('#end_date').val();
            let search = $('#search').val();
            
            let url = '{{ route("laporan.print-penjualan") }}?start_date=' + start + '&end_date=' + end;
            if (search) {
                url += '&search=' + search;
            }
            
            window.open(url, '_blank');
        });
    });
</script>
@endpush
@endsection