<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            ['name' => 'Primary School', 'display_order' => 1],
            ['name' => 'Preparatory School', 'display_order' => 2],
            ['name' => 'Secondary School', 'display_order' => 3],
            ['name' => 'College / University', 'display_order' => 4],
            ['name' => 'Post Graduate', 'display_order' => 5],
        ];

        foreach ($levels as $level) {
            Level::firstOrCreate(['name' => $level['name']], $level);
        }

        $this->command->info('Levels seeded.');
    }
}
