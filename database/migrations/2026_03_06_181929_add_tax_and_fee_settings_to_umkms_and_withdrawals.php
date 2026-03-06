<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add tax + admin fee config to umkms
        Schema::table('umkms', function (Blueprint $table) {
            // Pajak: berlaku hanya jika total keuntungan kumulatif melampaui threshold ini (Rp)
            // 0 = tidak ada pajak
            $table->decimal('tax_threshold', 15, 2)->default(0)->after('platform_fee_flat')
                ->comment('Batas keuntungan kumulatif sebelum pajak berlaku (0 = tidak ada pajak)');
            // Rate pajak dalam persen, misal 5 = 5%
            $table->decimal('tax_rate', 5, 2)->default(0)->after('tax_threshold')
                ->comment('Tarif pajak dalam persen jika threshold terlampaui');
            // Biaya admin penarikan yang ditanggung UMKM (flat Rp)
            $table->decimal('withdrawal_admin_fee', 12, 2)->default(0)->after('tax_rate')
                ->comment('Biaya admin per penarikan yang ditanggung UMKM');
        });

        // Add breakdown columns to withdrawals
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->decimal('gross_amount', 15, 2)->default(0)->after('amount')
                ->comment('Jumlah bruto yang diminta UMKM sebelum potongan');
            $table->decimal('tax_amount', 12, 2)->default(0)->after('gross_amount')
                ->comment('Potongan pajak (jika threshold terlampaui)');
            $table->decimal('admin_fee_amount', 12, 2)->default(0)->after('tax_amount')
                ->comment('Biaya admin penarikan yang ditanggung UMKM');
            $table->decimal('net_disbursed', 15, 2)->default(0)->after('admin_fee_amount')
                ->comment('Jumlah bersih yang benar-benar dikirim ke rekening UMKM');
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['tax_threshold', 'tax_rate', 'withdrawal_admin_fee']);
        });
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn(['gross_amount', 'tax_amount', 'admin_fee_amount', 'net_disbursed']);
        });
    }
};
