<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'amount', 'date', 'description'];

    protected $casts = ['date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // --- Scopes ---
    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('date', now()->month)
            ->whereYear('date', now()->year);
    }

    public function scopeLastMonth(Builder $query): Builder
    {
        return $query->whereMonth('date', now()->subMonth()->month)
            ->whereYear('date', now()->subMonth()->year);
    }

    // --- Accessors ---
    protected function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => '$'.number_format($this->amount, 2),
        );
    }

    protected function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->date ? $this->date->format('M d, Y') : null,
        );
    }
}
