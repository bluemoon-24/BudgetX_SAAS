<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total_users' => User::count(),
            'total_budgets' => Budget::count(),
            'total_expenses' => Expense::count(),
            'recent_users' => User::latest()->take(5)->get(['id', 'name', 'email', 'created_at']),
        ];

        return $this->successResponse($stats, 'Admin dashboard statistics retrieved successfully.');
    }
}
