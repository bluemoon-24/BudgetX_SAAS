<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use App\Http\Requests\StoreSavingsGoalRequest;
use Illuminate\Http\Request;

class SavingsGoalController extends Controller
{
    public function index()
    {
        $goals = auth()->user()->savingsGoals()->latest()->paginate(10);
        return view('savings-goals.index', compact('goals'));
    }

    public function create()
    {
        return view('savings-goals.create');
    }

    public function store(StoreSavingsGoalRequest $request)
    {
        auth()->user()->savingsGoals()->create($request->validated());
        return redirect()->route('savings-goals.index')->with('success', 'Savings goal created!');
    }

    public function show(SavingsGoal $savingsGoal)
    {
        $this->authorize('view', $savingsGoal);
        $savingsGoal->load(['payments' => function ($q) {
            $q->latest('payment_date');
        }]);
        return view('savings-goals.show', compact('savingsGoal'));
    }

    public function edit(SavingsGoal $savingsGoal)
    {
        $this->authorize('update', $savingsGoal);
        return view('savings-goals.edit', compact('savingsGoal'));
    }

    public function update(StoreSavingsGoalRequest $request, SavingsGoal $savingsGoal)
    {
        $this->authorize('update', $savingsGoal);
        $savingsGoal->update($request->validated());
        return redirect()->route('savings-goals.index')->with('success', 'Savings goal updated!');
    }

    public function destroy(SavingsGoal $savingsGoal)
    {
        $this->authorize('delete', $savingsGoal);
        $savingsGoal->delete();
        return redirect()->route('savings-goals.index')->with('success', 'Savings goal deleted.');
    }
}
