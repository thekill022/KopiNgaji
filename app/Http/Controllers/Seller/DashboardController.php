<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        // let owner know when their UMKM still awaiting verification
        if ($umkm && ! $umkm->is_verified) {
            session()->flash('warning', 'UMKM Anda belum diverifikasi oleh admin.');
        }

        $stats = [
            'product_count' => $umkm ? $umkm->products()->count() : 0,
            'order_count' => $umkm ? $umkm->orders()->count() : 0,
            'pending_orders' => $umkm ? $umkm->orders()->where('status', 'PENDING')->count() : 0,
            'completed_orders' => $umkm ? $umkm->orders()->where('status', 'COMPLETED')->count() : 0,
        ];

        return view('seller.dashboard', compact('umkm', 'stats'));
    }
}
