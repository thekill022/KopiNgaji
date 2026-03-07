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
            $products = \App\Models\Product::with('umkm')
                ->where('name', 'like', "%{$search}%")
                ->where('is_active', true)
                ->where('status', 'APPROVED')
                ->whereHas('umkm', fn($q) => $q->where('is_verified', true))
                ->latest()
                ->paginate(12, ['*'], 'product_page')
                ->withQueryString();
        }

        if ($request->expectsJson()) {
            return response()->json([
                'umkms' => $umkms->map(fn($u) => [
                    'id' => $u->id,
                    'name' => $u->name,
                    'description' => $u->description,
                    'url' => route('umkms.show', $u),
                ]),
                'products' => $products instanceof \Illuminate\Pagination\LengthAwarePaginator
                    ? $products->map(fn($p) => [
                        'id' => $p->id,
                        'name' => $p->name,
                        'price' => $p->price,
                        'stock' => $p->stock,
                        'image_url' => $p->image_url ? asset('storage/' . $p->image_url) : null,
                        'is_preorder' => $p->is_preorder,
                        'umkm_name' => $p->umkm->name ?? '',
                        'umkm_url' => $p->umkm ? route('umkms.show', $p->umkm) : '#',
                        'url' => route('products.show', $p),
                        'cart_url' => route('cart.store'),
                    ])
                    : [],
                'umkm_count' => $umkms->total(),
            ]);
        }

        return view('umkms.index', compact('umkms', 'search', 'products'));
    }

    public function show(Umkm $umkm, Request $request)
    {
        if (! $umkm->is_verified) {
            abort(404);
        }

        // product search within this UMKM
        $productSearch = $request->get('productSearch');
        $productsQuery = $umkm->products()->where('is_active', true)->where('status', 'APPROVED')->latest();

        if ($productSearch) {
            $productsQuery->where('name', 'like', "%{$productSearch}%");
        }

        $products = $productsQuery->paginate(12)->withQueryString();

        if ($request->expectsJson()) {
            return response()->json([
                'products' => $products->map(fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => $p->price,
                    'stock' => $p->stock,
                    'image_url' => $p->image_url ? asset('storage/' . $p->image_url) : null,
                    'is_preorder' => $p->is_preorder,
                    'url' => route('products.show', $p),
                    'cart_url' => route('cart.store'),
                ]),
                'total' => $products->total(),
            ]);
        }

        return view('umkms.show', compact('umkm', 'products', 'productSearch'));
    }
}
