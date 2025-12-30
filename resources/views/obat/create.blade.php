@extends('layouts.app')

@section('title', 'Tambah Obat Baru')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('obat.index') }}">Obat</a></li>
    <li class="breadcrumb-item active">Tambah Obat</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Obat Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('obat.store') }}" method="POST" id="formObat">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kode_obat" class="form-label">Kode Obat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_obat') is-invalid @enderror" 
                                   id="kode_obat" name="kode_obat" value="{{ old('kode_obat') }}" 
                                   placeholder="Contoh: OBT001" required>
                            @error('kode_obat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kode unik untuk identifikasi obat</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_obat" class="form-label">Nama Obat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" 
                                   id="nama_obat" name="nama_obat" value="{{ old('nama_obat') }}" 
                                   placeholder="Contoh: Paracetamol 500mg" required>
                            @error('nama_obat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="satuan_obat" class="form-label">Satuan <span class="text-danger">*</span></label>
                            <select class="form-select @error('satuan_obat') is-invalid @enderror" 
                                    id="satuan_obat" name="satuan_obat" required>
                                <option value="">Pilih Satuan</option>
                                @foreach($satuanOptions as $satuan)
                                    <option value="{{ $satuan }}" {{ old('satuan_obat') == $satuan ? 'selected' : '' }}>
                                        {{ $satuan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('satuan_obat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_obat" class="form-label">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga_obat') is-invalid @enderror" 
                                       id="harga_obat" name="harga_obat" value="{{ old('harga_obat') }}" 
                                       min="0" step="100" required>
                                @error('harga_obat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Harga satuan obat</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stock_obat" class="form-label">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock_obat') is-invalid @enderror" 
                                   id="stock_obat" name="stock_obat" value="{{ old('stock_obat', 0) }}" 
                                   min="0" required>
                            @error('stock_obat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jumlah stok awal obat</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nilai Stok</label>
                            <div class="form-control" id="nilaiStok">
                                Rp 0
                            </div>
                            <small class="text-muted">Harga × Stok</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('obat.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Obat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="bi bi-lightbulb me-1"></i> Tips Pengisian:</h6>
                    <ul class="mb-0 ps-3">
                        <li>Gunakan kode unik untuk setiap obat</li>
                        <li>Nama obat harus jelas dan lengkap</li>
                        <li>Pilih satuan yang sesuai dengan kemasan</li>
                        <li>Isi stok awal dengan benar</li>
                        <li>Harga dalam rupiah tanpa titik</li>
                    </ul>
                </div>
                <div class="alert alert-warning">
                    <h6><i class="bi bi-exclamation-triangle me-1"></i> Perhatian:</h6>
                    <ul class="mb-0 ps-3">
                        <li>Pastikan data yang diisi benar</li>
                        <li>Data tidak dapat diubah sembarangan</li>
                        <li>Stok akan otomatis berkurang saat transaksi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Calculate stock value
        function calculateStockValue() {
            let harga = parseFloat($('#harga_obat').val()) || 0;
            let stok = parseFloat($('#stock_obat').val()) || 0;
            let nilai = harga * stok;
            $('#nilaiStok').text('Rp ' + nilai.toLocaleString('id-ID'));
        }
        
        $('#harga_obat, #stock_obat').on('input', calculateStockValue);
        calculateStockValue();
        
        // Form validation
        $('#formObat').on('submit', function(e) {
            let harga = parseFloat($('#harga_obat').val());
            let stok = parseFloat($('#stock_obat').val());
            
            if (harga < 0) {
                alert('Harga tidak boleh negatif');
                e.preventDefault();
                return false;
            }
            
            if (stok < 0) {
                alert('Stok tidak boleh negatif');
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endpush
@endsection