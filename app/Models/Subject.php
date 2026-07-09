<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
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

    public function searchTerms()
    {
        return $this->hasMany(\App\Models\SubjectSearchTerm::class);
    }

    public function getLocalizedNameAttribute()
    {
        if (app()->getLocale() == 'ar' && $this->name_ar) {
            return $this->name_ar;
        }
        return $this->name;
    }
}
