<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyKetersediaan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * Kita menggunakan snake_case default Laravel: daily_ketersediaan
     * @var string
     */
    protected $table = 'daily_ketersediaan';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * @var array<int, string>
     */
    protected $fillable = [
        'menu_id',
        'tanggal',
        'jumlah_awal_hari',
        'jumlah_saat_ini',
    ];

    /**
     * Casting atribut ke tipe data tertentu.
     * Pastikan 'tanggal' di-cast ke tipe 'date'.
     * @var array
     */
    protected $casts = [
        'tanggal' => 'date',
        'jumlah_awal_hari' => 'integer',
        'jumlah_saat_ini' => 'integer',
    ];

    /**
     * Mendefinisikan relasi: Setiap catatan ketersediaan dimiliki oleh satu Menu.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}