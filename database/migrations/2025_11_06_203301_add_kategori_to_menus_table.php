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
            // Tambahkan kolom 'kategori' setelah 'deskripsi'
            // Kita buat 'nullable' agar aman jika ada data lama
            $table->string('kategori')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Ini untuk 'rollback', yaitu menghapus kolomnya
            $table->dropColumn('kategori');
        });
    }
};