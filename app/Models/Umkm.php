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
        'platform_fee_rate'       => 'decimal:2',
        'platform_fee_flat'       => 'decimal:2',
        'tax_threshold'           => 'decimal:2',
        'platform_fee_rate_jasa'  => 'decimal:2',
        'platform_fee_flat_jasa'  => 'decimal:2',
        'tax_threshold_jasa'      => 'decimal:2',
        'is_verified'             => 'boolean',
    ];

    /**
     * Hitung rincian potongan saat penarikan dengan memisahkan fee Barang vs Jasa.
     *
     * Aturan:
     *  - Platform fee (% atau flat) HANYA berlaku jika total keuntungan kumulatif per tipe
     *    sudah melampaui threshold masing-masing.
     *  - Biaya admin penarikan = biaya transfer DOKU (global dari env DOKU_WITHDRAWAL_FEE).
     *
     * @param  float  $grossAmount        Jumlah bruto yang diminta ditarik
     * @param  float  $totalEarningsBarang Total keuntungan Barang kumulatif
     * @param  float  $totalEarningsJasa   Total keuntungan Jasa kumulatif
     * @return array
     */
    public function calculateWithdrawalDeductions(float $grossAmount, float $totalEarningsBarang, float $totalEarningsJasa): array
    {
        $dokuAdminFee = (float) env('DOKU_WITHDRAWAL_FEE', 6500);

        $totalEarnings = $totalEarningsBarang + $totalEarningsJasa;
        if ($totalEarnings <= 0) {
            $netDisbursed = max(0, $grossAmount - $dokuAdminFee);
            return [
                'platform_fee_deduction' => 0.0,
                'doku_admin_fee'         => $dokuAdminFee,
                'net_disbursed'          => $netDisbursed,
                'threshold_reached'      => false,
            ];
        }

        // Proporsi withdrawal per tipe
        $barangPortion = $grossAmount * ($totalEarningsBarang / $totalEarnings);
        $jasaPortion   = $grossAmount * ($totalEarningsJasa / $totalEarnings);

        // Barang fee
        $barangFee = 0.0;
        $barangThresholdReached = $this->tax_threshold > 0 && $totalEarningsBarang > $this->tax_threshold;
        if ($barangThresholdReached) {
            if ($this->platform_fee_type === 'percentage' && $this->platform_fee_rate > 0) {
                $barangFee = round($barangPortion * ($this->platform_fee_rate / 100), 2);
            } elseif ($this->platform_fee_type === 'flat' && $this->platform_fee_flat > 0) {
                $barangFee = (float) $this->platform_fee_flat;
            }
        }

        // Jasa fee
        $jasaFee = 0.0;
        $jasaThresholdReached = $this->tax_threshold_jasa > 0 && $totalEarningsJasa > $this->tax_threshold_jasa;
        if ($jasaThresholdReached) {
            if ($this->platform_fee_type_jasa === 'percentage' && $this->platform_fee_rate_jasa > 0) {
                $jasaFee = round($jasaPortion * ($this->platform_fee_rate_jasa / 100), 2);
            } elseif ($this->platform_fee_type_jasa === 'flat' && $this->platform_fee_flat_jasa > 0) {
                $jasaFee = (float) $this->platform_fee_flat_jasa;
            }
        }

        $platformFeeDeduction = $barangFee + $jasaFee;
        $netDisbursed = max(0, $grossAmount - $platformFeeDeduction - $dokuAdminFee);

        return [
            'platform_fee_deduction' => $platformFeeDeduction,
            'doku_admin_fee'         => $dokuAdminFee,
            'net_disbursed'          => $netDisbursed,
            'threshold_reached'      => $barangThresholdReached || $jasaThresholdReached,
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

    public function shippingZones()
    {
        return $this->hasMany(ShippingZone::class);
    }
}
