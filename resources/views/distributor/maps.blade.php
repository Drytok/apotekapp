@extends('layouts.app')

@section('title', 'Lokasi Distributor')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Peta Lokasi Distributor</h5>
        </div>
        <div class="card-body">
            <div id="map" style="height: 500px; width: 100%;"></div>
        </div>
    </div>

    @push('scripts')
        <!-- Leaflet CSS & JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
            // Default coordinates (Jakarta)
            let defaultLat = -6.2088;
            let defaultLng = 106.8456;

            // Initialize map
            let map = L.map('map').setView([defaultLat, defaultLng], 13);

            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add markers for distributors
            @foreach ($distributors as $distributor)
                L.marker([{{ $distributor->latitude }}, {{ $distributor->longitude }}])
                    .addTo(map)
                    .bindPopup(`
        <b>{{ $distributor->nama_distributor }}</b><br>
        {{ $distributor->alamat }}<br>
        Telp: {{ $distributor->telepon }}
    `);
            @endforeach

            // Add geolocation
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    let userLat = position.coords.latitude;
                    let userLng = position.coords.longitude;

                    // Add user marker
                    L.marker([userLat, userLng])
                        .addTo(map)
                        .bindPopup('Lokasi Anda')
                        .openPopup();

                    // Center map on user
                    map.setView([userLat, userLng], 13);
                });
            }
        </script>
    @endpush
@endsection
