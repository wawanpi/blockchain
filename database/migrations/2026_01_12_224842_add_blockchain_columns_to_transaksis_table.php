<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hash dari data asli (untuk verifikasi lokal)
            $table->string('data_hash')->nullable()->after('status_pembayaran');
            // Bukti tanda terima dari Blockchain (Transaction Hash)
            $table->string('tx_hash_blockchain')->nullable()->after('data_hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['data_hash', 'tx_hash_blockchain']);
        });
    }
};
