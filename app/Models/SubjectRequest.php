<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectRequest extends Model
{
    protected $fillable = [
        'user_id',
        'subject_name',
        'message',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
