<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsGoalPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'savings_goal_id',
        'user_id',
        'amount',
        'payment_date',
        'note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function savingsGoal()
    {
        return $this->belongsTo(SavingsGoal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
