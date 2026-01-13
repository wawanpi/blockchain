<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute; 
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'namaMenu',
        'harga',
        'deskripsi',
        'kategori',
        // REVISI: Menggunakan KAPASITAS (lebih simpel dari patokan_harian)
        'kapasitas', 
        'gambar',
        'bukti_bayar',
    ];

    // --- Relasi yang sudah Anda miliki (Tidak Berubah) ---
    public function pesananDetails(): HasMany
    {
        return $this->hasMany(PesananDetail::class, 'menu_id');
    }
    
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // === RELASI KETERSEDIAAN BARU ===

    /**
     * Relasi ke ketersediaan hari ini (DailyKetersediaan).
     * Memuat data ketersediaan harian untuk menu ini.
     */
    public function ketersediaanHariIni()
    {
        return $this->hasOne(DailyKetersediaan::class)
                    ->whereDate('tanggal', today());
    }

    /**
     * Computed Attribute: Mengambil kuantitas menu yang tersisa hari ini.
     * Akses menggunakan $menu->jumlah_saat_ini
     * (Menggantikan sisa_hari_ini untuk menghindari konotasi 'sisa/stok')
     */
    protected function jumlahSaatIni(): Attribute
    {
        // PERBAIKAN: Mengakses kolom 'jumlah_saat_ini' dari relasi DailyKetersediaan
        // Catatan: Anda HARUS memastikan nama kolom di DB di tabel daily_ketersediaan adalah 'jumlah_saat_ini'
        return Attribute::make(
            get: fn () => $this->ketersediaanHariIni?->jumlah_saat_ini ?? 0
        );
    }
    
    // === FUNGSI RATING YANG SUDAH ADA (Tidak Berubah) ===
    protected function averageRating(): Attribute
    {
        return Attribute::make(
            get: fn () => round($this->reviews->avg('rating'), 1)
        );
    }

    protected function ratingsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reviews->count()
        );
    }
}