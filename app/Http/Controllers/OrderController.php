<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('buyer_id', Auth::id())->with(['umkm', 'refunds'])->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $order->load('refunds');
        return view('orders.show', compact('order'));
    }

    // Temporary endpoint to handle Doku Sandbox callback when it redirects back to merchant
    // or simulating payment completion. Let's make a manual trigger to pay since the user mentioned "jika semua berhasil maka ada qr"
    public function dokuNotify(Request $request)
    {
        // For development/simulating Doku notification. Usually Doku sends Webhook here.
        // But for testing Doku Sandbox: usually it is updated directly if using their Simulator.
        // Assuming we verify signature here in a real scenario.
        $headers = collect($request->header())->map(function ($item) {
            return $item[0];
        });

        // Let's just find order by invoice
        $order = Order::where('qr_code', $request->order['invoice_number'] ?? null)->first();
        if ($order) {
            $order->status = 'PAID';
            $order->save();
        }

        return response()->json(['status' => 'OK']);
    }

    // Helper to simulate Doku redirect
    public function dokuRedirect(Request $request)
    {
        // When user is sent back from Doku
        $order = Order::where('qr_code', $request->invoice_number ?? null)
                      ->orWhere('id', $request->order_id)
                      ->first();
                      
        if ($order) {
            $order->status = 'PAID';
            $order->save();
            return redirect()->route('orders.show', $order)->with('success', 'Pembayaran Non-Tunai Doku berhasil!');
        }
        
        return redirect()->route('orders.index')->with('success', 'Kembali dari Doku.');
    }
}
