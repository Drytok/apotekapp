<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatAPIController extends Controller
{
    public function index()
    {
        try {
            $obats = Obat::all();

            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil diambil',
                'data' => $obats,
                'total' => $obats->count()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $obat = Obat::find($id);

            if (!$obat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Obat tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil diambil',
                'data' => $obat
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkStock($kode)
    {
        try {
            $obat = Obat::where('kode_obat', $kode)->first();

            if (!$obat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Obat dengan kode ' . $kode . ' tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Stok obat berhasil diambil',
                'data' => [
                    'kode_obat' => $obat->kode_obat,
                    'nama_obat' => $obat->nama_obat,
                    'stock_obat' => $obat->stock_obat,
                    'harga_obat' => $obat->harga_obat,
                    'satuan_obat' => $obat->satuan_obat,
                    'status' => $obat->stock_obat > 0 ? 'Tersedia' : 'Habis'
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function stockLow()
    {
        try {
            $obats = Obat::where('stock_obat', '<', 10)
                ->orderBy('stock_obat')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data obat stok rendah berhasil diambil',
                'data' => $obats,
                'total' => $obats->count()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
