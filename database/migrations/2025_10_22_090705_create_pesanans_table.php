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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            // Foreign Key untuk menghubungkan dengan user yang memesan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Total harga dari semua item dalam pesanan ini
            $table->decimal('total_bayar', 10, 2); // 10 digit total, 2 di belakang koma (misal: 99,999,999.99)
            
            // Status pesanan saat ini
            $table->string('status')->default('pending'); // Contoh status: pending, processing, completed, cancelled
            
            // Kolom opsional untuk catatan dari pelanggan
            $table->text('catatan_pelanggan')->nullable();
            
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
