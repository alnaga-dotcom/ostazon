<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'referral_code',
        'referred_by',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPassword($token));
    }

    // Role helpers
    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isTutor()
    {
        return $this->role === 'tutor';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Student profile
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    // Tutor profile
    public function tutorProfile()
    {
        return $this->hasOne(TutorProfile::class);
    }

    // Reviews
    public function reviewsAsTutor()
    {
        return $this->hasMany(Review::class, 'tutor_id');
    }

    public function reviewsAsStudent()
    {
        return $this->hasMany(Review::class, 'student_id');
    }

    // Bookings
    public function studentBookings()
    {
        return $this->hasMany(Booking::class, 'student_id');
    }

    public function tutorBookings()
    {
        return $this->hasMany(Booking::class, 'tutor_id');
    }

    // Requests
    public function tutoringRequests()
    {
        return $this->hasMany(TutoringRequest::class, 'student_id');
    }

    public function proposals()
    {
        return $this->hasMany(TutorProposal::class, 'tutor_id');
    }

    public function coinTransactions()
    {
        return $this->hasMany(CoinTransaction::class);
    }

    // Referrals
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }
}