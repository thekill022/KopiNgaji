<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class RegionController extends Controller
{
    public function provinces(): JsonResponse
    {
        $provinces = Province::orderBy('name')->get(['code as id', 'name']);
        return response()->json($provinces);
    }

    public function cities(string $provinceId): JsonResponse
    {
        $cities = City::where('province_code', $provinceId)
            ->orderBy('name')
            ->get(['code as id', 'name']);
        return response()->json($cities);
    }

    public function districts(string $cityId): JsonResponse
    {
        $districts = District::where('city_code', $cityId)
            ->orderBy('name')
            ->get(['code as id', 'name']);
        return response()->json($districts);
    }

    public function villages(string $districtId): JsonResponse
    {
        $villages = Village::where('district_code', $districtId)
            ->orderBy('name')
            ->get(['code as id', 'name']);
        return response()->json($villages);
    }
}
