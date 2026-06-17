<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
class Budget extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'category_id', 'amount', 'period'];
    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function collaborators() { return $this->belongsToMany(User::class); }

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
            get: fn () => '$' . number_format($this->amount, 2),
        );
    }
}