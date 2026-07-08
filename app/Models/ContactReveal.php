<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactReveal extends Model
{
    protected $fillable = [
        'student_id',
        'tutor_id',
        'coins_spent',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}
