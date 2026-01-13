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
        Schema::table('pesanans', function (Blueprint $table) {
            // Tambahkan kolom ini
            $table->integer('jumlah_tamu')->default(1)->after('tipe_layanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Untuk menghapus kolom jika migrasi dibatalkan
            $table->dropColumn('jumlah_tamu');
        });
    }
};
