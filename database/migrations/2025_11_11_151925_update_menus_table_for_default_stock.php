<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Hapus kolom 'stok' yang lama
            if (Schema::hasColumn('menus', 'stok')) {
                $table->dropColumn('stok'); 
            }
            
            // Tambahkan kolom 'jumlah_default' sebagai nilai patokan harian
            $table->integer('jumlah_default')->default(0)->after('harga');
            
            // Tambahkan kolom 'kategori' jika belum ada (sesuai kebutuhan revisi)
            if (!Schema::hasColumn('menus', 'kategori')) {
                $table->string('kategori')->nullable()->after('namaMenu');
            }
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Logika rollback: Hapus kolom baru dan kembalikan kolom lama (opsional)
            $table->dropColumn('jumlah_default');
            
            // Kembalikan kolom 'stok' (jika Anda ingin rollback penuh)
            $table->integer('stok')->default(0)->after('harga'); 
        });
    }
};
