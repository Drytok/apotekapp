@extends('layouts.app')

@section('title', 'Detail Obat - ' . $obat->nama_obat)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('obat.index') }}">Obat</a></li>
    <li class="breadcrumb-item active">Detail Obat</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-capsule me-2"></i>Detail Obat
                        <span class="badge bg-info float-end">{{ $obat->kode_obat }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Kode Obat</th>
                                    <td>: <span class="badge bg-info">{{ $obat->kode_obat }}</span></td>
                                </tr>
                                <tr>
                                    <th>Nama Obat</th>
                                    <td>: <strong>{{ $obat->nama_obat }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Satuan</th>
                                    <td>: <span class="badge bg-secondary">{{ $obat->satuan_obat }}</span></td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td>: <span class="text-success fw-bold">Rp
                                            {{ number_format($obat->harga_obat, 0, ',', '.') }}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Stok Tersedia</th>
                                    <td>:
                                        @if ($obat->stock_obat >= 20)
                                            <span class="badge bg-success">{{ $obat->stock_obat }}</span>
                                        @elseif($obat->stock_obat >= 10)
                                            <span class="badge bg-warning">{{ $obat->stock_obat }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $obat->stock_obat }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>:
                                        @if ($obat->stock_obat >= 20)
                                            <span class="badge bg-success">Aman</span>
                                        @elseif($obat->stock_obat >= 10)
                                            <span class="badge bg-warning">Hati-hati</span>
                                        @else
                                            <span class="badge bg-danger">Kritis</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nilai Stok</th>
                                    <td>: <span class="text-primary fw-bold">Rp
                                            {{ number_format($obat->harga_obat * $obat->stock_obat, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ditambahkan</th>
                                    <td>: {{ $obat->created_at->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <h6><i class="bi bi-info-circle me-2"></i> Informasi:</h6>
                        <ul class="mb-0">
                            <li>Stok aman: ≥ 20 unit</li>
                            <li>Stok hati-hati: 10-19 unit</li>
                            <li>Stok kritis: < 10 unit</li>
                            <li>Nilai stok = Harga × Stok tersedia</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('obat.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <div>
                            <a href="{{ route('laporan.obat-transaksi', $obat->id) }}" class="btn btn-info me-2">
                                <i class="bi bi-receipt me-1"></i> Riwayat Transaksi
                            </a>
                            <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                            <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus obat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Transaksi Terbaru -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Transaksi Terbaru</h6>
                </div>
                <div class="card-body">
                    @if ($transaksiDetails->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>No. Transaksi</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksiDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->transaksi->tanggal_transaksi->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('transaksi.struk', $detail->transaksi_id) }}"
                                                    class="text-decoration-none">
                                                    {{ $detail->transaksi->kode_transaksi }}
                                                </a>
                                            </td>
                                            <td>{{ $detail->jumlah }}</td>
                                            <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                            <td class="text-success fw-bold">Rp
                                                {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-cart-x fs-1 text-muted"></i>
                            <p class="mt-2 text-muted">Belum ada transaksi untuk obat ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Statistik -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Statistik Obat</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="display-4 fw-bold text-primary">
                            {{ $obat->stock_obat }}
                        </div>
                        <div class="text-muted">Stok Tersedia</div>
                    </div>

                    <div class="progress mb-3" style="height: 20px;">
                        @php
                            $percentage = min(100, ($obat->stock_obat / 50) * 100);
                            $color = $percentage >= 40 ? 'success' : ($percentage >= 20 ? 'warning' : 'danger');
                        @endphp
                        <div class="progress-bar bg-{{ $color }}" role="progressbar"
                            style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                            aria-valuemax="100">
                            {{ $percentage }}%
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <div class="fw-bold">Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}</div>
                            <small class="text-muted">Harga Satuan</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold">Rp {{ number_format($obat->harga_obat * $obat->stock_obat, 0, ',', '.') }}
                            </div>
                            <small class="text-muted">Nilai Stok</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('transaksi.create') }}?obat={{ $obat->id }}" class="btn btn-success">
                            <i class="bi bi-cart-plus me-1"></i> Jual Obat Ini
                        </a>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#restockModal">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Stok
                        </button>
                        <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i> Edit Data
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stok History -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-arrow-left-right me-2"></i>Perubahan Stok</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <span>Stok Awal</span>
                                <span class="badge bg-secondary">-</span>
                            </div>
                            <small class="text-muted">Saat ditambahkan</small>
                        </div>
                        @foreach ($transaksiDetails->take(3) as $detail)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>Penjualan {{ $detail->transaksi->kode_transaksi }}</span>
                                    <span class="badge bg-danger">-{{ $detail->jumlah }}</span>
                                </div>
                                <small class="text-muted">{{ $detail->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Restock Modal -->
    <div class="modal fade" id="restockModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Stok Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Obat</label>
                            <input type="text" class="form-control" value="{{ $obat->nama_obat }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok Saat Ini</label>
                            <input type="text" class="form-control" value="{{ $obat->stock_obat }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_stok" class="form-label">Jumlah Tambahan Stok</label>
                            <input type="number" class="form-control" id="tambah_stok" name="tambah_stok"
                                min="1" required>
                            <input type="hidden" name="stock_obat" value="{{ $obat->stock_obat }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Restock form handling
                $('#tambah_stok').on('input', function() {
                    let current = parseInt('{{ $obat->stock_obat }}');
                    let addition = parseInt($(this).val()) || 0;
                    let newTotal = current + addition;
                    $('input[name="stock_obat"]').val(newTotal);
                });
            });
        </script>
    @endpush
@endsection
