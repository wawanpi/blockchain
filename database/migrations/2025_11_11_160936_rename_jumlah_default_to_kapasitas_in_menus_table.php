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
        Schema::table('menus', function (Blueprint $table) {
            // Perintah untuk mengganti nama kolom
            $table->renameColumn('jumlah_default', 'kapasitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Logika jika Anda ingin rollback (mengembalikan)
            $table->renameColumn('kapasitas', 'jumlah_default');
        });
    }
};