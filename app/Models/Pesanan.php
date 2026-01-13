<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne; 

class Pesanan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id']; // Memperbolehkan semua kolom diisi kecuali 'id'

    /**
     * Mendefinisikan relasi: Satu Pesanan dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi: Satu Pesanan memiliki banyak Detail Pesanan (item menu).
     */
    public function details(): HasMany
    {
        return $this->hasMany(PesananDetail::class);
    }

    /**
     * Mendefinisikan relasi: Satu Pesanan memiliki satu Transaksi.
     */
    public function transaksi(): HasOne
    {
        return $this->hasOne(Transaksi::class);
    }

    /**
     * === METHOD BARU UNTUK REVIEW ===
     * Mendefinisikan relasi: Satu Pesanan memiliki banyak Review.
     * Ini memperbaiki error RelationNotFoundException.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}