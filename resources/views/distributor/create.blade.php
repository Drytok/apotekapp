@extends('layouts.app')

@section('title', 'Tambah Distributor Baru')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('distributor.index') }}">Distributor</a></li>
    <li class="breadcrumb-item active">Tambah Distributor</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Distributor Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('distributor.store') }}" method="POST" id="distributorForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kode_distributor" class="form-label">Kode Distributor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_distributor') is-invalid @enderror" 
                                   id="kode_distributor" name="kode_distributor" 
                                   value="{{ old('kode_distributor') }}" 
                                   placeholder="Contoh: DIST001" required>
                            @error('kode_distributor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_distributor" class="form-label">Nama Distributor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_distributor') is-invalid @enderror" 
                                   id="nama_distributor" name="nama_distributor" 
                                   value="{{ old('nama_distributor') }}" 
                                   placeholder="Contoh: PT. Farmasi Sejahtera" required>
                            @error('nama_distributor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                   id="telepon" name="telepon" value="{{ old('telepon') }}" 
                                   placeholder="Contoh: 02112345678" required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Contoh: info@distributor.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Koordinat Lokasi (Opsional)</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" 
                                           id="latitude" name="latitude" value="{{ old('latitude') }}" 
                                           placeholder="Contoh: -6.2088">
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                                           id="longitude" name="longitude" value="{{ old('longitude') }}" 
                                           placeholder="Contoh: 106.8456">
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="alert alert-info">
                                <small>
                                    <i class="bi bi-info-circle me-1"></i>
                                    Koordinat digunakan untuk menampilkan lokasi di peta. 
                                    Kosongkan jika tidak memiliki koordinat.
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('distributor.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Distributor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Location Picker Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-map me-2"></i>Pilih Lokasi di Peta</h6>
            </div>
            <div class="card-body">
                <div id="map" style="height: 300px; border-radius: 8px;"></div>
                <div class="mt-3">
                    <button type="button" class="btn btn-sm btn-outline-primary w-100" onclick="getCurrentLocation()">
                        <i class="bi bi-geo-alt me-1"></i> Gunakan Lokasi Saya
                    </button>
                </div>
                <div class="alert alert-warning mt-3">
                    <small>
                        <i class="bi bi-lightbulb me-1"></i>
                        Klik di peta untuk menandai lokasi, atau gunakan tombol di atas untuk mengambil lokasi Anda.
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Information Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Pengisian</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Kode Distributor:</strong> Harus unik
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Nama:</strong> Nama lengkap distributor
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Alamat:</strong> Alamat lengkap dengan detail
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Telepon:</strong> Nomor yang dapat dihubungi
                    </li>
                    <li>
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <strong>Koordinat:</strong> Opsional untuk peta
                    </li>
                </ul>
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
    
    $(document).ready(function() {
        // Initialize map with default location (Jakarta)
        initMap(-6.2088, 106.8456);
        
        // Form validation
        $('#distributorForm').on('submit', function(e) {
            let telepon = $('#telepon').val();
            if (!/^[0-9+\-\s()]+$/.test(telepon)) {
                alert('Nomor telepon hanya boleh berisi angka dan simbol + - ( )');
                e.preventDefault();
                return false;
            }
        });
    });
    
    function initMap(lat, lng) {
        map = L.map('map').setView([lat, lng], 13);
        
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
        let initialLat = $('#latitude').val();
        let initialLng = $('#longitude').val();
        if (initialLat && initialLng) {
            addMarker(parseFloat(initialLat), parseFloat(initialLng));
            map.setView([initialLat, initialLng], 15);
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
</script>
@endpush
@endsection