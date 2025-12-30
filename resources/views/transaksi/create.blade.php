@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
    <li class="breadcrumb-item active">Transaksi Baru</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-cart-plus me-2"></i>Transaksi Penjualan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('transaksi.store') }}" method="POST" id="transaksiForm">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_transaksi" class="form-label">Kode Transaksi</label>
                                <input type="text" class="form-control" id="kode_transaksi" 
                                       name="kode_transaksi" value="{{ $kodeTransaksi }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_transaksi" 
                                       name="tanggal_transaksi" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_pembeli" class="form-label">Nama Pembeli <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_pembeli" 
                                       name="nama_pembeli" placeholder="Masukkan nama pembeli" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Total</label>
                                    <div class="form-control" id="totalDisplay">Rp 0</div>
                                    <input type="hidden" id="total_harga" name="total_harga" value="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items Section -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">
                            <i class="bi bi-list-check me-2"></i>Daftar Obat
                            <button type="button" class="btn btn-sm btn-success float-end" id="addItem">
                                <i class="bi bi-plus-circle"></i> Tambah Obat
                            </button>
                        </h6>
                        <div id="itemsContainer">
                            <div class="item-row row mb-3 border-bottom pb-3" data-index="0">
                                <div class="col-md-5">
                                    <label class="form-label">Pilih Obat <span class="text-danger">*</span></label>
                                    <select class="form-select obat-select" name="items[0][obat_id]" required 
                                            onchange="updateItem(this)">
                                        <option value="">-- Pilih Obat --</option>
                                        @foreach($obats as $obat)
                                            <option value="{{ $obat->id }}" 
                                                    data-harga="{{ $obat->harga_obat }}"
                                                    data-stok="{{ $obat->stock_obat }}">
                                                {{ $obat->nama_obat }} (Stok: {{ $obat->stock_obat }}) - Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted stok-info"></small>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control jumlah" name="items[0][jumlah]" 
                                           min="1" value="1" required oninput="updateItem(this)">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Harga Satuan</label>
                                    <input type="text" class="form-control harga" readonly>
                                    <input type="hidden" class="harga-hidden" name="items[0][harga_satuan]">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Subtotal</label>
                                    <input type="text" class="form-control subtotal" readonly>
                                    <input type="hidden" class="subtotal-hidden" name="items[0][subtotal]">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bayar" class="form-label">Jumlah Bayar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="bayar" name="bayar" 
                                           min="0" value="0" required oninput="calculateChange()">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kembalian</label>
                                <div class="form-control" id="kembalianDisplay">Rp 0</div>
                                <input type="hidden" id="kembalian" name="kembalian" value="0">
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Total Item:</strong> <span id="totalItem">0</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Total Qty:</strong> <span id="totalQty">0</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Total Harga:</strong> <span id="totalSummary">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <div>
                            <button type="reset" class="btn btn-warning me-2">
                                <i class="bi bi-arrow-clockwise me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-1"></i> Proses Transaksi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-calculator me-2"></i>Kalkulator</h6>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-3">
                    <div class="col-3"><button class="btn btn-outline-secondary w-100" onclick="addToPayment(1000)">1,000</button></div>
                    <div class="col-3"><button class="btn btn-outline-secondary w-100" onclick="addToPayment(2000)">2,000</button></div>
                    <div class="col-3"><button class="btn btn-outline-secondary w-100" onclick="addToPayment(5000)">5,000</button></div>
                    <div class="col-3"><button class="btn btn-outline-secondary w-100" onclick="addToPayment(10000)">10,000</button></div>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-3"><button class="btn btn-outline-secondary w-100" onclick="addToPayment(20000)">20,000</button></div>
                    <div class="col-3"><button class="btn btn-outline-secondary w-100" onclick="addToPayment(50000)">50,000</button></div>
                    <div class="col-3"><button class="btn btn-outline-secondary w-100" onclick="addToPayment(100000)">100,000</button></div>
                    <div class="col-3"><button class="btn btn-outline-secondary w-100" onclick="clearPayment()">Clear</button></div>
                </div>
                <div class="alert alert-warning">
                    <small><i class="bi bi-info-circle me-1"></i> Klik nominal untuk cepat</small>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Obat Populer</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($obats->take(5) as $obat)
                    <button type="button" class="list-group-item list-group-item-action" 
                            onclick="addPopularMedicine({{ $obat->id }})">
                        <div class="d-flex justify-content-between">
                            <span>{{ $obat->nama_obat }}</span>
                            <span class="badge bg-info">Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}</span>
                        </div>
                        <small class="text-muted">Stok: {{ $obat->stock_obat }}</small>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .item-row {
        transition: all 0.3s ease;
    }
    .item-row:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    let itemCount = 1;
    let itemsData = {};

    function addPopularMedicine(obatId) {
        // Add to first available row or create new
        let added = false;
        $('.obat-select').each(function() {
            if (!$(this).val() && !added) {
                $(this).val(obatId).trigger('change');
                $(this).closest('.item-row').find('.jumlah').val(1).trigger('input');
                added = true;
            }
        });
        
        if (!added) {
            addItemRow();
            setTimeout(() => {
                $('.obat-select').last().val(obatId).trigger('change');
                $('.jumlah').last().val(1).trigger('input');
            }, 100);
        }
        
        updateSummary();
    }

    function addToPayment(amount) {
        let current = parseFloat($('#bayar').val()) || 0;
        $('#bayar').val(current + amount).trigger('input');
    }

    function clearPayment() {
        $('#bayar').val(0).trigger('input');
    }

    function addItemRow() {
        let newRow = $('.item-row').first().clone();
        let newIndex = itemCount;
        
        newRow.attr('data-index', newIndex);
        newRow.find('select').attr('name', 'items[' + newIndex + '][obat_id]').val('');
        newRow.find('.jumlah').attr('name', 'items[' + newIndex + '][jumlah]').val(1);
        newRow.find('.harga-hidden').attr('name', 'items[' + newIndex + '][harga_satuan]');
        newRow.find('.subtotal-hidden').attr('name', 'items[' + newIndex + '][subtotal]');
        newRow.find('.harga').val('');
        newRow.find('.subtotal').val('');
        newRow.find('.stok-info').text('');
        
        // Add remove button for rows after first
        if (newIndex > 0) {
            let removeBtn = '<div class="col-md-1 align-self-end">' +
                '<button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeItemRow(this)">' +
                '<i class="bi bi-trash"></i></button></div>';
            newRow.find('.col-md-2').last().after(removeBtn);
        }
        
        $('#itemsContainer').append(newRow);
        itemCount++;
    }

    function removeItemRow(button) {
        $(button).closest('.item-row').remove();
        updateSummary();
        calculateChange();
    }

    function updateItem(element) {
        let row = $(element).closest('.item-row');
        let select = row.find('.obat-select');
        let jumlah = row.find('.jumlah');
        let hargaInput = row.find('.harga');
        let hargaHidden = row.find('.harga-hidden');
        let subtotalInput = row.find('.subtotal');
        let subtotalHidden = row.find('.subtotal-hidden');
        let stokInfo = row.find('.stok-info');
        
        if (select.val()) {
            let harga = parseFloat(select.find('option:selected').data('harga'));
            let stok = parseInt(select.find('option:selected').data('stok'));
            let qty = parseInt(jumlah.val()) || 0;
            
            hargaInput.val('Rp ' + harga.toLocaleString('id-ID'));
            hargaHidden.val(harga);
            
            // Check stock
            if (qty > stok) {
                stokInfo.html('<span class="text-danger">Stok hanya ' + stok + '</span>');
                jumlah.val(stok);
                qty = stok;
            } else if (stok < 10) {
                stokInfo.html('<span class="text-warning">Stok rendah: ' + stok + '</span>');
            } else {
                stokInfo.html('<span class="text-success">Stok: ' + stok + '</span>');
            }
            
            let subtotal = harga * qty;
            subtotalInput.val('Rp ' + subtotal.toLocaleString('id-ID'));
            subtotalHidden.val(subtotal);
        } else {
            hargaInput.val('');
            hargaHidden.val('');
            subtotalInput.val('');
            subtotalHidden.val('');
            stokInfo.text('');
        }
        
        updateSummary();
        calculateChange();
    }

    function updateSummary() {
        let totalItem = 0;
        let totalQty = 0;
        let totalHarga = 0;
        
        $('.item-row').each(function() {
            let select = $(this).find('.obat-select');
            let jumlah = parseFloat($(this).find('.jumlah').val()) || 0;
            
            if (select.val()) {
                totalItem++;
                totalQty += jumlah;
                
                let harga = parseFloat(select.find('option:selected').data('harga'));
                totalHarga += harga * jumlah;
            }
        });
        
        $('#totalItem').text(totalItem);
        $('#totalQty').text(totalQty);
        $('#totalSummary').text('Rp ' + totalHarga.toLocaleString('id-ID'));
        $('#totalDisplay').text('Rp ' + totalHarga.toLocaleString('id-ID'));
        $('#total_harga').val(totalHarga);
    }

    function calculateChange() {
        let total = parseFloat($('#total_harga').val()) || 0;
        let bayar = parseFloat($('#bayar').val()) || 0;
        let kembalian = bayar - total;
        
        if (kembalian >= 0) {
            $('#kembalianDisplay').text('Rp ' + kembalian.toLocaleString('id-ID'));
            $('#kembalian').val(kembalian);
            $('#kembalianDisplay').removeClass('text-danger').addClass('text-success');
        } else {
            $('#kembalianDisplay').text('Kurang Rp ' + Math.abs(kembalian).toLocaleString('id-ID'));
            $('#kembalian').val(kembalian);
            $('#kembalianDisplay').removeClass('text-success').addClass('text-danger');
        }
    }

    $(document).ready(function() {
        // Add first item row
        $('#addItem').click(addItemRow);
        
        // Initialize first row
        updateItem($('.obat-select').first());
        
        // Form validation
        $('#transaksiForm').on('submit', function(e) {
            let hasItems = false;
            $('.obat-select').each(function() {
                if ($(this).val()) {
                    hasItems = true;
                    let jumlah = $(this).closest('.item-row').find('.jumlah').val();
                    let stok = $(this).find('option:selected').data('stok');
                    
                    if (parseInt(jumlah) > parseInt(stok)) {
                        alert('Jumlah melebihi stok yang tersedia!');
                        e.preventDefault();
                        return false;
                    }
                }
            });
            
            if (!hasItems) {
                alert('Pilih minimal satu obat!');
                e.preventDefault();
                return false;
            }
            
            let total = parseFloat($('#total_harga').val()) || 0;
            let bayar = parseFloat($('#bayar').val()) || 0;
            
            if (bayar < total) {
                alert('Jumlah bayar kurang dari total harga!');
                e.preventDefault();
                return false;
            }
        });
        
        // Real-time updates
        $(document).on('change', '.obat-select', function() {
            updateItem(this);
        });
        
        $(document).on('input', '.jumlah', function() {
            updateItem(this);
        });
        
        $(document).on('input', '#bayar', calculateChange);
    });
</script>
@endpush
@endsection