<?php

namespace App\Livewire;

use App\Models\Budget;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class BudgetProgressBar extends Component
{
    public Budget $budget;

    public function mount(Budget $budget)
    {
        Gate::authorize('view', $budget);

        $this->budget = $budget;
    }

    public function render()
    {
        Gate::authorize('view', $this->budget);

        $spent = $this->budget->spent_amount;
        $target = $this->budget->amount;
        $pct = $target > 0 ? min(round(($spent / $target) * 100), 100) : 0;
        $color = $pct >= 90 ? 'rose' : ($pct >= 70 ? 'amber' : 'emerald');

        return view('livewire.budget-progress-bar', [
            'spent' => $spent,
            'target' => $target,
            'pct' => $pct,
            'color' => $color,
        ]);
    }
}
