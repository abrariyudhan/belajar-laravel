<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Properti ini wajib ada agar data bisa disimpan lewat form
    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'category',
        'description',
        'date',
    ];

    // Relasi: Transaksi ini milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}