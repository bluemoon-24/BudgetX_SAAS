<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetContribution;
use Illuminate\Http\Request;

class BudgetContributionController extends Controller
{
    public function store(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'contribution_date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ]);

        $budget->contributions()->create([
            'user_id' => auth()->id(),
            'amount' => $validated['amount'],
            'contribution_date' => $validated['contribution_date'],
            'note' => $validated['note'] ?? null,
        ]);

        return redirect()->route('budgets.show', $budget)
            ->with('success', 'Contribution added successfully!');
    }

    public function destroy(Budget $budget, BudgetContribution $contribution)
    {
        $this->authorize('update', $budget);

        if ($contribution->budget_id !== $budget->id) {
            abort(404);
        }

        if (auth()->id() !== $contribution->user_id && auth()->id() !== $budget->user_id) {
            abort(403);
        }

        $contribution->delete();

        return redirect()->route('budgets.show', $budget)
            ->with('success', 'Contribution deleted.');
    }
}
