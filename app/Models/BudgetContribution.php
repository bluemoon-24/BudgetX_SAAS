<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetContribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'user_id',
        'amount',
        'contribution_date',
        'note',
    ];

    protected $casts = [
        'contribution_date' => 'date',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
