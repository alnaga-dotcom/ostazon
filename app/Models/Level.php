<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['name', 'name_ar', 'display_order'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'tutor_subjects');
    }

    public function getLocalizedNameAttribute()
    {
        if (app()->getLocale() == 'ar' && $this->name_ar) {
            return $this->name_ar;
        }
        return $this->name;
    }
}
