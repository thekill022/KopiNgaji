<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        // let owner know when their account or UMKM still awaiting verification
        if ($user->is_verified && $umkm && ! $umkm->is_verified) {
            session()->flash('warning', 'UMKM Anda belum diverifikasi oleh admin.');
        } elseif (! $user->is_verified && $umkm && $umkm->is_verified) {
            session()->flash('warning', 'Akun Anda belum diverifikasi oleh admin. UMKM tidak dapat berjualan sampai akun diverifikasi.');
        } elseif (! $user->is_verified && $umkm && ! $umkm->is_verified) {
            session()->flash('warning', 'Akun dan UMKM Anda belum diverifikasi oleh admin.');
        }

        $totalRevenue = 0;
        $availableBalance = 0;

        if ($umkm) {
            $totalRevenue = Order::where('umkm_id', $umkm->id)
                ->where('status', 'COMPLETED')
                ->sum('net_amount');

            $nonCashRevenue = Order::where('umkm_id', $umkm->id)
                ->where('status', 'COMPLETED')
                ->where('payment_method', 'NON_CASH')
                ->sum('net_amount');

            $totalWithdrawn = Withdrawal::where('owner_id', $user->id)
                ->whereIn('status', ['PENDING', 'APPROVED'])
                ->sum('amount');

            $availableBalance = max(0, $nonCashRevenue - $totalWithdrawn);
        }

        $stats = [
            'product_count' => $umkm ? $umkm->products()->count() : 0,
            'order_count' => $umkm ? $umkm->orders()->count() : 0,
            'pending_orders' => $umkm ? $umkm->orders()->where('status', 'PENDING')->count() : 0,
            'completed_orders' => $umkm ? $umkm->orders()->where('status', 'COMPLETED')->count() : 0,
            'total_revenue' => $totalRevenue,
            'available_balance' => $availableBalance,
        ];

        return view('seller.dashboard', compact('umkm', 'stats'));
    }
}
