<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@budgetx.test'],
            [
                'name'     => 'BudgetX Admin',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // Create a demo regular user
        User::updateOrCreate(
            ['email' => 'demo@budgetx.test'],
            [
                'name'     => 'Demo User',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );
    }
}
