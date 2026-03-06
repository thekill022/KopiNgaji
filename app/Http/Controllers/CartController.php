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
        
        return view('cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
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

        foreach ($request->items as $itemId => $quantity) {
            $cartItem = CartItem::whereHas('cart', function($q) {
                $q->where('user_id', auth()->id());
            })->find($itemId);

            if ($cartItem) {
                $cartItem->update(['quantity' => $quantity]);
            }
        }

        return response()->json(['success' => true]);
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
