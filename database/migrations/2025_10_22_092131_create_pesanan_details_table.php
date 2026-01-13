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
        Schema::create('pesanan_details', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key untuk menghubungkan dengan tabel pesanan utama
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            
            // Foreign Key untuk menghubungkan dengan menu yang dipesan
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            
            // Jumlah item menu yang dipesan
            $table->integer('jumlah');
            
            // Harga menu per item pada saat pesanan dibuat
            $table->decimal('harga_satuan', 10, 2);
            
            // Total harga untuk item ini (jumlah * harga_satuan)
            $table->decimal('subtotal', 10, 2);
            
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_details');
    }
};
