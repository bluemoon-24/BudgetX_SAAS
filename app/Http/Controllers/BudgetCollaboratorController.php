<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Http\Request;

class BudgetCollaboratorController extends Controller
{
    public function store(Request $request, Budget $budget)
    {
        $this->authorize('delete', $budget); // Only owner can add collaborators

        // Enforce Premium plan for sharing
        $user = auth()->user();
        if (!$user->hasRole('premium') && !$user->hasRole('admin') && !$user->isAdmin()) {
            return back()->with('error', 'Only Premium users can share goals. Please upgrade to invite collaborators!');
        }

        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Invalid email. Please enter an email of an existing user in the system.',
            'email.email' => 'Invalid email. Please enter a valid email address.',
        ]);

        $collaborator = User::where('email', $request->email)->first();

        if ($collaborator->id === $budget->user_id) {
            return back()->with('error', 'You cannot invite yourself to your own goal.');
        }

        if ($budget->collaborators->contains($collaborator)) {
            return back()->with('error', 'This user is already a collaborator on this goal.');
        }

        $budget->collaborators()->attach($collaborator->id);

        return back()->with('success', $collaborator->name . ' has been added as a collaborator!');
    }

    public function destroy(Budget $budget, User $user)
    {
        $this->authorize('delete', $budget); // Only owner can remove collaborators
        
        $budget->collaborators()->detach($user->id);

        return back()->with('success', $user->name . ' has been removed from this goal.');
    }
}
