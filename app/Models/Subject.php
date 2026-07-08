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

    public function getLocalizedNameAttribute()
    {
        $map = [
            'Mathematics' => 'math',
            'Physics' => 'physics',
            'Chemistry' => 'chemistry',
            'Biology' => 'biology',
            'English' => 'english',
            'Arabic' => 'arabic_lang',
            'Programming' => 'programming',
            'History' => 'history',
            'Geography' => 'geography',
            'Economics' => 'economics',
            'French' => 'french',
            'Science' => 'science',
        ];

        $key = isset($map[$this->name]) ? 'messages.' . $map[$this->name] : 'messages.' . strtolower($this->name);
        $trans = __($key);
        if ($trans !== $key) {
            return $trans;
        }
        return $this->name;
    }
}
