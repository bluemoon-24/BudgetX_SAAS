<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'premium', 'user'] as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@budgetx.test'],
            [
                'name'     => 'BudgetX Admin',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'status'   => 'active',
                'currency' => 'USD',
            ]
        );

        $admin->role = 'admin';
        $admin->status = 'active';
        $admin->currency = $admin->currency ?: 'USD';
        $admin->save();

        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $demo = User::firstOrCreate(
            ['email' => 'demo@budgetx.test'],
            [
                'name'     => 'Demo User',
                'password' => Hash::make('password'),
                'role'     => 'user',
                'status'   => 'active',
                'currency' => 'USD',
            ]
        );

        $demo->role = 'user';
        $demo->status = 'active';
        $demo->currency = $demo->currency ?: 'USD';
        $demo->save();

        if (!$demo->hasRole('user')) {
            $demo->assignRole('user');
        }
    }
}
