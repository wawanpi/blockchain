<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\DailyKetersediaan;
use App\Models\PesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan data statistik untuk dashboard admin.
     * FITUR TAMBAHAN: Auto-Generate Daily Stock jika belum ada.
     */
    public function index()
    {
        $today = Carbon::today();

        // =========================================================================
        // 0. AUTO-GENERATE DAILY STOCK LOGIC
        // =========================================================================
        
        // Cek apakah data daily_ketersediaan untuk hari ini sudah ada?
        $cekDataHariIni = DailyKetersediaan::whereDate('tanggal', $today)->exists();

        // Jika BELUM ADA (false), maka generate data baru
        if (!$cekDataHariIni) {
            $allMenus = Menu::all();

            // Kita gunakan DB Transaction agar proses insert aman (atomik)
            DB::transaction(function () use ($allMenus, $today) {
                foreach ($allMenus as $menu) {
                    DailyKetersediaan::create([
                        'menu_id'          => $menu->id,
                        'tanggal'          => $today,
                        // Reset stok sesuai kapasitas master menu
                        'jumlah_awal_hari' => $menu->kapasitas, 
                        'jumlah_saat_ini'  => $menu->kapasitas,
                    ]);
                }
            });
        }
        
        // =========================================================================
        // MULAI QUERY STATISTIK (Kode Lama)
        // =========================================================================

        // 1. Total Pendapatan HARI INI
        $totalPendapatan = Transaksi::whereDate('tanggal_transaksi', $today)->sum('total_bayar');

        // 2. Jumlah Pesanan Baru HARI INI
        $jumlahPesananBaru = Pesanan::where('status', 'pending')
                                    ->whereDate('created_at', $today)
                                    ->count();
        
        // 3. Total Unit Terjual HARI INI
        $totalUnitTerjual = PesananDetail::whereHas('pesanan', function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                      ->where('status', '!=', 'cancelled');
            })->sum('jumlah');

        // 4. Pengguna Baru HARI INI
        $jumlahPenggunaBaru = User::whereDoesntHave('roles', function ($query) {
                                        $query->where('name', 'admin');
                                    })
                                    ->whereDate('created_at', $today)
                                    ->count();

        // 5. Grafik & Stok Menipis (Data diambil setelah auto-generate di atas selesai)
        $menuHampirHabis = DailyKetersediaan::whereDate('tanggal', $today)
                                ->where('jumlah_saat_ini', '<=', 10)
                                ->where('jumlah_saat_ini', '>', 0)
                                ->with('menu')
                                ->orderBy('jumlah_saat_ini', 'asc')
                                ->take(5)
                                ->get();

        // Kirim semua data HARI INI ke view
        return view('admin.dashboard', [
            'totalPendapatan'    => $totalPendapatan,
            'jumlahPesananBaru'  => $jumlahPesananBaru,
            'totalUnitTerjual'   => $totalUnitTerjual,
            'jumlahPenggunaBaru' => $jumlahPenggunaBaru,
            'menuHampirHabis'    => $menuHampirHabis,
        ]);
    }
}