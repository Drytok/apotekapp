@extends('layouts.app')

@section('title', 'Detail Distributor - ' . $distributor->nama_distributor)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('distributor.index') }}">Distributor</a></li>
    <li class="breadcrumb-item active">Detail Distributor</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-truck me-2"></i>Detail Distributor
                        <span class="badge bg-info float-end">{{ $distributor->kode_distributor }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Kode Distributor</th>
                                    <td>: <span class="badge bg-info">{{ $distributor->kode_distributor }}</span></td>
                                </tr>
                                <tr>
                                    <th>Nama Distributor</th>
                                    <td>: <strong>{{ $distributor->nama_distributor }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>: <i class="bi bi-telephone text-primary"></i> {{ $distributor->telepon }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>:
                                        @if ($distributor->email)
                                            <i class="bi bi-envelope text-primary"></i>
                                            <a href="mailto:{{ $distributor->email }}">{{ $distributor->email }}</a>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Koordinat</th>
                                    <td>:
                                        @if ($distributor->latitude && $distributor->longitude)
                                            <span class="badge bg-success">
                                                <i class="bi bi-geo-alt"></i> Tersedia
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="bi bi-geo-alt"></i> Tidak Tersedia
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ditambahkan</th>
                                    <td>: {{ $distributor->created_at->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diubah</th>
                                    <td>: {{ $distributor->updated_at->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Lengkap</label>
                        <div class="card bg-light">
                            <div class="card-body">
                                <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                {{ $distributor->alamat }}
                            </div>
                        </div>
                    </div>

                    @if ($distributor->latitude && $distributor->longitude)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Lokasi di Peta</label>
                            <div id="map" style="height: 300px; border-radius: 8px;"></div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('distributor.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <div>
                            @if ($distributor->latitude && $distributor->longitude)
                                <a href="https://www.google.com/maps?q={{ $distributor->latitude }},{{ $distributor->longitude }}"
                                    target="_blank" class="btn btn-info me-2">
                                    <i class="bi bi-google me-1"></i> Buka di Google Maps
                                </a>
                            @endif
                            <a href="{{ route('distributor.edit', $distributor->id) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                            <form action="{{ route('distributor.destroy', $distributor->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Hapus distributor ini?')">
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
        </div>

        <div class="col-md-4">
            <!-- Quick Info Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Kontak</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="display-4 text-primary">
                            <i class="bi bi-building"></i>
                        </div>
                        <h5>{{ $distributor->nama_distributor }}</h5>
                        <div class="text-muted">Distributor Obat</div>
                    </div>

                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-telephone text-primary me-2"></i>
                            <a href="tel:{{ $distributor->telepon }}" class="text-decoration-none">
                                {{ $distributor->telepon }}
                            </a>
                        </li>
                        @if ($distributor->email)
                            <li class="mb-3">
                                <i class="bi bi-envelope text-primary me-2"></i>
                                <a href="mailto:{{ $distributor->email }}" class="text-decoration-none">
                                    {{ $distributor->email }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <i class="bi bi-calendar text-primary me-2"></i>
                            Bergabung sejak {{ $distributor->created_at->translatedFormat('F Y') }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Coordinates Card -->
            @if ($distributor->latitude && $distributor->longitude)
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Koordinat GPS</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 border-end">
                                <div class="fw-bold">{{ $distributor->latitude }}</div>
                                <small class="text-muted">Latitude</small>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold">{{ $distributor->longitude }}</div>
                                <small class="text-muted">Longitude</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-sm btn-outline-primary w-100" onclick="copyCoordinates()">
                                <i class="bi bi-clipboard me-1"></i> Salin Koordinat
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Actions Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="tel:{{ $distributor->telepon }}" class="btn btn-success">
                            <i class="bi bi-telephone-outbound me-1"></i> Telepon
                        </a>
                        @if ($distributor->email)
                            <a href="mailto:{{ $distributor->email }}" class="btn btn-primary">
                                <i class="bi bi-envelope me-1"></i> Email
                            </a>
                        @endif
                        <a href="{{ route('distributor.maps') }}" class="btn btn-info">
                            <i class="bi bi-map me-1"></i> Lihat Semua di Peta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($distributor->latitude && $distributor->longitude)
        @push('styles')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        @endpush

        @push('scripts')
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                $(document).ready(function() {
                    // Initialize map
                    let map = L.map('map').setView([{{ $distributor->latitude }}, {{ $distributor->longitude }}], 15);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    // Add marker
                    L.marker([{{ $distributor->latitude }}, {{ $distributor->longitude }}])
                        .addTo(map)
                        .bindPopup(`<b>{{ $distributor->nama_distributor }}</b><br>{{ $distributor->alamat }}`)
                        .openPopup();
                });

                function copyCoordinates() {
                    let text = `{{ $distributor->latitude }}, {{ $distributor->longitude }}`;
                    navigator.clipboard.writeText(text).then(function() {
                        alert('Koordinat berhasil disalin!');
                    });
                }
            </script>
        @endpush
    @endif
@endsection
