<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;
use App\Services\WebPushService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'REFUNDED' => $umkm->orders()->where('status', 'REFUNDED')->count(),
        ];

        return view('seller.orders.index', compact('orders', 'statusCounts'));
    }

    public function scan()
    {
        $umkm = $this->getUmkm();
        return view('seller.orders.scan');
    }

    public function show(Order $order)
    {
        $umkm = $this->getUmkm();

        if ($order->umkm_id !== $umkm->id) {
            abort(403);
        }

        $order->load(['buyer', 'items.product', 'payment', 'refunds']);

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
            'PENDING' => ($order->payment_method === 'CASH') ? ['COMPLETED', 'CANCELLED'] : ['COMPLETED'],
            'PAID' => ['COMPLETED'],
            default => [],
        };

        if (!in_array($newStatus, $allowed)) {
            return back()->with('error', 'Transisi status tidak diizinkan.');
        }

        // Direct completion by seller is only allowed via QR scan
        if ($newStatus === 'COMPLETED' && $request->input('source') !== 'qr') {
            return back()->with('error', 'Penyelesaian pesanan hanya dapat dilakukan melalui scan QR.');
        }

        $updateData = ['status' => $newStatus];
        if ($newStatus === 'COMPLETED') {
            $updateData['is_scanned'] = true;
        }

        $order->update($updateData);

        $message = $newStatus === 'COMPLETED' ? 'Pesanan berhasil diselesaikan.' : 'Pesanan berhasil dibatalkan.';

        return redirect()->route('seller.orders.show', $order)->with('success', $message);
    }

    /**
     * Seller notifies buyer to complete the order.
     */
    public function notifyComplete(Order $order)
    {
        $umkm = $this->getUmkm();

        if ($order->umkm_id !== $umkm->id) {
            abort(403);
        }

        $allowed = match ($order->status) {
            'PENDING' => $order->payment_method === 'CASH',
            'PAID' => true,
            default => false,
        };

        if (!$allowed) {
            return back()->with('error', 'Pesanan ini tidak dapat dikirimi notifikasi penyelesaian saat ini.');
        }

        $order->update(['seller_completion_notified_at' => now()]);

        WebPushService::sendToUser(
            $order->buyer_id,
            'Pesanan Siap Diselesaikan',
            "Penjual {$order->umkm->name} mengkonfirmasi pesanan Anda. Silakan tekan 'Selesai' jika sudah diterima.",
            ['url' => route('orders.show', $order)]
        );

        return redirect()->route('seller.orders.show', $order)
            ->with('success', 'Notifikasi penyelesaian telah dikirim ke pembeli.');
    }

    public function refund(Request $request, Order $order)
    {
        $umkm = $this->getUmkm();

        if ($order->umkm_id !== $umkm->id) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $order->net_amount,
            'reason' => 'required|string|max:1000',
        ]);

        if (!in_array($order->status, ['PAID', 'COMPLETED'])) {
            return back()->with('error', 'Hanya pesanan dengan status PAID atau COMPLETED yang dapat direfund.');
        }

        DB::beginTransaction();
        try {
            if ($order->payment_method === 'CASH') {
                // Cash refund: immediate approval
                Refund::create([
                    'order_id' => $order->id,
                    'amount' => $request->amount,
                    'reason' => $request->reason,
                    'status' => 'APPROVED',
                    'requested_by' => 'SELLER',
                    'refunded_at' => now(),
                ]);

                // Restore stock
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }

                $order->update(['status' => 'REFUNDED']);
                DB::commit();
                return redirect()->route('seller.orders.show', $order)->with('success', 'Refund berhasil diproses. Stok produk telah dikembalikan.');
            } else {
                // Non-cash refund: pending admin manual process
                Refund::create([
                    'order_id' => $order->id,
                    'amount' => $request->amount,
                    'reason' => $request->reason,
                    'status' => 'PENDING',
                    'requested_by' => 'SELLER',
                ]);

                DB::commit();
                return redirect()->route('seller.orders.show', $order)->with('success', 'Pengajuan refund berhasil dikirim. Silakan koordinasi dengan Admin untuk proses refund DOKU.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses refund.');
        }
    }
}
