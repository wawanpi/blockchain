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
        Schema::create('menus', function (Blueprint $table) {
            $table->id(); // Ini akan menjadi 'idMenu' (primary key, auto-increment)
            $table->string('namaMenu');
            $table->decimal('harga', 10, 2); // 10 digit total, 2 di belakang koma
            $table->text('deskripsi')->nullable(); // Deskripsi boleh kosong
            $table->integer('stok')->default(0);
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};