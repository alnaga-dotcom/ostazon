<?php

namespace App\Services;

use App\Models\TutorProfile;

class BadgeService
{
    /**
     * Check and update tutor badge based on criteria
     */
    public static function updateBadge(TutorProfile $profile): void
    {
        $newBadge = self::calculateBadge($profile);

        if ($newBadge !== $profile->badge_level) {
            $profile->update([
                'badge_level' => $newBadge,
                'badge_awarded_at' => now(),
            ]);
        }
    }

    /**
     * Determine badge level based on criteria
     */
    public static function calculateBadge(TutorProfile $profile): ?string
    {
        // Must be at least verified to have any badge
        if ($profile->verification_status !== 'verified' && $profile->verification_status !== 'certified') {
            return null;
        }

        $isCertified = $profile->verification_status === 'certified';
        $hasCertificate = !empty($profile->certificate_url);
        $rating = $profile->average_rating ?? 0;
        $lessons = $profile->total_lessons ?? 0;
        $memberSince = $profile->created_at;

        // Elite: Certified + Top Rated + 6+ months
        if ($isCertified && $rating >= 4.5 && $lessons >= 50 && $memberSince->diffInMonths(now()) >= 6) {
            return 'elite';
        }

        // Top Rated: 4.5+ rating, 20+ lessons
        if ($rating >= 4.5 && $lessons >= 20) {
            return 'top';
        }

        // Certified: Has verified certificate
        if ($isCertified || $hasCertificate) {
            return 'certified';
        }

        // Verified: Basic verification passed
        return 'verified';
    }

    /**
     * Get badge display info
     */
    public static function getBadgeInfo(string $badge): array
    {
        return match($badge) {
            'verified' => [
                'label' => 'Verified',
                'label_ar' => 'موثق',
                'color' => '#22c55e', // green
                'bg' => '#dcfce7',
            ],
            'certified' => [
                'label' => 'Certified',
                'label_ar' => 'معتمد',
                'color' => '#3b82f6', // blue
                'bg' => '#dbeafe',
            ],
            'top' => [
                'label' => 'Top Rated',
                'label_ar' => 'الأعلى تقييماً',
                'color' => '#f59e0b', // gold
                'bg' => '#fef3c7',
            ],
            'elite' => [
                'label' => 'Elite',
                'label_ar' => 'نخبة',
                'color' => '#a855f7', // purple
                'bg' => '#f3e8ff',
            ],
            default => [
                'label' => 'Pending',
                'label_ar' => 'قيد المراجعة',
                'color' => '#6b7280', // gray
                'bg' => '#f3f4f6',
            ],
        };
    }
}