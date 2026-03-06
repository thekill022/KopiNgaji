<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = \App\Models\Product::with(['umkm', 'images'])->findOrFail($id);
        
        return view('products.show', compact('product'));
    }
}
