<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentPurchase extends Model
{
    protected $fillable = [
        'content_id',
        'student_id',
        'coins_spent',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
