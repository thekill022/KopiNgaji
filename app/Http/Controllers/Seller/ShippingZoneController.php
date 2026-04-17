<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\District;

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
        $shippingZones = $umkm->shippingZones()->with('areas.district')->latest()->paginate(10);
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
            'district_ids' => 'required|array|min:1',
            'district_ids.*' => 'required|string',
        ], [
            'district_ids.required' => 'Minimal satu kecamatan wajib dipilih.',
            'district_ids.*.required' => 'Kecamatan tidak valid.',
        ]);

        $zone = $umkm->shippingZones()->create([
            'name' => $validated['name'],
            'cost' => $validated['cost'],
        ]);

        $districts = District::whereIn('code', $validated['district_ids'])->pluck('name', 'code');

        foreach ($validated['district_ids'] as $districtId) {
            $zone->areas()->create([
                'district_id' => $districtId,
                'area_name' => $districts[$districtId] ?? $districtId,
            ]);
        }

        return redirect()->route('seller.shipping-zones.index')->with('success', 'Zona pengiriman berhasil ditambahkan.');
    }

    public function edit(ShippingZone $shippingZone)
    {
        $umkm = $this->getUmkm();

        if ($shippingZone->umkm_id !== $umkm->id) {
            abort(403);
        }

        $shippingZone->load('areas.district.city');

        $defaultDistrict = $shippingZone->areas->first()?->district;
        $defaultCityId = $defaultDistrict?->city_code;
        $defaultProvinceId = $defaultDistrict?->city?->province_code;

        return view('seller.shipping-zones.edit', compact('shippingZone', 'defaultCityId', 'defaultProvinceId'));
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
            'district_ids' => 'required|array|min:1',
            'district_ids.*' => 'required|string',
        ], [
            'district_ids.required' => 'Minimal satu kecamatan wajib dipilih.',
            'district_ids.*.required' => 'Kecamatan tidak valid.',
        ]);

        $shippingZone->update([
            'name' => $validated['name'],
            'cost' => $validated['cost'],
        ]);

        $districts = District::whereIn('code', $validated['district_ids'])->pluck('name', 'code');

        $shippingZone->areas()->delete();
        foreach ($validated['district_ids'] as $districtId) {
            $shippingZone->areas()->create([
                'district_id' => $districtId,
                'area_name' => $districts[$districtId] ?? $districtId,
            ]);
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
