<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'amount', 'period'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'budget_user');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'category_id', 'category_id');
    }

    public function contributions()
    {
        return $this->hasMany(BudgetContribution::class);
    }

    public function getSpentAmountAttribute(): float
    {
        $userIds = collect([$this->user_id]);
        if ($this->relationLoaded('collaborators')) {
            $userIds = $userIds->merge($this->collaborators->pluck('id'));
        } else {
            $userIds = $userIds->merge($this->collaborators()->pluck('users.id'));
        }

        $query = Expense::where('category_id', $this->category_id)
            ->whereIn('user_id', $userIds->unique());

        if ($this->period === 'monthly') {
            $query->whereMonth('date', now()->month)->whereYear('date', now()->year);
        } elseif ($this->period === 'weekly') {
            $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($this->period === 'yearly') {
            $query->whereYear('date', now()->year);
        } elseif ($this->period === 'daily') {
            $query->whereDate('date', now()->toDateString());
        }

        return (float) $query->sum('amount');
    }

    public function getTotalContributionsAttribute(): float
    {
        return (float) $this->contributions()->sum('amount');
    }

    // --- Scopes ---
    public function scopeMonthly(Builder $query): Builder
    {
        return $query->where('period', 'monthly');
    }

    public function scopeYearly(Builder $query): Builder
    {
        return $query->where('period', 'yearly');
    }

    // --- Accessors ---
    protected function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => '$'.number_format($this->amount, 2),
        );
    }
}
