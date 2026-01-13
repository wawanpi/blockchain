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
            // Ini akan menambahkan kolom 'tipe_layanan' setelah kolom 'status'
            // Default-nya adalah 'Take Away' sesuai alur di PDF Anda
            $table->string('tipe_layanan')->default('Take Away')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Ini adalah perintah untuk 'undo' jika diperlukan
            $table->dropColumn('tipe_layanan');
        });
    }
};