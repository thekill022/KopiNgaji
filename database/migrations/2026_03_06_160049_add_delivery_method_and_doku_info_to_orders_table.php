<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('delivery_method', ['AMBIL_LOKASI', 'KIRIM_ALAMAT'])->default('AMBIL_LOKASI')->after('payment_method');
            $table->text('shipping_address')->nullable()->after('delivery_method');
            $table->string('doku_invoice_id')->nullable()->after('qr_code');
            $table->string('doku_payment_url')->nullable()->after('doku_invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_method', 'shipping_address', 'doku_invoice_id', 'doku_payment_url']);
        });
    }
};
