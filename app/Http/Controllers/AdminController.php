<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', '!=', 'blocked')->count();
        $blockedUsers = User::where('status', 'blocked')->count();
        $premiumUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'premium');
        })->count();
        $recentUsers = User::latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'activeUsers', 'blockedUsers', 'premiumUsers', 'recentUsers'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function transactions()
    {
        abort(403, 'User transaction history is not available to administrators for privacy reasons.');
    }

    public function toggleUserRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot modify your own administrative role.');
        }

        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        if ($user->role === 'admin') {
            $user->assignRole('admin');
        } else {
            $user->removeRole('admin');
        }
        $user->save();

        return back()->with('success', "User role updated to {$user->role}.");
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot block your own administrative account.');
        }

        $user->status = $user->status === 'blocked' ? 'active' : 'blocked';
        $user->save();

        $statusLabel = $user->status === 'blocked' ? 'blocked' : 'activated';

        return back()->with('success', "User {$user->name} has been {$statusLabel}.");
    }
}
