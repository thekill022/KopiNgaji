<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Meluruskan struktur fee penarikan:
 *
 * UMKM:
 *   - Hapus `tax_rate`           → tidak ada tarif pajak tersendiri; platform fee (% atau flat) ADALAH "pajaknya"
 *   - Hapus `withdrawal_admin_fee` per UMKM → biaya admin penarikan = biaya DOKU (global dari ENV/config)
 *   - Pertahankan `tax_threshold` → batas keuntungan kumulatif sebelum platform fee mulai berlaku
 *
 * WITHDRAWALS:
 *   - Hapus `tax_amount`          → diganti dengan `platform_fee_deduction`
 *   - Pertahankan `gross_amount`  → jumlah yang diminta
 *   - Pertahankan `admin_fee_amount` → biaya transfer DOKU (global)
 *   - Pertahankan `net_disbursed` → yang dikirim ke rekening
 *   - Tambah `platform_fee_deduction` → potongan komisi platform jika threshold terlampaui
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['tax_rate', 'withdrawal_admin_fee']);
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn(['tax_amount']);
            $table->decimal('platform_fee_deduction', 12, 2)->default(0)->after('gross_amount')
                ->comment('Potongan komisi platform jika kumulatif melampaui threshold');
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->decimal('tax_rate', 5, 2)->default(0)->after('tax_threshold');
            $table->decimal('withdrawal_admin_fee', 12, 2)->default(0)->after('tax_rate');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn(['platform_fee_deduction']);
            $table->decimal('tax_amount', 12, 2)->default(0)->after('gross_amount');
        });
    }
};
