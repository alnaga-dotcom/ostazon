<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'student_id',
        'tutor_id',
        'rating',
        'comment',
        'is_public',
        'is_verified_booking',
        'tutor_reply',
        'helpful_count',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_public' => 'boolean',
        'is_verified_booking' => 'boolean',
        'helpful_count' => 'integer',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    /**
     * Calculate weight for this review
     */
    public function getWeightAttribute(): float
    {
        $weight = 1.0;

        // Verified booking = 1.0x (default)
        if (!$this->is_verified_booking) {
            $weight *= 0.3;
        }

        // Has comment = 1.2x
        if (!empty($this->comment)) {
            $weight *= 1.2;
        }

        // Repeat student = 1.3x (check if student has multiple bookings with this tutor)
        $repeatBookings = Booking::where('student_id', $this->student_id)
            ->where('tutor_id', $this->tutor_id)
            ->where('status', 'completed')
            ->count();
        
        if ($repeatBookings > 1) {
            $weight *= 1.3;
        }

        // Older than 6 months = 0.5x
        if ($this->created_at->diffInMonths(now()) > 6) {
            $weight *= 0.5;
        }

        return $weight;
    }
}