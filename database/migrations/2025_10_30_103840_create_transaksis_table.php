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
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
        $table->decimal('total_bayar', 10, 2);
        $table->string('metode_pembayaran')->default('Tunai di Tempat'); // Sesuai alur "Ambil di Tempat"
        $table->string('status_pembayaran')->default('paid'); // Langsung 'paid' saat diverifikasi
        $table->timestamp('tanggal_transaksi');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
