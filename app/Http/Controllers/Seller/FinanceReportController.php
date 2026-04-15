<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Refund;
use App\Models\Withdrawal;

class FinanceReportController extends Controller
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
        $user = Auth::user();

        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Revenue: completed orders in period
        $revenue = Order::where('umkm_id', $umkm->id)
            ->where('status', 'COMPLETED')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('net_amount');

        // COGS: sum(quantity * cost_price) for completed orders in period
        $cogs = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.umkm_id', $umkm->id)
            ->where('orders.status', 'COMPLETED')
            ->whereBetween('orders.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum(DB::raw('order_items.quantity * products.cost_price'));

        // Refunds: approved refunds for this UMKM's orders in period
        $refunds = Refund::whereHas('order', function ($q) use ($umkm, $startDate, $endDate) {
                $q->where('umkm_id', $umkm->id)
                  ->whereBetween('orders.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            })
            ->approved()
            ->sum('amount');

        // Withdrawals: pending/approved withdrawals by owner in period
        $withdrawals = Withdrawal::where('owner_id', $user->id)
            ->whereIn('status', ['PENDING', 'APPROVED'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('gross_amount');

        // Real-time available balance (not date-filtered)
        $totalEarnings = Order::where('umkm_id', $umkm->id)
            ->where('status', 'COMPLETED')
            ->where('payment_method', 'NON_CASH')
            ->sum('net_amount');

        $totalWithdrawn = Withdrawal::where('owner_id', $user->id)
            ->whereIn('status', ['PENDING', 'APPROVED'])
            ->sum('gross_amount');

        $availableBalance = max(0, (float) $totalEarnings - (float) $totalWithdrawn);

        $netProfit = max(0, (float) $revenue - (float) $cogs - (float) $refunds);

        // Daily cash flow for chart/table (revenue per day)
        $dailyRevenue = Order::where('umkm_id', $umkm->id)
            ->where('status', 'COMPLETED')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(net_amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('seller.finance.index', compact(
            'umkm', 'startDate', 'endDate', 'revenue', 'cogs', 'refunds',
            'withdrawals', 'netProfit', 'availableBalance', 'dailyRevenue'
        ));
    }
}
