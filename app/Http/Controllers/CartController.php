<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with(['items.product.umkm'])->firstOrCreate(
            ['user_id' => auth()->id()]
        );

        // Remove items whose product no longer exists, is inactive, or not approved
        $removedCount = 0;
        foreach ($cart->items as $item) {
            if (!$item->product || !$item->product->is_active || $item->product->status !== 'APPROVED') {
                $item->delete();
                $removedCount++;
            }
        }

        if ($removedCount > 0) {
            $cart->load('items.product.umkm'); // reload after cleanup
            session()->flash('warning', "{$removedCount} produk dihapus dari keranjang karena sudah tidak tersedia.");
        }

        return view('cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check product is active and approved
        if (!$product->is_active || $product->status !== 'APPROVED') {
            return back()->with('error', 'Produk ini tidak tersedia untuk dibeli.');
        }

        // Check stock
        if ($product->stock < 1) {
            return back()->with('error', 'Stok produk habis.');
        }

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        $currentQty = $cartItem ? $cartItem->quantity : 0;
        $requestedTotal = $currentQty + $request->quantity;

        if ($requestedTotal > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok tersedia (' . $product->stock . ').');
        }

        if ($cartItem) {
            $cartItem->quantity = $requestedTotal;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'required|integer|min:1',
        ]);

        try {
            foreach ($request->items as $itemId => $quantity) {
                $cartItem = CartItem::whereHas('cart', function($q) {
                    $q->where('user_id', auth()->id());
                })->find($itemId);

                if ($cartItem) {
                    $cartItem->update(['quantity' => $quantity]);
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan perubahan.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::whereHas('cart', function($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($id);
        
        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Kuantitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $cartItem = CartItem::whereHas('cart', function($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($id);

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
