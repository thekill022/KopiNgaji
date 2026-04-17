<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('buyer_completed_at')->nullable()->after('is_scanned');
            $table->timestamp('seller_completion_notified_at')->nullable()->after('buyer_completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['buyer_completed_at', 'seller_completion_notified_at']);
        });
    }
};
