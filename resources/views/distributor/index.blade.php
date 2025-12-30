@extends('layouts.app')

@section('title', 'Data Distributor')
@section('breadcrumb')
    <li class="breadcrumb-item active">Distributor</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-truck me-2"></i>Data Distributor</h5>
            <div>
                <a href="{{ route('distributor.maps') }}" class="btn btn-info btn-sm me-2">
                    <i class="bi bi-map me-1"></i> Lihat Peta
                </a>
                <a href="{{ route('distributor.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Distributor
                </a>
            </div>
        </div>
        <div class="card-body">
            @if ($distributors->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="distributorTable">
                        <thead class="table-dark">
                            <tr>
                                <th width="50">No</th>
                                <th>Kode</th>
                                <th>Nama Distributor</th>
                                <th>Alamat</th>
                                <th>Kontak</th>
                                <th>Koordinat</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($distributors as $index => $distributor)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $distributor->kode_distributor }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $distributor->nama_distributor }}</strong>
                                        @if ($distributor->email)
                                            <br>
                                            <small class="text-muted">
                                                <i class="bi bi-envelope"></i> {{ $distributor->email }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="max-width: 250px;">
                                            {{ $distributor->alamat_singkat }}
                                        </div>
                                    </td>
                                    <td>
                                        <i class="bi bi-telephone"></i> {{ $distributor->telepon }}
                                    </td>
                                    <td class="text-center">
                                        @if ($distributor->latitude && $distributor->longitude)
                                            <span class="badge bg-success">
                                                <i class="bi bi-geo-alt"></i> Ada
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="bi bi-geo-alt"></i> Belum
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('distributor.show', $distributor->id) }}"
                                            class="btn btn-info btn-sm" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('distributor.edit', $distributor->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('distributor.destroy', $distributor->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus distributor ini?')">
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
                                <td colspan="6" class="text-end"><strong>Total Distributor:</strong></td>
                                <td><strong>{{ $distributors->count() }} distributor</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-truck display-1 text-muted"></i>
                    <h4 class="mt-3 text-muted">Belum Ada Data Distributor</h4>
                    <p class="text-muted">Tambahkan distributor pertama Anda untuk mulai mengelola data</p>
                    <a href="{{ route('distributor.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Distributor Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Map Preview Modal -->
    <div class="modal fade" id="mapModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Peta Lokasi Distributor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="mapPreview" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <style>
            .map-marker {
                cursor: pointer;
                transition: transform 0.2s;
            }

            .map-marker:hover {
                transform: scale(1.1);
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            $(document).ready(function() {
                let map = null;
                let markers = [];

                function showMap(lat, lng, title, alamat) {
                    if (map) {
                        map.remove();
                        markers.forEach(marker => marker.remove());
                        markers = [];
                    }

                    $('#mapModal').modal('show');

                    // Initialize map after modal is shown
                    $('#mapModal').on('shown.bs.modal', function() {
                        map = L.map('mapPreview').setView([lat, lng], 15);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(map);

                        let marker = L.marker([lat, lng]).addTo(map)
                            .bindPopup(`<b>${title}</b><br>${alamat}`)
                            .openPopup();

                        markers.push(marker);
                    });
                }

                // View map button click
                $('.view-map').click(function() {
                    let lat = $(this).data('lat');
                    let lng = $(this).data('lng');
                    let title = $(this).data('title');
                    let alamat = $(this).data('alamat');

                    showMap(lat, lng, title, alamat);
                });

                // Search functionality
                $('#searchInput').on('keyup', function() {
                    let value = $(this).val().toLowerCase();
                    $('#distributorTable tbody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });
            });
        </script>
    @endpush
@endsection
