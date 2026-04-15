<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingZoneController extends Controller
{
    private function getUmkm()
    {
        $umkm = Auth::user()->umkm;

        if (! $umkm) {
            abort(403, 'UMKM belum terdaftar.');
        }

        if (! $umkm->is_verified) {
            abort(403, 'UMKM belum diverifikasi oleh admin.');
        }

        return $umkm;
    }

    public function index()
    {
        $umkm = $this->getUmkm();
        $shippingZones = $umkm->shippingZones()->with('areas')->latest()->paginate(10);
        return view('seller.shipping-zones.index', compact('shippingZones'));
    }

    public function create()
    {
        $this->getUmkm();
        return view('seller.shipping-zones.create');
    }

    public function store(Request $request)
    {
        $umkm = $this->getUmkm();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'areas' => 'required|array|min:1',
            'areas.*' => 'required|string|max:255',
        ], [
            'areas.required' => 'Minimal satu area pengiriman wajib diisi.',
            'areas.*.required' => 'Nama area tidak boleh kosong.',
        ]);

        $zone = $umkm->shippingZones()->create([
            'name' => $validated['name'],
            'cost' => $validated['cost'],
        ]);

        foreach ($validated['areas'] as $areaName) {
            $zone->areas()->create(['area_name' => $areaName]);
        }

        return redirect()->route('seller.shipping-zones.index')->with('success', 'Zona pengiriman berhasil ditambahkan.');
    }

    public function edit(ShippingZone $shippingZone)
    {
        $umkm = $this->getUmkm();

        if ($shippingZone->umkm_id !== $umkm->id) {
            abort(403);
        }

        $shippingZone->load('areas');
        return view('seller.shipping-zones.edit', compact('shippingZone'));
    }

    public function update(Request $request, ShippingZone $shippingZone)
    {
        $umkm = $this->getUmkm();

        if ($shippingZone->umkm_id !== $umkm->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'areas' => 'required|array|min:1',
            'areas.*' => 'required|string|max:255',
        ], [
            'areas.required' => 'Minimal satu area pengiriman wajib diisi.',
            'areas.*.required' => 'Nama area tidak boleh kosong.',
        ]);

        $shippingZone->update([
            'name' => $validated['name'],
            'cost' => $validated['cost'],
        ]);

        $shippingZone->areas()->delete();
        foreach ($validated['areas'] as $areaName) {
            $shippingZone->areas()->create(['area_name' => $areaName]);
        }

        return redirect()->route('seller.shipping-zones.index')->with('success', 'Zona pengiriman berhasil diperbarui.');
    }

    public function destroy(ShippingZone $shippingZone)
    {
        $umkm = $this->getUmkm();

        if ($shippingZone->umkm_id !== $umkm->id) {
            abort(403);
        }

        $shippingZone->areas()->delete();
        $shippingZone->delete();

        return redirect()->route('seller.shipping-zones.index')->with('success', 'Zona pengiriman berhasil dihapus.');
    }
}
