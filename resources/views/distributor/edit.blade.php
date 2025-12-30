@extends('layouts.app')

@section('title', 'Edit Distributor - ' . $distributor->nama_distributor)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('distributor.index') }}">Distributor</a></li>
    <li class="breadcrumb-item active">Edit Distributor</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>Edit Distributor
                        <span class="badge bg-info float-end">{{ $distributor->kode_distributor }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('distributor.update', $distributor->id) }}" method="POST"
                        id="editDistributorForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kode_distributor" class="form-label">Kode Distributor <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode_distributor') is-invalid @enderror"
                                    id="kode_distributor" name="kode_distributor"
                                    value="{{ old('kode_distributor', $distributor->kode_distributor) }}" required>
                                @error('kode_distributor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nama_distributor" class="form-label">Nama Distributor <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_distributor') is-invalid @enderror"
                                    id="nama_distributor" name="nama_distributor"
                                    value="{{ old('nama_distributor', $distributor->nama_distributor) }}" required>
                                @error('nama_distributor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                required>{{ old('alamat', $distributor->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                    id="telepon" name="telepon" value="{{ old('telepon', $distributor->telepon) }}"
                                    required>
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $distributor->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Koordinat Lokasi</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="latitude" class="form-label">Latitude</label>
                                        <input type="number" step="any"
                                            class="form-control @error('latitude') is-invalid @enderror" id="latitude"
                                            name="latitude" value="{{ old('latitude', $distributor->latitude) }}">
                                        @error('latitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="longitude" class="form-label">Longitude</label>
                                        <input type="number" step="any"
                                            class="form-control @error('longitude') is-invalid @enderror" id="longitude"
                                            name="longitude" value="{{ old('longitude', $distributor->longitude) }}">
                                        @error('longitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="alert alert-info">
                                    <small>
                                        <i class="bi bi-info-circle me-1"></i>
                                        Kosongkan koordinat jika ingin menghapus lokasi dari peta.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('distributor.show', $distributor->id) }}" class="btn btn-secondary">
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
            <!-- Map Editor Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-map me-2"></i>Edit Lokasi di Peta</h6>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 300px; border-radius: 8px;"></div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-outline-primary w-100 mb-2"
                            onclick="getCurrentLocation()">
                            <i class="bi bi-geo-alt me-1"></i> Gunakan Lokasi Saya
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="clearCoordinates()">
                            <i class="bi bi-trash me-1"></i> Hapus Koordinat
                        </button>
                    </div>
                    <div class="alert alert-warning mt-3">
                        <small>
                            <i class="bi bi-lightbulb me-1"></i>
                            Klik di peta untuk mengubah lokasi, atau gunakan tombol di atas.
                        </small>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-eye me-2"></i>Preview Perubahan</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="badge bg-info fs-6 mb-2" id="previewKode">{{ $distributor->kode_distributor }}</div>
                        <h6 id="previewNama">{{ $distributor->nama_distributor }}</h6>
                    </div>
                    <table class="table table-sm">
                        <tr>
                            <th>Telepon</th>
                            <td id="previewTelepon">{{ $distributor->telepon }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td id="previewEmail">{{ $distributor->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Koordinat</th>
                            <td id="previewKoordinat">
                                @if ($distributor->latitude && $distributor->longitude)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-warning">Tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <style>
            .leaflet-container {
                z-index: 1;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            let map, marker;
            let initialLat = {{ $distributor->latitude ?: '-6.2088' }};
            let initialLng = {{ $distributor->longitude ?: '106.8456' }};

            $(document).ready(function() {
                // Initialize map
                initMap(initialLat, initialLng);

                // Update preview in real-time
                $('#kode_distributor, #nama_distributor, #telepon, #email, #latitude, #longitude').on('input',
                    updatePreview);

                // Form validation
                $('#editDistributorForm').on('submit', function(e) {
                    let telepon = $('#telepon').val();
                    if (!/^[0-9+\-\s()]+$/.test(telepon)) {
                        alert('Nomor telepon hanya boleh berisi angka dan simbol + - ( )');
                        e.preventDefault();
                        return false;
                    }
                });
            });

            function initMap(lat, lng) {
                map = L.map('map').setView([lat, lng], {{ $distributor->latitude ? '15' : '13' }});

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Add click event to map
                map.on('click', function(e) {
                    let latlng = e.latlng;
                    updateCoordinates(latlng.lat, latlng.lng);
                    addMarker(latlng.lat, latlng.lng);
                });

                // Add initial marker if coordinates exist
                if ({{ $distributor->latitude ? 'true' : 'false' }}) {
                    addMarker(initialLat, initialLng);
                }
            }

            function addMarker(lat, lng) {
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([lat, lng]).addTo(map);
            }

            function updateCoordinates(lat, lng) {
                $('#latitude').val(lat.toFixed(6));
                $('#longitude').val(lng.toFixed(6));
                updatePreview();
            }

            function getCurrentLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            let lat = position.coords.latitude;
                            let lng = position.coords.longitude;

                            updateCoordinates(lat, lng);
                            addMarker(lat, lng);
                            map.setView([lat, lng], 15);
                        },
                        function(error) {
                            alert('Tidak dapat mengambil lokasi: ' + error.message);
                        }
                    );
                } else {
                    alert('Browser tidak mendukung geolocation');
                }
            }

            function clearCoordinates() {
                $('#latitude').val('');
                $('#longitude').val('');
                if (marker) {
                    map.removeLayer(marker);
                    marker = null;
                }
                updatePreview();
            }

            function updatePreview() {
                $('#previewKode').text($('#kode_distributor').val());
                $('#previewNama').text($('#nama_distributor').val());
                $('#previewTelepon').text($('#telepon').val());
                $('#previewEmail').text($('#email').val() || '-');

                let lat = $('#latitude').val();
                let lng = $('#longitude').val();
                if (lat && lng) {
                    $('#previewKoordinat').html('<span class="badge bg-success">Tersedia</span>');
                } else {
                    $('#previewKoordinat').html('<span class="badge bg-warning">Tidak tersedia</span>');
                }
            }
        </script>
    @endpush
@endsection
