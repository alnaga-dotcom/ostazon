<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'tutor_id',
        'subject_id',
        'title',
        'description',
        'file_url',
        'thumbnail_url',
        'content_type',
        'price_coins',
        'download_count',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price_coins' => 'integer',
        'download_count' => 'integer',
    ];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function purchases()
    {
        return $this->hasMany(ContentPurchase::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
