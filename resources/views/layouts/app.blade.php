<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Apotek - @yield('title', 'Dashboard')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            background-color: #435ebe;
            color: white;
        }
        .btn-primary {
            background-color: #435ebe;
            border-color: #435ebe;
        }
        .btn-primary:hover {
            background-color: #3a51a5;
            border-color: #3a51a5;
        }
        .table th {
            background-color: #f1f3f9;
            color: #495057;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-warning {
            background-color: #ffc107;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .form-control:focus, .form-select:focus {
            border-color: #435ebe;
            box-shadow: 0 0 0 0.2rem rgba(67, 94, 190, 0.25);
        }
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #2f3e4e;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-left: 3px solid transparent;
        }
        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left: 3px solid #435ebe;
        }
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left: 3px solid #435ebe;
        }
        .main-content {
            padding: 20px;
        }
        .stat-card {
            border-radius: 10px;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stat-card.blue {
            background: linear-gradient(135deg, #435ebe 0%, #6a82fb 100%);
        }
        .stat-card.green {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .stat-card.orange {
            background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%);
        }
        .stat-card.red {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        }
        .stat-card i {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
        }
        .stat-card .label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #435ebe;">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-capsule-pill"></i> Apotek Sehat
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('obat.*') ? 'active' : '' }}" 
                           href="{{ route('obat.index') }}">
                            <i class="bi bi-capsule"></i> Obat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}" 
                           href="{{ route('transaksi.index') }}">
                            <i class="bi bi-cart-check"></i> Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('distributor.*') ? 'active' : '' }}" 
                           href="{{ route('distributor.index') }}">
                            <i class="bi bi-truck"></i> Distributor
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" role="button" 
                           data-bs-toggle="dropdown">
                            <i class="bi bi-graph-up"></i> Laporan
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('laporan.stok') }}">
                                    <i class="bi bi-box-seam"></i> Stok Obat
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('laporan.penjualan') }}">
                                    <i class="bi bi-receipt"></i> Penjualan
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0 sidebar d-none d-md-block">
                <div class="p-3">
                    <h6 class="text-uppercase text-muted mb-3">Menu Utama</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                               href="{{ url('/') }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('obat.*') ? 'active' : '' }}" 
                               href="{{ route('obat.index') }}">
                                <i class="bi bi-capsule me-2"></i> Data Obat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}" 
                               href="{{ route('transaksi.index') }}">
                                <i class="bi bi-cart-check me-2"></i> Transaksi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('distributor.*') ? 'active' : '' }}" 
                               href="{{ route('distributor.index') }}">
                                <i class="bi bi-truck me-2"></i> Distributor
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('distributor.maps') ? 'active' : '' }}" 
                               href="{{ route('distributor.maps') }}">
                                <i class="bi bi-map me-2"></i> Peta Distributor
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <h6 class="text-uppercase text-muted mb-3">Laporan</h6>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('laporan.stok') ? 'active' : '' }}" 
                               href="{{ route('laporan.stok') }}">
                                <i class="bi bi-box-seam me-2"></i> Laporan Stok
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('laporan.penjualan') ? 'active' : '' }}" 
                               href="{{ route('laporan.penjualan') }}">
                                <i class="bi bi-receipt me-2"></i> Laporan Penjualan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Content -->
            <div class="col-md-10 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i> 
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">@yield('title', 'Dashboard')</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-muted py-3 mt-4">
        <div class="container">
            <p class="mb-0">
                &copy; {{ date('Y') }} Aplikasi Apotek Sehat. Developed with <i class="bi bi-heart-fill text-danger"></i> using Laravel
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);

            // Confirm delete
            $('.confirm-delete').on('click', function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $(this).closest('form').submit();
                }
            });

            // Format currency
            $('.currency').on('keyup', function() {
                let value = $(this).val().replace(/[^0-9]/g, '');
                if (value) {
                    $(this).val('Rp ' + parseInt(value).toLocaleString('id-ID'));
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>