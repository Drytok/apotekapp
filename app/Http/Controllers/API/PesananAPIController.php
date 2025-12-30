<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesananAPIController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_pembeli' => 'required|string|max:255',
                'items' => 'required|array|min:1',
                'items.*.obat_id' => 'required|exists:obats,id',
                'items.*.jumlah' => 'required|integer|min:1',
                'bayar' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Cek ketersediaan stok
            $errors = [];
            $itemsData = [];
            $totalHarga = 0;

            foreach ($request->items as $index => $item) {
                $obat = Obat::find($item['obat_id']);

                if ($obat->stock_obat < $item['jumlah']) {
                    $errors[] = [
                        'obat' => $obat->nama_obat,
                        'pesan' => 'Stok tidak mencukupi. Stok tersedia: ' . $obat->stock_obat
                    ];
                } else {
                    $subtotal = $obat->harga_obat * $item['jumlah'];
                    $totalHarga += $subtotal;

                    $itemsData[] = [
                        'obat' => $obat,
                        'jumlah' => $item['jumlah'],
                        'harga_satuan' => $obat->harga_obat,
                        'subtotal' => $subtotal
                    ];
                }
            }

            if (!empty($errors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi',
                    'errors' => $errors
                ], 400);
            }

            // Validasi pembayaran
            $bayar = $request->bayar;
            if ($bayar < $totalHarga) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran kurang',
                    'total_harga' => $totalHarga,
                    'bayar' => $bayar,
                    'kekurangan' => $totalHarga - $bayar
                ], 400);
            }

            $kembalian = $bayar - $totalHarga;

            // Generate kode transaksi
            $lastTransaksi = Transaksi::latest()->first();
            $counter = $lastTransaksi ? intval(substr($lastTransaksi->kode_transaksi, -4)) + 1 : 1;
            $kodeTransaksi = 'API-' . date('Ymd') . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT);

            // Simpan transaksi
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'tanggal_transaksi' => now()->format('Y-m-d'),
                'nama_pembeli' => $request->nama_pembeli,
                'total_harga' => $totalHarga,
                'bayar' => $bayar,
                'kembalian' => $kembalian
            ]);

            // Simpan detail dan update stok
            foreach ($itemsData as $item) {
                \App\Models\TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'obat_id' => $item['obat']->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $item['subtotal']
                ]);

                // Update stok
                $item['obat']->decrement('stock_obat', $item['jumlah']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'data' => [
                    'kode_transaksi' => $transaksi->kode_transaksi,
                    'nama_pembeli' => $transaksi->nama_pembeli,
                    'tanggal' => $transaksi->tanggal_transaksi,
                    'total_harga' => $transaksi->total_harga,
                    'bayar' => $transaksi->bayar,
                    'kembalian' => $transaksi->kembalian,
                    'items' => $itemsData
                ]
            ], 201);
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
            $transaksi = Transaksi::with('details.obat')->find($id);

            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail pesanan berhasil diambil',
                'data' => $transaksi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $query = Transaksi::with('details.obat')->latest();

            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
            }

            $transaksis = $query->paginate(20);

            return response()->json([
                'success' => true,
                'message' => 'Data pesanan berhasil diambil',
                'data' => $transaksis
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
