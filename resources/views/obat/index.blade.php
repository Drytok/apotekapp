@extends('layouts.app')

@section('title', 'Data Obat')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('obat.index') }}">Obat</a></li>
    <li class="breadcrumb-item active">Data Obat</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-capsule me-2"></i>Data Obat</h5>
        <div>
            <a href="{{ route('obat.export-pdf') }}" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
            </a>
            <a href="{{ route('obat.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Obat
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="obatTable">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obats as $index => $obat)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <span class="badge bg-info">{{ $obat->kode_obat }}</span>
                        </td>
                        <td>{{ $obat->nama_obat }}</td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $obat->satuan_obat }}</span>
                        </td>
                        <td class="text-end">Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($obat->stock_obat >= 20)
                                <span class="badge bg-success">{{ $obat->stock_obat }}</span>
                            @elseif($obat->stock_obat >= 10)
                                <span class="badge bg-warning">{{ $obat->stock_obat }}</span>
                            @else
                                <span class="badge bg-danger">{{ $obat->stock_obat }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($obat->stock_obat >= 20)
                                <span class="badge bg-success">Aman</span>
                            @elseif($obat->stock_obat >= 10)
                                <span class="badge bg-warning">Hati-hati</span>
                            @else
                                <span class="badge bg-danger">Kritis</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('obat.show', $obat->id) }}" class="btn btn-info btn-sm" 
                               title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-warning btn-sm" 
                               title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" 
                                  class="d-inline" onsubmit="return confirm('Hapus obat ini?')">
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
                        <td colspan="4" class="text-end"><strong>Total Obat:</strong></td>
                        <td colspan="4"><strong>{{ $obats->count() }} jenis obat</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Search functionality
        $('#searchInput').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('#obatTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        
        // Sort functionality
        $('.sortable').click(function() {
            let table = $(this).parents('table').eq(0);
            let rows = table.find('tr:gt(0)').toArray().sort(comparator($(this).index()));
            this.asc = !this.asc;
            if (!this.asc) { rows = rows.reverse(); }
            for (let i = 0; i < rows.length; i++) { table.append(rows[i]); }
        });
        
        function comparator(index) {
            return function(a, b) {
                let valA = getCellValue(a, index), valB = getCellValue(b, index);
                return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
            };
        }
        
        function getCellValue(row, index) { 
            return $(row).children('td').eq(index).text(); 
        }
    });
</script>
@endpush
@endsection