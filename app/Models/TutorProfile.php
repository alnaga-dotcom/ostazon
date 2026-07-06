<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'hourly_rate',
        'lesson_mode',
        'country',
        'city',
        'video_intro_url',
        'id_document_url',
        'certificate_url',
        'verification_status',
        'total_lessons',
        'total_earnings',
        'available_balance',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'available_balance' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'tutor_subjects')
            ->withPivot('hourly_rate', 'is_primary')
            ->withTimestamps();
    }
}
