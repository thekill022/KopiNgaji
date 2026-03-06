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
            if (!Schema::hasColumn('orders', 'subtotal_amount')) {
                $table->decimal('subtotal_amount', 12, 2)->default(0)->after('total_price');
            }
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 12, 2)->default(0)->after('subtotal_amount');
            }
            if (!Schema::hasColumn('orders', 'platform_fee_amount')) {
                $table->decimal('platform_fee_amount', 12, 2)->default(0)->after('discount_amount');
            }
            if (!Schema::hasColumn('orders', 'net_amount')) {
                $table->decimal('net_amount', 12, 2)->default(0)->after('platform_fee_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal_amount', 'discount_amount', 'platform_fee_amount', 'net_amount']);
        });
    }
};
