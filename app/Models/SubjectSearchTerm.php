<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectSearchTerm extends Model
{
    protected $fillable = ['subject_id', 'term'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
