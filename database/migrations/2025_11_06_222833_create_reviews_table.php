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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap review

            // 1. Siapa yang memberi ulasan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // 2. Terhubung ke pesanan mana
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            
            // 3. Menu apa yang diulas
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');

            // 4. Rating (bintang 1-5)
            $table->unsignedTinyInteger('rating'); // Angka kecil 1-5

            // 5. Komentar (boleh kosong, jika user hanya memberi bintang)
            $table->text('komentar')->nullable();
            
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};