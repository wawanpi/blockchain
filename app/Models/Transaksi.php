<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Satu Transaksi dimiliki oleh satu Pesanan
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }
}