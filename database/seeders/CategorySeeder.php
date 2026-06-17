<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $expenseCategories = [
            ['name' => 'Food & Dining',    'color' => '#f97316'],
            ['name' => 'Transport',        'color' => '#3b82f6'],
            ['name' => 'Entertainment',    'color' => '#8b5cf6'],
            ['name' => 'Shopping',         'color' => '#ec4899'],
            ['name' => 'Health & Medical', 'color' => '#10b981'],
            ['name' => 'Utilities',        'color' => '#f59e0b'],
            ['name' => 'Housing',          'color' => '#6366f1'],
            ['name' => 'Education',        'color' => '#14b8a6'],
            ['name' => 'Other',            'color' => '#9ca3af'],
        ];

        $incomeCategories = [
            ['name' => 'Salary',     'color' => '#22c55e'],
            ['name' => 'Freelance',  'color' => '#a3e635'],
            ['name' => 'Investment', 'color' => '#06b6d4'],
            ['name' => 'Gifts',      'color' => '#f472b6'],
            ['name' => 'Other',      'color' => '#9ca3af'],
        ];

        // Create global/system categories (user_id = null)
        foreach ($expenseCategories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name'], 'type' => 'expense', 'user_id' => null],
                ['color' => $cat['color']]
            );
        }

        foreach ($incomeCategories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name'], 'type' => 'income', 'user_id' => null],
                ['color' => $cat['color']]
            );
        }
    }
}
