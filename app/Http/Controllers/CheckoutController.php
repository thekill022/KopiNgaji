<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingZone;
use App\Services\DokuService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('items.product.umkm')->where('user_id', auth()->id())->first();

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // We assume all items are from the same UMKM for simplicity, or we can handle multiple UMKMs.
        // For this application, let's group by UMKM, or just take the first UMKM if the app forces single UMKM checkout.
        // Assuming current logic: Kopi Ngaji might just process the whole cart. We will link order to the first product's umkm_id temporarily or handle it properly. 
        // Based on the migration, `orders` has `umkm_id`. This implies 1 order = 1 UMKM.
        // Let's validate if current cart has multiple UMKMs and take the first one.
        $firstItem = $cart->items->first();
        $umkmId = $firstItem->product->umkm_id;

        // Prevent owner from checking out their own UMKM
        $umkm = $firstItem->product->umkm;
        if ($umkm && $umkm->owner_id === auth()->id()) {
            return redirect()->route('cart.index')->with('error', 'Anda tidak dapat melakukan checkout untuk produk dari UMKM Anda sendiri.');
        }

        $totalPrice = 0;
        foreach ($cart->items as $item) {
            if ($item->product->umkm_id == $umkmId) {
                $totalPrice += ($item->product->price * $item->quantity);
            }
        }

        $shippingZones = ShippingZone::where('umkm_id', $umkmId)->with('areas')->get();

        return view('checkout.index', compact('cart', 'totalPrice', 'umkmId', 'shippingZones'));
    }

    public function store(Request $request, DokuService $dokuService)
    {
        $request->validate([
            'payment_method' => 'required|in:CASH,NON_CASH',
            'delivery_method' => 'required|in:AMBIL_LOKASI,KIRIM_ALAMAT',
            'shipping_address' => 'required_if:delivery_method,KIRIM_ALAMAT|nullable|string',
            'shipping_zone_id' => 'required_if:delivery_method,KIRIM_ALAMAT|nullable|exists:shipping_zones,id',
            'whatsapp' => 'required|string|max:20',
        ]);

        $cart = Cart::with('items.product')->where('user_id', auth()->id())->first();

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $user = auth()->user();
        $firstItem = $cart->items->first();
        $umkmId = $firstItem->product->umkm_id;

        // Prevent owner from checking out their own UMKM
        $umkm = $firstItem->product->umkm;
        if ($umkm && $umkm->owner_id === auth()->id()) {
            return redirect()->route('cart.index')->with('error', 'Anda tidak dapat melakukan checkout untuk produk dari UMKM Anda sendiri.');
        }

        $subtotal = 0;
        foreach ($cart->items as $item) {
            if ($item->product->umkm_id == $umkmId) {
                $subtotal += ($item->product->price * $item->quantity);
            }
        }

        DB::beginTransaction();
        try {
            // Validate stock and product availability before processing
            $errors = [];
            foreach ($cart->items as $item) {
                if ($item->product->umkm_id != $umkmId) continue;

                if (!$item->product->is_active || $item->product->status !== 'APPROVED') {
                    $errors[] = '"' . $item->product->name . '" sudah tidak tersedia.';
                } elseif ($item->product->stock < $item->quantity) {
                    $errors[] = 'Stok "' . $item->product->name . '" tidak mencukupi (tersedia: ' . $item->product->stock . ').';
                }
            }

            if (!empty($errors)) {
                DB::rollBack();
                return back()->with('error', implode(' ', $errors));
            }

            $shippingZone = null;
            $shippingCost = 0;
            if ($request->delivery_method === 'KIRIM_ALAMAT' && $request->shipping_zone_id) {
                $shippingZone = ShippingZone::where('id', $request->shipping_zone_id)->where('umkm_id', $umkmId)->first();
                if (!$shippingZone) {
                    DB::rollBack();
                    return back()->with('error', 'Zona pengiriman tidak valid.');
                }
                $shippingCost = $shippingZone->cost;
            }

            $invoiceNumber = 'INV-' . strtoupper(Str::random(10));
            $order = Order::create([
                'buyer_id' => $user->id,
                'umkm_id' => $umkmId,
                'shipping_zone_id' => $shippingZone?->id,
                'status' => 'PENDING',
                'payment_method' => $request->payment_method,
                'delivery_method' => $request->delivery_method,
                'shipping_address' => $request->shipping_address,
                'total_price' => $subtotal + $shippingCost,
                'subtotal_amount' => $subtotal,
                'net_amount' => $subtotal + $shippingCost,
                'whatsapp' => $request->whatsapp,
                'qr_code' => $invoiceNumber,
            ]);

            foreach ($cart->items as $item) {
                if ($item->product->umkm_id == $umkmId) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                        'product_type' => $item->product->type,
                    ]);

                    // Reduce stock
                    $item->product->decrement('stock', $item->quantity);
                    $item->delete(); // Remove from cart
                }
            }

            // Doku Integration
            if ($request->payment_method === 'NON_CASH') {
                $dokuData = [
                    'invoice_number' => $invoiceNumber,
                    'amount' => $subtotal + $shippingCost,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                ];

                try {
                    $paymentResponse = $dokuService->createPaymentUrl($dokuData);
                    if (isset($paymentResponse['response']['payment']['url'])) {
                        $order->update([
                            'doku_invoice_id' => $paymentResponse['response']['order']['invoice_number'] ?? null,
                            'doku_payment_url' => $paymentResponse['response']['payment']['url']
                        ]);
                    } else {
                        DB::rollBack();
                        return back()->with('error', 'Gagal menghubungi layanan pembayaran. Silakan coba lagi.');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    return back()->with('error', 'Layanan pembayaran sedang gangguan. Silakan coba lagi nanti.');
                }
            }

            DB::commit();

            if ($order->payment_method === 'NON_CASH' && $order->doku_payment_url) {
                return redirect()->away($order->doku_payment_url);
            }

            return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
        }
    }
}
