<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $totalUsers       = User::count();
        $totalExpenses    = Expense::sum('amount');
        $totalIncomes     = Income::sum('amount');
        $recentUsers      = User::latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalExpenses', 'totalIncomes', 'recentUsers'
        ));
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function transactions()
    {
        $expenses = Expense::with(['user', 'category'])->latest()->paginate(20);
        return view('admin.transactions', compact('expenses'));
    }

    public function toggleUserRole(User $user)
    {
        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();
        return back()->with('success', "User role updated to {$user->role}.");
    }
}
