<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // <-- TAMBAHKAN INI

// Import Command Class yang sudah Anda buat
use App\Console\Commands\ResetDailyKetersediaan; 

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// --- LOGIKA SCHEDULER UNTUK RESET KETERSEDIAAN HARIAN ---

// Jadwalkan Artisan Command Anda untuk berjalan setiap hari pada pukul 00:00 (tengah malam)
Schedule::command(ResetDailyKetersediaan::class)->dailyAt('00:00');

// ATAU jika Anda lebih suka menggunakan string signature:
// Schedule::command('ketersediaan:reset')->dailyAt('00:00'); 

// --- AKHIR LOGIKA SCHEDULER ---