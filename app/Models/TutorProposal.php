<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'tutor_id',
        'proposed_rate',
        'message',
        'status',
    ];

    protected $casts = [
        'proposed_rate' => 'decimal:2',
    ];

    public function request()
    {
        return $this->belongsTo(TutoringRequest::class, 'request_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}
