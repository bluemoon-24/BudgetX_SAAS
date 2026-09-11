<?php

namespace App\Http\Controllers;

use App\Models\Expense;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard overview.
     */
    public function index()
    {
        $user = auth()->user();

        // Admin users should always use the dedicated admin console instead of the regular user dashboard.
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $totalIncome = $user->incomes()->sum('amount');
        $totalExpenses = $user->expenses()->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;

        $recentIncomes = $user->incomes()->with('category')->latest('date')->take(5)->get();
        $recentExpenses = $user->expenses()->with('category')->latest('date')->take(5)->get();

        // Expense category breakdown for Chart.js
        $categoryBreakdown = $user->expenses()
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, SUM(expenses.amount) as total')
            ->groupBy('categories.name')
            ->get();

        // Goals statistics & summaries
        $allGoals = $user->savingsGoals()->with('payments')->get();
        $totalGoals = $allGoals->count();
        $completedGoals = $allGoals->filter(function ($g) {
            $paid = $g->payments->sum('amount');

            return $g->target_amount > 0 && $paid >= $g->target_amount;
        })->count();

        $activeGoals = $allGoals->filter(function ($g) {
            $paid = $g->payments->sum('amount');

            return $g->target_amount > 0 && $paid < $g->target_amount;
        })->take(3)->map(function ($g) {
            $paid = $g->payments->sum('amount');
            $pct = $g->target_amount > 0 ? min(round(($paid / $g->target_amount) * 100), 100) : 0;

            return [
                'id' => $g->id,
                'name' => $g->name,
                'target_amount' => $g->target_amount,
                'total_paid' => $paid,
                'progress_percentage' => $pct,
            ];
        });

        return view('dashboard', compact(
            'totalExpenses',
            'totalIncome',
            'netBalance',
            'recentExpenses',
            'recentIncomes',
            'categoryBreakdown',
            'totalGoals',
            'completedGoals',
            'activeGoals'
        ));
    }
}
