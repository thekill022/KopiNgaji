<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = Umkm::where('is_verified', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('owner', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('products', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $umkms = $query->latest()->paginate(12)->withQueryString();

        // if user searched, optionally also fetch matching products across verified UMKMs
        $products = collect();
        if ($search) {
            $products = \App\Models\Product::where('name', 'like', "%{$search}%")
                ->whereHas('umkm', fn($q) => $q->where('is_verified', true))
                ->latest()
                ->paginate(12, ['*'], 'product_page')
                ->withQueryString();
        }

        return view('umkms.index', compact('umkms', 'search', 'products'));
    }

    public function show(Umkm $umkm, Request $request)
    {
        if (! $umkm->is_verified) {
            abort(404);
        }

        // product search within this UMKM
        $productSearch = $request->get('search');
        $productsQuery = $umkm->products()->latest();

        if ($productSearch) {
            $productsQuery->where('name', 'like', "%{$productSearch}%");
        }

        $products = $productsQuery->paginate(12)->withQueryString();

        return view('umkms.show', compact('umkm', 'products', 'productSearch'));
    }
}
