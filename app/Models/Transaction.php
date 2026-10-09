<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'wallet_id',
        'type',
        'amount',
        'transaction_date',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function scopePeriod($query, ?int $tahun, ?int $bulan)
    {
        if ($tahun) {
            $query->whereYear('transaction_date', $tahun);
        }

        if ($bulan) {
            $query->whereMonth('transaction_date', $bulan);
        }

        return $query;
    }
}
