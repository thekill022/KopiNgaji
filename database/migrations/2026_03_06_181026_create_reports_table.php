<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('umkm_id')->nullable()->constrained('umkms')->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->enum('category', [
                'PRODUK_ILEGAL',
                'PRODUK_BERBAHAYA',
                'PENIPUAN',
                'KONTEN_TIDAK_PANTAS',
                'SPAM',
                'LAINNYA',
            ]);
            $table->text('description');
            $table->enum('status', ['PENDING', 'REVIEWED', 'DISMISSED'])->default('PENDING');
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
