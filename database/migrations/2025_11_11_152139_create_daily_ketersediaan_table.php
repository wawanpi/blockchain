<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_ketersediaan', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke tabel menus, onDelete cascade
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade'); 
            $table->date('tanggal')->default(now()->toDateString());
            $table->integer('jumlah_awal_hari'); // Dari menus.jumlah_default
            $table->integer('jumlah_saat_ini');  // Sisa riil (akan dikurangi pemesanan)
            
            // Pastikan setiap menu hanya memiliki satu entri per hari
            $table->unique(['menu_id', 'tanggal']); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_ketersediaan');
    }
};