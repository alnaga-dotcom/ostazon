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
        $lessons = $profile->total_lessons ?? 0;
        $memberSince = $profile->created_at;

        // Elite: Certified + Top Rated + 6+ months
        if ($isCertified && $lessons >= 50 && $memberSince->diffInMonths(now()) >= 6) {
            $weightedRating = self::calculateWeightedRating($profile->user_id);
            if ($weightedRating >= 4.5) {
                return 'elite';
            }
        }

        // Top Rated: 4.5+ weighted rating, 20+ lessons
        $weightedRating = self::calculateWeightedRating($profile->user_id);
        if ($weightedRating >= 4.5 && $lessons >= 20) {
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
     * Calculate weighted average rating for a tutor
     */
    public static function calculateWeightedRating(int $tutorId): float
    {
        $reviews = \App\Models\Review::where('tutor_id', $tutorId)
            ->where('is_public', true)
            ->get();

        if ($reviews->isEmpty()) {
            return 0;
        }

        $weightedSum = 0;
        $totalWeight = 0;

        foreach ($reviews as $review) {
            $weight = $review->weight;
            $weightedSum += $review->rating * $weight;
            $totalWeight += $weight;
        }

        return $totalWeight > 0 ? round($weightedSum / $totalWeight, 2) : 0;
    }

    /**
     * Get badge display info
     */
    public static function getBadgeInfo(?string $badge): array
    {
        return match($badge) {
            null, '' => [
                'label' => 'Pending',
                'label_ar' => 'قيد المراجعة',
                'color' => '#6b7280',
                'bg' => '#f3f4f6',
            ],
            'verified' => [
                'label' => 'Verified',
                'label_ar' => 'موثق',
                'color' => '#77a589',
                'bg' => '#dcfce7',
            ],
            'certified' => [
                'label' => 'Certified',
                'label_ar' => 'معتمد',
                'color' => '#92400e',
                'bg' => '#fed7aa',
            ],
            'top' => [
                'label' => 'Top Rated',
                'label_ar' => 'الأعلى تقييماً',
                'color' => '#c2410c',
                'bg' => '#ffedd5',
            ],
            'elite' => [
                'label' => 'Elite',
                'label_ar' => 'نخبة',
                'color' => '#9a3412',
                'bg' => '#fdba74',
            ],
            default => [
                'label' => 'Pending',
                'label_ar' => 'قيد المراجعة',
                'color' => '#6b7280',
                'bg' => '#f3f4f6',
            ],
        };
    }
}