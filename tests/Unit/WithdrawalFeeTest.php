<?php

namespace Tests\Unit;

use App\Models\Umkm;
use Tests\TestCase;

class WithdrawalFeeTest extends TestCase
{
    public function test_no_fee_when_below_both_thresholds()
    {
        $umkm = new Umkm([
            'tax_threshold' => 100000,
            'platform_fee_type' => 'percentage',
            'platform_fee_rate' => 10,
            'platform_fee_flat' => 5000,
            'tax_threshold_jasa' => 100000,
            'platform_fee_type_jasa' => 'percentage',
            'platform_fee_rate_jasa' => 5,
            'platform_fee_flat_jasa' => 3000,
        ]);

        $result = $umkm->calculateWithdrawalDeductions(50000, 50000, 50000);

        $this->assertEquals(0.0, $result['platform_fee_deduction']);
        $this->assertEquals(6500.0, $result['doku_admin_fee']);
        $this->assertEquals(43500.0, $result['net_disbursed']);
    }

    public function test_barang_fee_only_when_barang_above_threshold()
    {
        $umkm = new Umkm([
            'tax_threshold' => 100000,
            'platform_fee_type' => 'percentage',
            'platform_fee_rate' => 10,
            'platform_fee_flat' => 5000,
            'tax_threshold_jasa' => 100000,
            'platform_fee_type_jasa' => 'percentage',
            'platform_fee_rate_jasa' => 5,
            'platform_fee_flat_jasa' => 3000,
        ]);

        // Barang earnings 200k (above threshold), Jasa 50k (below)
        // Withdraw 100k -> barang portion = 100k * (200k/250k) = 80k
        // barang fee = 10% * 80k = 8k
        $result = $umkm->calculateWithdrawalDeductions(100000, 200000, 50000);

        $this->assertEquals(8000.0, $result['platform_fee_deduction']);
        $this->assertEquals(6500.0, $result['doku_admin_fee']);
        $this->assertEquals(85500.0, $result['net_disbursed']);
    }

    public function test_jasa_fee_only_when_jasa_above_threshold()
    {
        $umkm = new Umkm([
            'tax_threshold' => 100000,
            'platform_fee_type' => 'percentage',
            'platform_fee_rate' => 10,
            'platform_fee_flat' => 5000,
            'tax_threshold_jasa' => 100000,
            'platform_fee_type_jasa' => 'flat',
            'platform_fee_rate_jasa' => 5,
            'platform_fee_flat_jasa' => 3000,
        ]);

        // Barang earnings 50k (below), Jasa 200k (above)
        // Withdraw 100k -> jasa portion = 100k * (200k/250k) = 80k
        // jasa fee = flat 3k
        $result = $umkm->calculateWithdrawalDeductions(100000, 50000, 200000);

        $this->assertEquals(3000.0, $result['platform_fee_deduction']);
        $this->assertEquals(6500.0, $result['doku_admin_fee']);
        $this->assertEquals(90500.0, $result['net_disbursed']);
    }

    public function test_both_fees_when_both_above_threshold()
    {
        $umkm = new Umkm([
            'tax_threshold' => 100000,
            'platform_fee_type' => 'percentage',
            'platform_fee_rate' => 10,
            'platform_fee_flat' => 5000,
            'tax_threshold_jasa' => 100000,
            'platform_fee_type_jasa' => 'percentage',
            'platform_fee_rate_jasa' => 5,
            'platform_fee_flat_jasa' => 3000,
        ]);

        // Both above threshold, equal earnings
        // Withdraw 100k -> each portion 50k
        // barang fee = 10% * 50k = 5k
        // jasa fee = 5% * 50k = 2.5k
        $result = $umkm->calculateWithdrawalDeductions(100000, 200000, 200000);

        $this->assertEquals(7500.0, $result['platform_fee_deduction']);
        $this->assertEquals(6500.0, $result['doku_admin_fee']);
        $this->assertEquals(86000.0, $result['net_disbursed']);
    }
}
