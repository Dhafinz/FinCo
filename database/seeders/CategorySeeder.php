<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Gaji', 'type' => 'income', 'icon' => '💼', 'color' => '#4CAF50'],
            ['name' => 'Freelance', 'type' => 'income', 'icon' => '💻', 'color' => '#2196F3'],
            ['name' => 'Investasi', 'type' => 'income', 'icon' => '📈', 'color' => '#FF9800'],
            ['name' => 'Bonus', 'type' => 'income', 'icon' => '🎁', 'color' => '#9C27B0'],
            ['name' => 'Makanan & Minuman', 'type' => 'expense', 'icon' => '🍔', 'color' => '#F44336'],
            ['name' => 'Transportasi', 'type' => 'expense', 'icon' => '🚗', 'color' => '#9C27B0'],
            ['name' => 'Belanja', 'type' => 'expense', 'icon' => '🛒', 'color' => '#E91E63'],
            ['name' => 'Hiburan', 'type' => 'expense', 'icon' => '🎬', 'color' => '#3F51B5'],
            ['name' => 'Tagihan', 'type' => 'expense', 'icon' => '💡', 'color' => '#795548'],
            ['name' => 'Kesehatan', 'type' => 'expense', 'icon' => '🏥', 'color' => '#009688'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert(array_merge($category, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}