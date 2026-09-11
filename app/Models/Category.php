<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'type', 'color'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public static function ensureSystemDefaults(): void
    {
        $expenseCategories = [
            ['name' => 'Food & Dining', 'color' => '#f97316'],
            ['name' => 'Transport', 'color' => '#3b82f6'],
            ['name' => 'Entertainment', 'color' => '#8b5cf6'],
            ['name' => 'Shopping', 'color' => '#ec4899'],
            ['name' => 'Health & Medical', 'color' => '#10b981'],
            ['name' => 'Utilities', 'color' => '#f59e0b'],
            ['name' => 'Housing', 'color' => '#6366f1'],
            ['name' => 'Education', 'color' => '#14b8a6'],
            ['name' => 'Other', 'color' => '#9ca3af'],
        ];

        $incomeCategories = [
            ['name' => 'Salary', 'color' => '#22c55e'],
            ['name' => 'Freelance', 'color' => '#a3e635'],
            ['name' => 'Investment', 'color' => '#06b6d4'],
            ['name' => 'Gifts', 'color' => '#f472b6'],
            ['name' => 'Other', 'color' => '#9ca3af'],
        ];

        foreach ($expenseCategories as $cat) {
            static::firstOrCreate([
                'user_id' => null,
                'name' => $cat['name'],
                'type' => 'expense',
            ], [
                'color' => $cat['color'],
            ]);
        }

        foreach ($incomeCategories as $cat) {
            static::firstOrCreate([
                'user_id' => null,
                'name' => $cat['name'],
                'type' => 'income',
            ], [
                'color' => $cat['color'],
            ]);
        }
    }
}
