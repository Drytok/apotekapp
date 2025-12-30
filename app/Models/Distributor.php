<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_distributor',
        'nama_distributor',
        'alamat',
        'telepon',
        'email',
        'latitude',
        'longitude'
    ];

    // Accessor untuk alamat singkat
    public function getAlamatSingkatAttribute()
    {
        if (strlen($this->alamat) > 50) {
            return substr($this->alamat, 0, 50) . '...';
        }
        return $this->alamat;
    }
}
