// Add these to your app/Models/Booking.php

// Add to $fillable array:
protected $fillable = [
    // ... existing fields ...
    'frozen_until',
    'arbitration_fee_paid',
    'claimant_type',
    'disputed_at',
    'dispute_reason',
    'arbitration_status',
    'arbitration_fee_amount',
    'arbitration_evidence',
];

// Add to $casts array:
protected $casts = [
    // ... existing casts ...
    'frozen_until' => 'datetime',
    'disputed_at' => 'datetime',
    'arbitration_fee_paid' => 'boolean',
    'arbitration_fee_amount' => 'decimal:2',
];

// Add these methods:

/**
 * Check if the booking is within the frozen period
 */
public function isFrozen(): bool
{
    return $this->frozen_until && $this->frozen_until->isFuture();
}

/**
 * Check if dispute can be filed
 */
public function canDispute(): bool
{
    return $this->frozen_until 
        && $this->frozen_until->isFuture() 
        && $this->arbitration_status === 'none';
}

/**
 * Check if arbitration fee has been paid
 */
public function isArbitrationFeePaid(): bool
{
    return $this->arbitration_fee_paid;
}

/**
 * Get the arbitration fee amount (20% of lesson fee)
 */
public function getArbitrationFee(): float
{
    return $this->total_price * 0.20;
}

/**
 * Release frozen funds to tutor
 */
public function releaseFunds(): void
{
    $this->update([
        'frozen_until' => null,
        'arbitration_status' => 'none',
    ]);

    // Credit tutor coins (implement via CoinService)
    // CoinService::credit($this->tutor_id, $this->total_price, 'lesson_payment', $this->id);
}

/**
 * Freeze funds for 7 days after completion
 */
public function freezeFunds(): void
{
    $this->update([
        'frozen_until' => now()->addDays(7),
        'completed_at' => now(),
    ]);
}
