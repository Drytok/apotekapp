<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'satuan_obat',
        'harga_obat',
        'stock_obat'
    ];

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    // Accessor untuk format harga
    public function getHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga_obat, 0, ',', '.');
    }

    // Accessor untuk total nilai stok
    public function getNilaiStokAttribute()
    {
        return $this->harga_obat * $this->stock_obat;
    }
}
