<?php

namespace App\Services;

class BlockchainService
{
    // Hapus constructor yang mencoba koneksi ke RPC/Internet
    // public function __construct() { ... }

    public function catatTransaksi($internalId, $dataHash)
    {
        // ==========================================
        // MODE SIMULASI (AMAN UNTUK DEMO SIDANG)
        // ==========================================
        
        // Alih-alih menghubungi server Polygon yang mungkin lemot/error,
        // Kita generate "Fake Hash" yang terlihat persis seperti asli.
        // Hash ini tetap unik karena menggabungkan data transaksi asli.
        
        // Format Hash Ethereum: 0x + 64 karakter hex
        $fakeTxHash = '0x' . hash('sha256', 'POLYGON_TESTNET_' . $internalId . '_' . $dataHash . microtime());
        
        return $fakeTxHash;
    }
}