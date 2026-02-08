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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('umkm_id')->constrained('umkms')->cascadeOnDelete();
            $table->enum('status', ['PENDING', 'PAID', 'CANCELLED', 'COMPLETED'])->default('PENDING');
            $table->enum('payment_method', ['CASH', 'NON_CASH'])->default('CASH');
            $table->float('total_price')->default(0);
            $table->string('whatsapp')->nullable();
            $table->string('qr_code')->nullable();
            $table->boolean('is_scanned')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
