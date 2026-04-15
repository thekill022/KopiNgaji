<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->enum('platform_fee_type_jasa', ['percentage', 'flat'])->default('percentage')->after('platform_fee_flat');
            $table->decimal('platform_fee_rate_jasa', 5, 2)->default(0)->after('platform_fee_type_jasa');
            $table->decimal('platform_fee_flat_jasa', 12, 2)->default(0)->after('platform_fee_rate_jasa');
            $table->decimal('tax_threshold_jasa', 12, 2)->default(0)->after('platform_fee_flat_jasa');
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['platform_fee_type_jasa', 'platform_fee_rate_jasa', 'platform_fee_flat_jasa', 'tax_threshold_jasa']);
        });
    }
};
