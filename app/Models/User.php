<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'currency',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function categories() { return $this->hasMany(Category::class); }
    public function budgets() { return $this->hasMany(Budget::class); }
    public function sharedBudgets() { return $this->belongsToMany(Budget::class, 'budget_user'); }
    public function expenses() { return $this->hasMany(Expense::class); }
    public function incomes() { return $this->hasMany(Income::class); }
    public function savingsGoals() { return $this->hasMany(SavingsGoal::class); }
    public function subscriptions() { return $this->hasMany(Subscription::class); }
    public function paymentTransactions() { return $this->hasMany(PaymentTransaction::class); }

    public function isAdmin() {
        return $this->role === 'admin' || $this->hasRole('admin');
    }

    public function isPremium() {
        return $this->role === 'premium' || $this->hasRole('premium');
    }

    public function isBlocked() {
        return $this->status === 'blocked';
    }

    public function currencyCode(): string
    {
        return strtoupper($this->currency ?? 'USD');
    }

    public function currencySymbol(): string
    {
        return match ($this->currencyCode()) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'AUD', 'CAD', 'NZD' => '$',
            'LKR' => 'LKR',
            default => strtoupper($this->currencyCode()),
        };
    }

    public function formatCurrency(float $amount, int $decimals = 2): string
    {
        $code = $this->currencyCode();
        $formatted = number_format($amount, $decimals, '.', ',');

        return match ($code) {
            'JPY' => '¥ ' . number_format($amount, 0, '.', ','),
            'LKR' => 'LKR ' . $formatted,
            'USD', 'EUR', 'GBP', 'AUD', 'CAD', 'NZD', 'CHF', 'SEK', 'NOK', 'DKK', 'SGD', 'HKD', 'AED', 'SAR', 'CNY' => $this->currencySymbol() . ' ' . $formatted,
            default => $code . ' ' . $formatted,
        };
    }

    public function currencyLabel(): string
    {
        return $this->currencyCode();
    }

    public function formatCurrencyShort(float $amount): string
    {
        return $this->formatCurrency($amount, 2);
    }

    /**
     * Advanced Aggregate: Get total expenses grouped by category
     * This demonstrates raw SQL and aggregation within Eloquent.
     */
    public function getExpensesByCategory()
    {
        return $this->expenses()
            ->select('category_id', \Illuminate\Support\Facades\DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->with('category') // Eager load the category relation
            ->get();
    }
}

