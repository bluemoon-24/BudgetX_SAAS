<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Http\Requests\StoreBudgetRequest;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::with(['category', 'collaborators'])
            ->where('user_id', auth()->id())
            ->orWhereHas('collaborators', function ($query) {
                $query->where('users.id', auth()->id());
            })
            ->latest()
            ->paginate(10);

        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        $categories = Category::where('type', 'expense')->where(fn($q) => $q->whereNull('user_id')->orWhere('user_id', auth()->id()))->get();
        return view('budgets.create', compact('categories'));
    }

    public function store(StoreBudgetRequest $request)
    {
        $user = auth()->user();

        // Enforce 3-budget limit for free users
        if (!$user->hasRole('premium') && !$user->hasRole('admin') && !$user->isAdmin()) {
            $activeBudgetCount = $user->budgets()->count();
            if ($activeBudgetCount >= 3) {
                return redirect()->route('budgets.index')
                    ->with('error', 'Free plan is limited to 3 active budgets. Upgrade to Premium for unlimited budgets!');
            }
        }

        $user->budgets()->create($request->validated());
        return redirect()->route('budgets.index')->with('success', 'Budget created successfully!');
    }

    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);
        return view('budgets.show', compact('budget'));
    }

    public function edit(Budget $budget)
    {
        $this->authorize('update', $budget);
        $categories = Category::where('type', 'expense')->where(fn($q) => $q->whereNull('user_id')->orWhere('user_id', auth()->id()))->get();
        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(StoreBudgetRequest $request, Budget $budget)
    {
        $this->authorize('update', $budget);
        $budget->update($request->validated());
        return redirect()->route('budgets.index')->with('success', 'Budget updated successfully!');
    }

    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget deleted.');
    }
}