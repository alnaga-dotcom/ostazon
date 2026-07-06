<?php

namespace App\Services;

use App\Models\CoinTransaction;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CoinService
{
    /**
     * Credit coins to a user's account with transaction logging.
     * Wrapped in database transaction for data integrity.
     */
    public static function credit(int $userId, int $amount, string $type, string $description, string $referenceType = null, int $referenceId = null): bool
    {
        return DB::transaction(function () use ($userId, $amount, $type, $description, $referenceType, $referenceId) {
            $profile = StudentProfile::where('user_id', $userId)->lockForUpdate()->first();

            if (!$profile) {
                Log::error("Coin credit failed: No student profile found for user {$userId}");
                return false;
            }

            $oldBalance = $profile->coins_balance;
            $profile->increment('coins_balance', $amount);

            CoinTransaction::create([
                'user_id' => $userId,
                'type' => $type,
                'amount' => $amount,
                'balance_after' => $oldBalance + $amount,
                'description' => $description,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
            ]);

            return true;
        });
    }

    /**
     * Debit coins from a user's account with transaction logging.
     * Returns false if insufficient balance.
     */
    public static function debit(int $userId, int $amount, string $type, string $description, string $referenceType = null, int $referenceId = null): bool
    {
        return DB::transaction(function () use ($userId, $amount, $type, $description, $referenceType, $referenceId) {
            $profile = StudentProfile::where('user_id', $userId)->lockForUpdate()->first();

            if (!$profile) {
                Log::error("Coin debit failed: No student profile found for user {$userId}");
                return false;
            }

            if ($profile->coins_balance < $amount) {
                Log::warning("Coin debit failed: Insufficient balance for user {$userId}. Needed: {$amount}, Has: {$profile->coins_balance}");
                return false;
            }

            $oldBalance = $profile->coins_balance;
            $profile->decrement('coins_balance', $amount);

            CoinTransaction::create([
                'user_id' => $userId,
                'type' => $type,
                'amount' => -$amount,
                'balance_after' => $oldBalance - $amount,
                'description' => $description,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
            ]);

            return true;
        });
    }

    /**
     * Get current coin balance for a user.
     */
    public static function balance(int $userId): int
    {
        $profile = StudentProfile::where('user_id', $userId)->first();
        return $profile ? $profile->coins_balance : 0;
    }

    /**
     * Check if user has sufficient coins.
     */
    public static function hasSufficient(int $userId, int $amount): bool
    {
        return self::balance($userId) >= $amount;
    }
}
