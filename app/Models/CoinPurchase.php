<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coins_requested',
        'amount_egp',
        'payment_method',
        'transaction_reference',
        'screenshot_url',
        'status',
        'verified_by',
        'verified_at',
        'admin_notes',
    ];

    protected $casts = [
        'coins_requested' => 'integer',
        'amount_egp' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
