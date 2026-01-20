<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar transaksi.
     */
    public function index(Request $request)
    {
        $range = $request->query('range', 'daily');
        $reqStartDate = $request->query('start_date');
        $reqEndDate = $request->query('end_date');

        if ($range !== 'custom') {
            $reqStartDate = null;
            $reqEndDate = null;
        }

        $filterLabel = "Hari Ini";
        $query = Transaksi::query();

        if ($range == 'custom' && $reqStartDate && $reqEndDate) {
            $startDate = Carbon::parse($reqStartDate)->startOfDay();
            $endDate = Carbon::parse($reqEndDate)->endOfDay();
            $filterLabel = "Periode " . $startDate->format('d M Y') . " - " . $endDate->format('d M Y');
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        } else {
            if ($range == 'weekly') {
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                $filterLabel = "Minggu Ini";
            } elseif ($range == 'monthly') {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $filterLabel = "Bulan Ini";
            } else {
                $startDate = Carbon::now()->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                $filterLabel = "Hari Ini";
            }
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        $totalQuery = clone $query;
        $totalPendapatan = $totalQuery->sum('total_bayar');

        $transaksis = $query->with('pesanan.user')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.transaksi.index', compact('transaksis', 'totalPendapatan', 'filterLabel'));
    }

    /**
     * Verifikasi dengan Format Snapshot Lengkap & Integrasi Blockchain Asli
     */
    public function verifikasi(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|string|in:Tunai di Tempat,QRIS,Transfer Bank,Transfer Bank (BCA)'
        ]);

        if ($pesanan->transaksi) {
            return redirect()->route('admin.pesanan.show', $pesanan)->with('error', 'Pesanan ini sudah dibayar.');
        }

        try {
            DB::beginTransaction();

            // 1. Simpan Transaksi ke MySQL
            $transaksi = Transaksi::create([
                'pesanan_id' => $pesanan->id,
                'total_bayar' => $pesanan->total_bayar,
                'status_pembayaran' => 'paid',
                'metode_pembayaran' => $request->metode_pembayaran,
                'tanggal_transaksi' => now(),
            ]);

            // ==========================================================
            // LOGIKA BLOCKCHAIN & SNAPSHOT FORENSIK (REAL IMPLEMENTATION)
            // ==========================================================
            
            // Format Data Snapshot: "ID|TOTAL|WAKTU|STATUS|METODE"
            $rawData =  $pesanan->id . '|' . 
                        $pesanan->total_bayar . '|' . 
                        $transaksi->created_at->format('Y-m-d H:i:s') . '|' .
                        'paid' . '|' . 
                        $request->metode_pembayaran;
            
            // Hash data tersebut
            $dataHash = hash('sha256', $rawData);

            // ---------------------------------------------------------
            // MEMANGGIL NODE.JS BRIDGE
            // ---------------------------------------------------------
            // Kita panggil script bridge.js via terminal
            
            $nodePath = 'node'; // Pastikan 'node' sudah ada di Environment Variable Windows
            $scriptPath = base_path('blockchain/bridge.js'); // Lokasi script di folder blockchain
            $trxIdBlockchain = "TRX-" . $transaksi->id;

            // Perintah Terminal: node blockchain/bridge.js store "TRX-1" "hash..."
            // escapeshellarg digunakan agar aman dari karakter aneh
            $command = "$nodePath \"$scriptPath\" store " . escapeshellarg($trxIdBlockchain) . " " . escapeshellarg($dataHash);

            $output = [];
            $returnCode = 0;
            
            // Eksekusi Perintah
            exec($command . " 2>&1", $output, $returnCode);

            // Parsing Output untuk mencari "TX_HASH"
            $txHashBlockchain = null;
            foreach ($output as $line) {
                if (str_contains($line, 'TX_HASH:')) {
                    $txHashBlockchain = trim(str_replace('TX_HASH:', '', $line));
                    break;
                }
            }

            // Cek Error: Jika return code bukan 0 atau tidak dapat hash
            if ($returnCode !== 0 || !$txHashBlockchain) {
                // Konversi array output ke string untuk log error
                $errorMessage = implode("\n", $output);
                throw new \Exception("Gagal mencatat ke Blockchain! Detail Error: " . $errorMessage);
            }

            // ---------------------------------------------------------
            // Update Database: Simpan Hash DAN Snapshot Asli DAN TX Hash
            $transaksi->update([
                'data_hash' => $dataHash,
                'tx_hash_blockchain' => $txHashBlockchain, // <--- INI BENAR (Sesuai phpMyAdmin)
                'snapshot_data' => $rawData 
            ]);

            $pesanan->update(['status' => 'processing']);

            DB::commit();
            
            $shortHash = substr($txHashBlockchain, 0, 10) . '...';
            return redirect()->route('admin.pesanan.show', $pesanan)
                ->with('success', 'Pembayaran diverifikasi & Data Tercatat Permanen di Blockchain! (TX: ' . $shortHash . ')');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal Verifikasi: " . $e->getMessage());
            return redirect()->route('admin.pesanan.show', $pesanan)->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Cek Integritas dengan Deteksi Per Kolom
     */
    public function cekIntegritas($id)
    {
        $transaksi = Transaksi::with('pesanan')->findOrFail($id);

        // 1. Rekonstruksi String dari Data Database SAAT INI
        $rawDataNow =   $transaksi->pesanan_id . '|' . 
                        $transaksi->total_bayar . '|' . 
                        $transaksi->created_at->format('Y-m-d H:i:s') . '|' .
                        $transaksi->status_pembayaran . '|' .
                        $transaksi->metode_pembayaran;

        $recalculatedHash = hash('sha256', $rawDataNow);

        $status = 'AMAN';
        $pesan = 'Data Valid. Hash database cocok dengan catatan asli.';
        $alertColor = 'success';
        
        $perubahan = []; // Array untuk menyimpan daftar kolom yang diubah
        $snapshotValid = true;

        // 2. Bandingkan Hash Baru vs Hash Lama
        if ($recalculatedHash !== $transaksi->data_hash) {
            $status = 'BAHAYA';
            $alertColor = 'danger';
            $pesan = 'PERINGATAN! Data transaksi telah dimanipulasi!';
            
            if ($transaksi->snapshot_data) {
                // Cek Validitas Snapshot Dulu (Apakah snapshot juga diedit?)
                $snapshotHash = hash('sha256', $transaksi->snapshot_data);
                
                if ($snapshotHash !== $transaksi->data_hash) {
                    $pesan = 'KRITIS! Data Database DAN Snapshot telah dimanipulasi secara paksa!';
                    $snapshotValid = false;
                } else {
                    // JIKA SNAPSHOT ASLI, MULAI INVESTIGASI PER KOLOM
                    $parts = explode('|', $transaksi->snapshot_data);
                    
                    // Pastikan format snapshot sesuai (ada 5 bagian)
                    if(count($parts) >= 5) {
                        
                        // Cek 1: Total Bayar
                        if ($parts[1] != $transaksi->total_bayar) {
                            $perubahan[] = [
                                'kolom' => 'Total Bayar',
                                'asli'  => 'Rp ' . number_format($parts[1], 0, ',', '.'),
                                'palsu' => 'Rp ' . number_format($transaksi->total_bayar, 0, ',', '.')
                            ];
                        }

                        // Cek 2: Waktu
                        if ($parts[2] != $transaksi->created_at->format('Y-m-d H:i:s')) {
                            $perubahan[] = [
                                'kolom' => 'Waktu Transaksi',
                                'asli'  => $parts[2],
                                'palsu' => $transaksi->created_at->format('Y-m-d H:i:s')
                            ];
                        }

                        // Cek 3: Status
                        if ($parts[3] != $transaksi->status_pembayaran) {
                            $perubahan[] = [
                                'kolom' => 'Status Pembayaran',
                                'asli'  => ucfirst($parts[3]),
                                'palsu' => ucfirst($transaksi->status_pembayaran)
                            ];
                        }

                        // Cek 4: Metode Pembayaran
                        if ($parts[4] != $transaksi->metode_pembayaran) {
                            $perubahan[] = [
                                'kolom' => 'Metode Pembayaran',
                                'asli'  => $parts[4],
                                'palsu' => $transaksi->metode_pembayaran
                            ];
                        }
                    }
                }
            } else {
                $pesan = 'PERINGATAN! Data berubah dan tidak ada Snapshot cadangan.';
            }
        }

        return view('admin.transaksi.audit', compact(
            'transaksi', 'status', 'pesan', 'alertColor', 'recalculatedHash', 'perubahan', 'snapshotValid'
        ));
    }

    /**
     * FITUR BARU: Memulihkan Data (Restore) berdasarkan Snapshot
     */
    public function restoreData($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // 1. Cek Ketersediaan Snapshot
        if (!$transaksi->snapshot_data) {
            return back()->with('error', 'Tidak ada data snapshot untuk dipulihkan.');
        }

        // 2. Security Check: Pastikan Snapshot belum dimanipulasi
        $snapshotHash = hash('sha256', $transaksi->snapshot_data);
        if ($snapshotHash !== $transaksi->data_hash) {
            return back()->with('error', 'GAGAL! Snapshot Forensik juga telah rusak/dimanipulasi. Pemulihan otomatis dibatalkan demi keamanan.');
        }

        // 3. Lakukan Restore Data
        $parts = explode('|', $transaksi->snapshot_data);

        if (count($parts) >= 5) {
            $transaksi->update([
                'total_bayar'       => $parts[1],
                'created_at'        => $parts[2],
                'status_pembayaran' => $parts[3],
                'metode_pembayaran' => $parts[4],
            ]);
            
            return back()->with('success', 'Data berhasil dipulihkan ke kondisi asli (Terverifikasi Blockchain).');
        }

        return back()->with('error', 'Format snapshot tidak valid.');
    }

    public function cetakLaporan(Request $request)
    {
        $range = $request->query('range', 'daily');
        $reqStartDate = $request->query('start_date');
        $reqEndDate = $request->query('end_date');

        if ($range !== 'custom') {
            $reqStartDate = null;
            $reqEndDate = null;
        }

        $filterLabel = "Hari Ini";
        $startDateObj = null;
        $endDateObj = null;

        $query = Transaksi::query();

        if ($range == 'custom' && $reqStartDate && $reqEndDate) {
            $startDateObj = Carbon::parse($reqStartDate)->startOfDay();
            $endDateObj = Carbon::parse($reqEndDate)->endOfDay();
            $filterLabel = "Periode " . $startDateObj->format('d M Y') . " - " . $endDateObj->format('d M Y');
            $query->whereBetween('tanggal_transaksi', [$startDateObj, $endDateObj]);
        } else {
            if ($range == 'weekly') {
                $startDateObj = Carbon::now()->startOfWeek();
                $endDateObj = Carbon::now()->endOfWeek();
                $filterLabel = "Minggu Ini";
            } elseif ($range == 'monthly') {
                $startDateObj = Carbon::now()->startOfMonth();
                $endDateObj = Carbon::now()->endOfMonth();
                $filterLabel = "Bulan Ini";
            } else {
                $startDateObj = Carbon::now()->startOfDay();
                $endDateObj = Carbon::now()->endOfDay();
                $filterLabel = "Hari Ini";
            }
            $query->whereBetween('tanggal_transaksi', [$startDateObj, $endDateObj]);
        }

        $totalQuery = clone $query;
        $totalPendapatan = $totalQuery->sum('total_bayar');

        $transaksis = $query->with('pesanan.user')
            ->latest()
            ->get();

        return view('admin.transaksi.cetak', [
            'transaksis' => $transaksis,
            'totalPendapatan' => $totalPendapatan,
            'filterLabel' => $filterLabel,
            'startDate' => $startDateObj,
            'endDate' => $endDateObj
        ]);
    }
    /**
     * Fitur Global Audit: Membandingkan Jumlah Data
     */
    public function globalAudit()
    {
        // 1. Hitung Jumlah di Database MySQL
        $countMySQL = Transaksi::count();

        // 2. Hitung Jumlah di Blockchain (Panggil Bridge)
        $nodePath = 'node'; 
        $scriptPath = base_path('blockchain/bridge.js');
        
        // Perintah: node bridge.js count
        $command = "$nodePath \"$scriptPath\" count";
        $output = [];
        $returnCode = 0;
        exec($command . " 2>&1", $output, $returnCode);

        $countBlockchain = 0;
        foreach ($output as $line) {
            if (str_contains($line, 'TOTAL_BLOCKCHAIN:')) {
                $countBlockchain = (int) trim(str_replace('TOTAL_BLOCKCHAIN:', '', $line));
                break;
            }
        }

        // 3. Bandingkan
        $status = 'AMAN';
        $message = "Integritas Terjaga. Jumlah data konsisten ($countMySQL Data).";
        $color = 'success';

        if ($countMySQL !== $countBlockchain) {
            $status = 'BAHAYA';
            $selisih = $countBlockchain - $countMySQL;
            $message = "PERINGATAN KRITIS! Terdeteksi $selisih data telah DIHAPUS PAKSA dari Database! (Blockchain: $countBlockchain vs Database: $countMySQL)";
            $color = 'danger';
        }

        return redirect()->route('admin.transaksi.index')->with($color, $message);
    }
}