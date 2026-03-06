<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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

        $orders = $umkm->orders()
            ->with(['buyer', 'items'])
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->search, function ($query, $search) {
                $query->whereHas('buyer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $statusCounts = [
            'all' => $umkm->orders()->count(),
            'PENDING' => $umkm->orders()->where('status', 'PENDING')->count(),
            'PAID' => $umkm->orders()->where('status', 'PAID')->count(),
            'COMPLETED' => $umkm->orders()->where('status', 'COMPLETED')->count(),
            'CANCELLED' => $umkm->orders()->where('status', 'CANCELLED')->count(),
        ];

        return view('seller.orders.index', compact('orders', 'statusCounts'));
    }

    public function show(Order $order)
    {
        $umkm = $this->getUmkm();

        if ($order->umkm_id !== $umkm->id) {
            abort(403);
        }

        $order->load(['buyer', 'items.product', 'payment']);

        return view('seller.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $umkm = $this->getUmkm();

        if ($order->umkm_id !== $umkm->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:COMPLETED,CANCELLED',
        ]);

        $newStatus = $request->status;

        // Validate allowed transitions
        $allowed = match ($order->status) {
            'PENDING' => ['CANCELLED'],
            'PAID' => ['COMPLETED', 'CANCELLED'],
            default => [],
        };

        if (!in_array($newStatus, $allowed)) {
            return back()->with('error', 'Transisi status tidak diizinkan.');
        }

        $order->update(['status' => $newStatus]);

        $message = $newStatus === 'COMPLETED' ? 'Pesanan berhasil diselesaikan.' : 'Pesanan berhasil dibatalkan.';

        return redirect()->route('seller.orders.show', $order)->with('success', $message);
    }
}
