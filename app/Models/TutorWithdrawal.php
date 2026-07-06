<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorWithdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'amount',
        'withdrawal_method',
        'account_details',
        'status',
        'processed_by',
        'processed_at',
        'admin_notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
