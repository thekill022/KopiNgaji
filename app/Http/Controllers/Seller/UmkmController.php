<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmController extends Controller
{
    public function create()
    {
        // owner can only have one UMKM
        if (Auth::user()->umkm) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.umkm.create');
    }

    public function edit()
    {
        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            return redirect()->route('seller.dashboard')->with('error', 'UMKM belum terdaftar.');
        }

        return view('seller.umkm.edit', compact('umkm'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'province_id' => 'nullable|string',
            'city_id' => 'nullable|string',
            'district_id' => 'nullable|string',
            'village_id' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if (Auth::user()->umkm) {
            return redirect()->route('seller.dashboard');
        }

        Auth::user()->umkm()->create($request->only([
            'name', 'description', 'province_id', 'city_id', 'district_id', 'village_id',
            'address', 'latitude', 'longitude',
        ]));

        return redirect()->route('seller.dashboard')
            ->with('success', 'UMKM berhasil didaftarkan. Silakan tunggu verifikasi oleh admin.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'province_id' => 'nullable|string',
            'city_id' => 'nullable|string',
            'district_id' => 'nullable|string',
            'village_id' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            return redirect()->route('seller.dashboard')->with('error', 'UMKM belum terdaftar.');
        }

        $umkm->update($request->only([
            'name', 'description', 'province_id', 'city_id', 'district_id', 'village_id',
            'address', 'latitude', 'longitude',
        ]));

        return redirect()->route('seller.umkm.edit')->with('success', 'UMKM berhasil diperbarui.');
    }
}
