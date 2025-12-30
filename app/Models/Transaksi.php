<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'tanggal_transaksi',
        'nama_pembeli',
        'total_harga',
        'bayar',
        'kembalian'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    // Accessor untuk format total harga
    public function getTotalFormatAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    // Accessor untuk format bayar
    public function getBayarFormatAttribute()
    {
        return 'Rp ' . number_format($this->bayar, 0, ',', '.');
    }

    // Accessor untuk format kembalian
    public function getKembalianFormatAttribute()
    {
        return 'Rp ' . number_format($this->kembalian, 0, ',', '.');
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeFilterByDate($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
    }
}
