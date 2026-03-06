<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom untuk kebutuhan DOKU Disbursement API:
 * - bank_code  : kode bank/e-wallet sesuai standar DOKU (misal "014" untuk BCA, "GOPAY" untuk GoPay)
 * - account_name: nama pemilik rekening (wajib di API DOKU untuk validasi)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->string('bank_code', 20)->nullable()->after('bank_name')
                ->comment('Kode bank/ewallet DOKU: 014=BCA, 009=BNI, dll');
            $table->string('account_name', 255)->nullable()->after('bank_code')
                ->comment('Nama pemilik rekening (sesuai buku tabungan)');
            $table->string('doku_reference_no', 100)->nullable()->after('net_disbursed')
                ->comment('Referensi nomor dari DOKU setelah disbursement');
        });
    }

    public function down(): void
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn(['bank_code', 'account_name', 'doku_reference_no']);
        });
    }
};
