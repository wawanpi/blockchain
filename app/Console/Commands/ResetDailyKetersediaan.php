<?php

namespace App\Console\Commands;

use App\Models\Menu;
use App\Models\DailyKetersediaan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ResetDailyKetersediaan extends Command
{
    protected $signature = 'ketersediaan:reset';
    protected $description = 'Me-reset jumlah harian (jumlah_saat_ini) kembali ke nilai kapasitas.';

    public function handle()
    {
        $today = Carbon::today();
        $menus = Menu::all();
        $count = 0;

        $this->info("Memulai proses reset ketersediaan untuk tanggal: " . $today->toDateString());

        // 1. Loop melalui semua menu
        foreach ($menus as $menu) {
            
            // Hanya reset menu yang memiliki kapasitas
            if ($menu->kapasitas > 0) {
                
                // 2. PERBAIKAN LOGIKA:
                // Cari data harian berdasarkan menu_id dan tanggal HARI INI.
                // Jika ADA, update jumlah_saat_ini kembali ke kapasitas.
                // Jika TIDAK ADA, buat data baru.
                DailyKetersediaan::updateOrCreate(
                    [
                        'menu_id' => $menu->id,
                        'tanggal' => $today
                    ],
                    [
                        'jumlah_awal_hari' => $menu->kapasitas,
                        'jumlah_saat_ini' => $menu->kapasitas, // INI ADALAH LOGIKA RESETNYA
                        'updated_at' => now()
                    ]
                );
                $count++;
            }
        }

        if ($count > 0) {
            $this->info("✅ Berhasil: " . $count . " menu telah di-reset jumlah hariannya.");
        } else {
            $this->comment('ℹ️ Tidak ada menu yang memiliki kapasitas untuk di-reset.');
        }

        return 0;
    }
}