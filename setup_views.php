<?php
// Script to set up the Tailwind config and Blade views

$tailwindPath = __DIR__ . '/tailwind.config.js';

$tailwindContent = <<<'EOT'
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#f0f7ff',
                    100: '#e0effe',
                    200: '#bae0fd',
                    300: '#7cc7fb',
                    400: '#38a9f8',
                    500: '#0e8ce1',
                    600: '#026ebe',
                    700: '#03589b',
                    800: '#074b80',
                    900: '#0c406b',
                    950: '#082848',
                },
                accent: {
                    50: '#f5f3ff',
                    100: '#ede9fe',
                    200: '#ddd6fe',
                    300: '#c4b5fd',
                    400: '#a78bfa',
                    500: '#8b5cf6',
                    600: '#7c3aed',
                    700: '#6d28d9',
                    800: '#5b21b6',
                    900: '#4c1d95',
                },
            },
            boxShadow: {
                'premium': '0 8px 30px rgba(0, 0, 0, 0.04)',
                'premium-hover': '0 20px 40px rgba(0, 0, 0, 0.08)',
            },
            borderRadius: {
                'bento': '2.5rem',
            },
        },
    },

    plugins: [forms, typography],
};
EOT;

file_put_contents($tailwindPath, $tailwindContent);
echo "Tailwind configured.\n";

$dashboardPath = __DIR__ . '/resources/views/dashboard.blade.php';
$dashboardContent = <<<'EOT'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Bento Box Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Balance -->
                <div class="bg-white rounded-bento shadow-premium p-8 col-span-1 md:col-span-2 hover:shadow-premium-hover transition-shadow">
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Balance</h3>
                    <p class="text-4xl font-bold text-brand-900 mt-2">$24,500.00</p>
                    <div class="mt-4 flex space-x-4">
                        <a href="{{ route('incomes.index') }}" class="px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium">Add Income</a>
                        <a href="{{ route('expenses.index') }}" class="px-4 py-2 bg-accent-600 text-white rounded-lg hover:bg-accent-700 font-medium">Add Expense</a>
                    </div>
                </div>

                <!-- Savings Goal -->
                <div class="bg-gradient-to-br from-brand-600 to-accent-600 rounded-bento shadow-premium p-8 text-white hover:shadow-premium-hover transition-shadow">
                    <h3 class="text-white/80 text-sm font-medium uppercase tracking-wider">Savings Goal</h3>
                    <p class="text-2xl font-bold mt-2">New Car</p>
                    <div class="mt-4">
                        <div class="w-full bg-white/20 rounded-full h-2.5">
                          <div class="bg-white h-2.5 rounded-full" style="width: 45%"></div>
                        </div>
                        <p class="text-sm mt-2 font-medium">45% Reached</p>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-bento shadow-premium p-8 hover:shadow-premium-hover transition-shadow">
                <h3 class="text-gray-800 text-lg font-bold mb-4">Recent Transactions</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-4 border-b">
                        <div>
                            <p class="font-medium text-gray-800">Grocery Store</p>
                            <p class="text-sm text-gray-500">Food & Dining</p>
                        </div>
                        <p class="font-bold text-red-500">-$120.50</p>
                    </div>
                    <div class="flex justify-between items-center pb-4 border-b">
                        <div>
                            <p class="font-medium text-gray-800">Salary</p>
                            <p class="text-sm text-gray-500">Income</p>
                        </div>
                        <p class="font-bold text-green-500">+$4,200.00</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800">Netflix</p>
                            <p class="text-sm text-gray-500">Entertainment</p>
                        </div>
                        <p class="font-bold text-red-500">-$15.99</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
EOT;

file_put_contents($dashboardPath, $dashboardContent);
echo "Dashboard view generated.\n";
