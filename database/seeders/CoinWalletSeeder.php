<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CoinWalletSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $freeCoins = $user->isStudent() ? 40 : 20;

            $user->addCoins(
                amount: $freeCoins,
                type: 'free_signup',
                description: 'Free coins for new ' . ($user->isStudent() ? 'student' : 'tutor')
            );
        }

        $this->command->info('Coin wallets seeded successfully!');
        $this->command->info('Students: 40 coins | Tutors: 20 coins');
    }
}