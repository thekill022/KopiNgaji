<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = \App\Models\Product::with(['umkm', 'images'])->findOrFail($id);
        
        if (!$product->is_active || $product->status !== 'APPROVED') {
            abort(404);
        }

        return view('products.show', compact('product'));
    }
}
