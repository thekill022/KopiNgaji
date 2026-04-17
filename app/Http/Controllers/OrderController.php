<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Refund;
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

    /**
     * Buyer requests a refund for their order.
     */
    public function requestRefund(Request $request, Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        // Only PAID or COMPLETED orders can be refunded
        if (!in_array($order->status, ['PAID', 'COMPLETED'])) {
            return back()->with('error', 'Hanya pesanan dengan status PAID atau COMPLETED yang dapat diajukan refund.');
        }

        // Check if there's already a pending refund from buyer
        $existingPending = $order->refunds()
            ->where('status', 'PENDING')
            ->where('requested_by', 'BUYER')
            ->exists();

        if ($existingPending) {
            return back()->with('error', 'Anda sudah memiliki pengajuan refund yang masih menunggu diproses.');
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
        ], [
            'reason.required' => 'Alasan refund wajib diisi.',
            'reason.max' => 'Alasan refund maksimal 1000 karakter.',
        ]);

        Refund::create([
            'order_id'     => $order->id,
            'amount'       => $order->total_price,
            'reason'       => $request->reason,
            'status'       => 'PENDING',
            'requested_by' => 'BUYER',
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pengajuan refund berhasil dikirim. Silakan tunggu konfirmasi dari penjual.');
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

    /**
     * Buyer completes their order manually.
     */
    public function complete(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $allowed = match ($order->status) {
            'PENDING' => $order->payment_method === 'CASH',
            'PAID' => true,
            default => false,
        };

        if (!$allowed) {
            return back()->with('error', 'Pesanan ini tidak dapat diselesaikan saat ini.');
        }

        $order->update([
            'status' => 'COMPLETED',
            'buyer_completed_at' => now(),
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil diselesaikan. Terima kasih!');
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

