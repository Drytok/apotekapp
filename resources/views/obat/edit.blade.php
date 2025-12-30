@extends('layouts.app')

@section('title', 'Edit Obat - ' . $obat->nama_obat)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('obat.index') }}">Obat</a></li>
    <li class="breadcrumb-item active">Edit Obat</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>Edit Obat
                        <span class="badge bg-info float-end">{{ $obat->kode_obat }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('obat.update', $obat->id) }}" method="POST" id="editObatForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kode_obat" class="form-label">Kode Obat <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode_obat') is-invalid @enderror"
                                    id="kode_obat" name="kode_obat" value="{{ old('kode_obat', $obat->kode_obat) }}"
                                    required>
                                @error('kode_obat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nama_obat" class="form-label">Nama Obat <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_obat') is-invalid @enderror"
                                    id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}"
                                    required>
                                @error('nama_obat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="satuan_obat" class="form-label">Satuan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('satuan_obat') is-invalid @enderror" id="satuan_obat"
                                    name="satuan_obat" required>
                                    <option value="">Pilih Satuan</option>
                                    @foreach ($satuanOptions as $satuan)
                                        <option value="{{ $satuan }}"
                                            {{ old('satuan_obat', $obat->satuan_obat) == $satuan ? 'selected' : '' }}>
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
                                        id="harga_obat" name="harga_obat"
                                        value="{{ old('harga_obat', $obat->harga_obat) }}" min="0" step="100"
                                        required>
                                    @error('harga_obat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="stock_obat" class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock_obat') is-invalid @enderror"
                                    id="stock_obat" name="stock_obat" value="{{ old('stock_obat', $obat->stock_obat) }}"
                                    min="0" required>
                                @error('stock_obat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nilai Stok</label>
                                <div class="form-control" id="nilaiStok">
                                    Rp {{ number_format($obat->harga_obat * $obat->stock_obat, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('obat.show', $obat->id) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <div>
                                <button type="reset" class="btn btn-warning me-2">
                                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Preview Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-eye me-2"></i>Preview</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="badge bg-info fs-5 mb-2" id="previewKode">{{ $obat->kode_obat }}</div>
                        <h5 id="previewNama">{{ $obat->nama_obat }}</h5>
                    </div>
                    <table class="table table-sm">
                        <tr>
                            <th>Satuan</th>
                            <td id="previewSatuan">{{ $obat->satuan_obat }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td id="previewHarga">Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>
                                <span class="badge" id="previewStokBadge">
                                    {{ $obat->stock_obat }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge" id="previewStatus">
                                    @if ($obat->stock_obat >= 20)
                                        bg-success
                                    @elseif($obat->stock_obat >= 10)
                                        bg-warning
                                    @else
                                        bg-danger
                                    @endif
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Warning Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Perhatian</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h6><i class="bi bi-lightbulb me-1"></i> Penting!</h6>
                        <ul class="mb-0">
                            <li>Perubahan harga akan mempengaruhi transaksi baru</li>
                            <li>Perubahan stok harus akurat</li>
                            <li>Pastikan kode obat tetap unik</li>
                            <li>Data yang sudah diubah tidak dapat dikembalikan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Last Update -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Info Perubahan</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-calendar-plus text-primary me-2"></i>
                            <strong>Dibuat:</strong>
                            {{ $obat->created_at->translatedFormat('d F Y H:i') }}
                        </li>
                        <li>
                            <i class="bi bi-calendar-check text-success me-2"></i>
                            <strong>Terakhir Diubah:</strong>
                            {{ $obat->updated_at->translatedFormat('d F Y H:i') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Update preview in real-time
                function updatePreview() {
                    let harga = parseFloat($('#harga_obat').val()) || 0;
                    let stok = parseInt($('#stock_obat').val()) || 0;

                    // Update preview values
                    $('#previewKode').text($('#kode_obat').val());
                    $('#previewNama').text($('#nama_obat').val());
                    $('#previewSatuan').text($('#satuan_obat').val());
                    $('#previewHarga').text('Rp ' + harga.toLocaleString('id-ID'));
                    $('#previewStokBadge').text(stok);

                    // Update stock value
                    let nilaiStok = harga * stok;
                    $('#nilaiStok').text('Rp ' + nilaiStok.toLocaleString('id-ID'));

                    // Update stock badge color
                    let badgeClass = 'bg-';
                    if (stok >= 20) badgeClass += 'success';
                    else if (stok >= 10) badgeClass += 'warning';
                    else badgeClass += 'danger';

                    $('#previewStokBadge').removeClass('bg-success bg-warning bg-danger').addClass(badgeClass);
                    $('#previewStatus').removeClass('bg-success bg-warning bg-danger').addClass(badgeClass).text(
                        stok >= 20 ? 'Aman' : (stok >= 10 ? 'Hati-hati' : 'Kritis')
                    );
                }

                // Bind events to form inputs
                $('#kode_obat, #nama_obat, #satuan_obat, #harga_obat, #stock_obat').on('input', updatePreview);

                // Form validation
                $('#editObatForm').on('submit', function(e) {
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
