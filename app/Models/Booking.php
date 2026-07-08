<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'frozen_until',
'arbitration_fee_paid',
'claimant_type',
'disputed_at',
'dispute_reason',
'arbitration_status',
'arbitration_fee_amount',
'arbitration_evidence',
        'student_id',
        'tutor_id',
        'subject_id',
        'booking_type',
        'lesson_mode',
        'scheduled_at',
        'duration_minutes',
        'lesson_fee',
        'platform_fee',
        'tutor_earnings',
        'payment_status',
        'lesson_status',
        'platform_guarantee',
        'student_notes',
        'tutor_notes',
        'dispute_until',
        'dispute_filed',
        'dispute_reason',
        'dispute_resolved_at',
        'completed_at',
        'reviewed_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'dispute_until' => 'datetime',
        'dispute_resolved_at' => 'datetime',
        'completed_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'platform_guarantee' => 'boolean',
        'dispute_filed' => 'boolean',
        'lesson_fee' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'tutor_earnings' => 'decimal:2',
        'frozen_until' => 'datetime',
'disputed_at' => 'datetime',
'arbitration_fee_paid' => 'boolean',
'arbitration_fee_amount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function isFrozen(): bool
    {
        return $this->frozen_until && $this->frozen_until->isFuture();
    }

    public function canDispute(): bool
    {
        return $this->frozen_until
            && $this->frozen_until->isFuture()
            && ($this->arbitration_status === 'none' || is_null($this->arbitration_status));
    }

    public function isArbitrationFeePaid(): bool
    {
        return $this->arbitration_fee_paid;
    }

    public function getArbitrationFee(): float
    {
        return $this->lesson_fee * 0.20;
    }

    public function releaseFunds(): void
    {
        $this->update([
            'frozen_until' => null,
            'arbitration_status' => 'none',
        ]);
    }

    public function freezeFunds(): void
    {
        $this->update([
            'frozen_until' => now()->addDays(7),
            'completed_at' => now(),
        ]);
    }
}
