<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'icon',
        'is_active',
    ];

    public function tutors()
    {
        return $this->belongsToMany(TutorProfile::class, 'tutor_subjects')
            ->withPivot('hourly_rate', 'is_primary')
            ->withTimestamps();
    }
}
