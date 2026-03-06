<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
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

    public function index(Request $request)
    {
        $umkm = $this->getUmkm();

        $products = $umkm->products()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $this->getUmkm();
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        $umkm = $this->getUmkm();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_preorder' => 'boolean',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product = $umkm->products()->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock,
            'is_preorder' => $request->boolean('is_preorder'),
            'status' => 'PENDING',
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'image_url' => $path,
                    'sort_order' => $index,
                ]);

                // Set first image as thumbnail
                if ($index === 0) {
                    $product->update(['image_url' => $path]);
                }
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $umkm = $this->getUmkm();

        if ($product->umkm_id !== $umkm->id) {
            abort(403);
        }

        $product->load('images');

        return view('seller.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $umkm = $this->getUmkm();

        if ($product->umkm_id !== $umkm->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_preorder' => 'boolean',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock,
            'is_preorder' => $request->boolean('is_preorder'),
        ]);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            // delete previous images from storage & database (we treat new upload as replacement)
            foreach ($product->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->image_url);
                $oldImage->delete();
            }
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
                $product->update(['image_url' => null]);
            }

            $currentMaxSort = -1; // starting fresh

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'image_url' => $path,
                    'sort_order' => $index,
                ]);

                // first uploaded image becomes thumbnail
                if ($index === 0) {
                    $product->update(['image_url' => $path]);
                }
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $umkm = $this->getUmkm();

        if ($product->umkm_id !== $umkm->id) {
            abort(403);
        }

        // Delete image files from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }

        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function deleteImage(ProductImage $productImage)
    {
        $umkm = $this->getUmkm();
        $product = $productImage->product;

        if ($product->umkm_id !== $umkm->id) {
            abort(403);
        }

        Storage::disk('public')->delete($productImage->image_url);

        // If this was the thumbnail, update it
        if ($product->image_url === $productImage->image_url) {
            $productImage->delete();
            $nextImage = $product->images()->orderBy('sort_order')->first();
            $product->update(['image_url' => $nextImage ? $nextImage->image_url : null]);
        } else {
            $productImage->delete();
        }

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
