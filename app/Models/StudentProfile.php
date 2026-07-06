<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coins_balance',
        'total_spent',
        'total_lessons',
        'grade_level',
        'preferred_language',
    ];

    protected $casts = [
        'coins_balance' => 'integer',
        'total_spent' => 'decimal:2',
        'total_lessons' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
