<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributor::orderBy('nama_distributor')->get();
        return view('distributor.index', compact('distributors'));
    }

    public function create()
    {
        return view('distributor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_distributor' => 'required|unique:distributors|max:45',
            'nama_distributor' => 'required|max:255',
            'alamat' => 'required',
            'telepon' => 'required|max:20',
            'email' => 'nullable|email',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180'
        ]);

        Distributor::create($request->all());
        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil ditambahkan!');
    }

    public function show(Distributor $distributor)
    {
        return view('distributor.show', compact('distributor'));
    }

    public function edit(Distributor $distributor)
    {
        return view('distributor.edit', compact('distributor'));
    }

    public function update(Request $request, Distributor $distributor)
    {
        $request->validate([
            'kode_distributor' => 'required|max:45|unique:distributors,kode_distributor,' . $distributor->id,
            'nama_distributor' => 'required|max:255',
            'alamat' => 'required',
            'telepon' => 'required|max:20',
            'email' => 'nullable|email',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180'
        ]);

        $distributor->update($request->all());
        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil diperbarui!');
    }

    public function destroy(Distributor $distributor)
    {
        $distributor->delete();
        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil dihapus!');
    }

    public function maps()
    {
        $distributors = Distributor::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // Default location (Jakarta) jika tidak ada distributor
        $defaultLat = -6.2088;
        $defaultLng = 106.8456;

        if ($distributors->count() > 0) {
            $defaultLat = $distributors->first()->latitude;
            $defaultLng = $distributors->first()->longitude;
        }

        return view('distributor.maps', compact('distributors', 'defaultLat', 'defaultLng'));
    }
}
