<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    /** Hitung total keuntungan DOKU dan saldo tersedia dengan breakdown Barang/Jasa */
    private function earningsData(): array
    {
        $user = Auth::user();
        if (!$user->umkm) {
            return [
                'total_earnings'        => 0,
                'total_earnings_barang' => 0,
                'total_earnings_jasa'   => 0,
                'available_balance'     => 0,
            ];
        }

        $totalEarnings = Order::where('umkm_id', $user->umkm->id)
            ->where('status', 'COMPLETED')
            ->where('payment_method', 'NON_CASH')
            ->sum('net_amount');

        $barangEarnings = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.umkm_id', $user->umkm->id)
            ->where('orders.status', 'COMPLETED')
            ->where('orders.payment_method', 'NON_CASH')
            ->where('order_items.product_type', 'BARANG')
            ->sum(DB::raw('order_items.quantity * order_items.price'));

        $jasaEarnings = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.umkm_id', $user->umkm->id)
            ->where('orders.status', 'COMPLETED')
            ->where('orders.payment_method', 'NON_CASH')
            ->where('order_items.product_type', 'JASA')
            ->sum(DB::raw('order_items.quantity * order_items.price'));

        $totalWithdrawn = Withdrawal::where('owner_id', $user->id)
            ->whereIn('status', ['PENDING', 'APPROVED'])
            ->sum('gross_amount');

        return [
            'total_earnings'        => (float) $totalEarnings,
            'total_earnings_barang' => (float) $barangEarnings,
            'total_earnings_jasa'   => (float) $jasaEarnings,
            'available_balance'     => max(0, (float) $totalEarnings - (float) $totalWithdrawn),
        ];
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user->umkm) abort(403, 'Akses ditolak. Anda belum memiliki UMKM.');
        if (!$user->is_verified) abort(403, 'Akses ditolak. Akun Anda belum diverifikasi oleh admin.');

        $withdrawals      = Withdrawal::where('owner_id', $user->id)->latest()->paginate(10);
        $data             = $this->earningsData();
        $availableBalance = $data['available_balance'];

        return view('seller.withdrawals.index', compact('withdrawals', 'availableBalance'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->umkm) abort(403, 'Akses ditolak.');
        if (!$user->is_verified) abort(403, 'Akses ditolak. Akun Anda belum diverifikasi oleh admin.');

        $hasPending = Withdrawal::where('owner_id', $user->id)->where('status', 'PENDING')->exists();
        if ($hasPending) {
            return redirect()->route('seller.withdrawals.index')
                ->with('error', 'Anda masih memiliki penarikan dana yang berstatus PENDING. Silakan tunggu hingga diproses Admin sebelum mengajukan yang baru.');
        }

        $data             = $this->earningsData();
        $availableBalance = $data['available_balance'];
        $totalEarnings    = $data['total_earnings'];
        $totalEarningsBarang = $data['total_earnings_barang'];
        $totalEarningsJasa   = $data['total_earnings_jasa'];
        $umkm             = $user->umkm;

        return view('seller.withdrawals.create', compact('availableBalance', 'totalEarnings', 'totalEarningsBarang', 'totalEarningsJasa', 'umkm'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->umkm) abort(403);
        if (!$user->is_verified) abort(403, 'Akses ditolak. Akun Anda belum diverifikasi oleh admin.');

        $hasPending = Withdrawal::where('owner_id', $user->id)->where('status', 'PENDING')->exists();
        if ($hasPending) {
            return redirect()->route('seller.withdrawals.index')
                ->with('error', 'Anda sudah memiliki permintaan PENDING.');
        }

        $data             = $this->earningsData();
        $availableBalance = $data['available_balance'];
        $totalEarnings    = $data['total_earnings'];
        $totalEarningsBarang = $data['total_earnings_barang'];
        $totalEarningsJasa   = $data['total_earnings_jasa'];

        $request->validate([
            'amount'       => ['required', 'numeric', 'min:50000', 'max:' . max(50000, $availableBalance)],
            'account_name' => 'required|string|max:255',
            'bank_name'    => 'required|string|max:255',
            'bank_code'    => 'required|string|max:20',
            'bank_account' => 'required|string|max:255',
        ], [
            'amount.min'        => 'Penarikan minimal Rp 50.000',
            'amount.max'        => 'Saldo Anda tidak mencukupi.',
            'account_name.required' => 'Nama pemilik rekening wajib diisi.',
            'bank_code.required'    => 'Silakan pilih bank/e-wallet tujuan.',
        ]);

        if ($request->amount > $availableBalance) {
            return back()->withInput()->with('error', 'Saldo tidak mencukupi.');
        }

        // Hitung deductions
        $umkm       = $user->umkm;
        $gross      = (float) $request->amount;
        $deductions = $umkm->calculateWithdrawalDeductions($gross, $totalEarningsBarang, $totalEarningsJasa);

        Withdrawal::create([
            'owner_id'               => $user->id,
            'amount'                 => $gross,
            'gross_amount'           => $gross,
            'platform_fee_deduction' => $deductions['platform_fee_deduction'],
            'admin_fee_amount'       => $deductions['doku_admin_fee'],
            'net_disbursed'          => $deductions['net_disbursed'],
            'account_name'           => $request->account_name,
            'bank_name'              => $request->bank_name,
            'bank_code'              => $request->bank_code,
            'bank_account'           => $request->bank_account,
            'status'                 => 'PENDING',
        ]);

        return redirect()->route('seller.withdrawals.index')
            ->with('success', 'Permintaan penarikan dana berhasil diajukan dan sedang diproses admin.');
    }
}
