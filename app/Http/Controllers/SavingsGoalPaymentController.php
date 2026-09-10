<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use App\Models\SavingsGoalPayment;
use Illuminate\Http\Request;

class SavingsGoalPaymentController extends Controller
{
    /**
     * Store a new contribution towards a savings goal.
     */
    public function store(Request $request, SavingsGoal $savingsGoal)
    {
        $this->authorize('update', $savingsGoal);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ]);

        $payment = $savingsGoal->payments()->create([
            'user_id' => auth()->id(),
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'note' => $validated['note'] ?? null,
        ]);

        // Automatically update goal current_amount
        $savingsGoal->increment('current_amount', $validated['amount']);

        return redirect()->route('savings-goals.show', $savingsGoal)
            ->with('success', 'Payment recorded successfully!');
    }

    /**
     * Delete a payment contribution.
     */
    public function destroy(SavingsGoal $savingsGoal, SavingsGoalPayment $payment)
    {
        $this->authorize('update', $savingsGoal);

        if ($payment->savings_goal_id !== $savingsGoal->id) {
            abort(404);
        }

        $savingsGoal->decrement('current_amount', $payment->amount);
        $payment->delete();

        return redirect()->route('savings-goals.show', $savingsGoal)
            ->with('success', 'Payment deleted.');
    }
}
