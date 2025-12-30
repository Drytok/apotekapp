<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $obats = [
            [
                'kode_obat' => 'OBT001',
                'nama_obat' => 'Paracetamol 500mg',
                'satuan_obat' => 'Tablet',
                'harga_obat' => 5000,
                'stock_obat' => 100
            ],
            [
                'kode_obat' => 'OBT002',
                'nama_obat' => 'Amoxicillin 500mg',
                'satuan_obat' => 'Kapsul',
                'harga_obat' => 15000,
                'stock_obat' => 50
            ],
            [
                'kode_obat' => 'OBT003',
                'nama_obat' => 'Vitamin C 1000mg',
                'satuan_obat' => 'Tablet',
                'harga_obat' => 25000,
                'stock_obat' => 75
            ],
            [
                'kode_obat' => 'OBT004',
                'nama_obat' => 'Salep Gentamicin',
                'satuan_obat' => 'Tube',
                'harga_obat' => 35000,
                'stock_obat' => 30
            ],
            [
                'kode_obat' => 'OBT005',
                'nama_obat' => 'Obat Batuk Hitam',
                'satuan_obat' => 'Botol',
                'harga_obat' => 20000,
                'stock_obat' => 40
            ]
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
