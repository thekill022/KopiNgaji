<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_zone_areas', function (Blueprint $table) {
            $table->string('district_id')->nullable()->after('shipping_zone_id');
        });
    }

    public function down(): void
    {
        Schema::table('shipping_zone_areas', function (Blueprint $table) {
            $table->dropColumn('district_id');
        });
    }
};
