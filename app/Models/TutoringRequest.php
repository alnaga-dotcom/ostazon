<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutoringRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'title',
        'description',
        'budget_egp',
        'lesson_mode',
        'preferred_schedule',
        'status',
    ];

    protected $casts = [
        'budget_egp' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function proposals()
    {
        return $this->hasMany(TutorProposal::class, 'request_id');
    }
}
