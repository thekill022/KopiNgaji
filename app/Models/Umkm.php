<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    /** @use HasFactory<\Database\Factories\UmkmFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'platform_fee_rate'  => 'decimal:2',
        'platform_fee_flat'  => 'decimal:2',
        'tax_threshold'      => 'decimal:2',
        'is_verified'        => 'boolean',
    ];

    /**
     * Hitung rincian potongan saat penarikan.
     *
     * Aturan:
     *  - Platform fee (% atau flat) HANYA berlaku jika total keuntungan kumulatif UMKM
     *    sudah melampaui `tax_threshold`. Di bawah threshold = 0 potongan platform.
     *  - Biaya admin penarikan = biaya transfer DOKU (global dari env DOKU_WITHDRAWAL_FEE).
     *    Biaya ini ditanggung UMKM (dipotong dari dana yang dikirim).
     *
     * @param  float  $grossAmount   Jumlah bruto yang diminta ditarik
     * @param  float  $totalEarnings Total keuntungan kumulatif UMKM dari pembayaran DOKU
     * @return array  [platform_fee_deduction, doku_admin_fee, net_disbursed]
     */
    public function calculateWithdrawalDeductions(float $grossAmount, float $totalEarnings): array
    {
        // Biaya admin DOKU (global)
        $dokuAdminFee = (float) env('DOKU_WITHDRAWAL_FEE', 6500);

        // Platform fee hanya berlaku jika threshold > 0 DAN kumulatif sudah melampaui threshold
        $platformFeeDeduction = 0.0;
        $thresholdReached = $this->tax_threshold > 0 && $totalEarnings > $this->tax_threshold;

        if ($thresholdReached) {
            if ($this->platform_fee_type === 'percentage' && $this->platform_fee_rate > 0) {
                $platformFeeDeduction = round($grossAmount * ($this->platform_fee_rate / 100), 2);
            } elseif ($this->platform_fee_type === 'flat' && $this->platform_fee_flat > 0) {
                $platformFeeDeduction = (float) $this->platform_fee_flat;
            }
        }

        $netDisbursed = max(0, $grossAmount - $platformFeeDeduction - $dokuAdminFee);

        return [
            'platform_fee_deduction' => $platformFeeDeduction,
            'doku_admin_fee'         => $dokuAdminFee,
            'net_disbursed'          => $netDisbursed,
            'threshold_reached'      => $thresholdReached,
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
