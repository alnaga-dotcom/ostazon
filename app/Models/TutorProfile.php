<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProfile extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id',
    'badge_level',
    'badge_awarded_at',
    'total_lessons',
    'average_rating',
    'bio',
    'hourly_rate',
    'lesson_mode',
    'country',
    'city',
    'video_intro_url',
    'id_document_url',
    'certificate_url',
    'verification_status',
    'total_earnings',
    'available_balance',
    'is_sponsored',
    'sponsored_until',
    'service_types',
];
    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'available_balance' => 'decimal:2',
        'badge_awarded_at' => 'datetime',
        'is_sponsored' => 'boolean',
        'sponsored_until' => 'datetime',
        'service_types' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'tutor_subjects')
            ->withPivot('hourly_rate', 'is_primary', 'level_id')
            ->withTimestamps();
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'tutor_subjects', 'tutor_profile_id', 'level_id')
            ->withPivot('subject_id')
            ->withTimestamps();
    }
}
