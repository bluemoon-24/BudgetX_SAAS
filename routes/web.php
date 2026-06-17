<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\BudgetCollaboratorController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StripeController;

// Landing page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Authenticated & Verified user routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        $totalExpenses = $user->expenses()->whereMonth('date', now()->month)->sum('amount');
        $totalIncome   = $user->incomes()->whereMonth('date', now()->month)->sum('amount');
        $netBalance    = $totalIncome - $totalExpenses;
        $recentExpenses = $user->expenses()->with('category')->latest()->take(5)->get();
        $savingsGoals  = $user->savingsGoals()->get();

        return view('dashboard', compact(
            'totalExpenses', 'totalIncome', 'netBalance', 'recentExpenses', 'savingsGoals'
        ));
    })->name('dashboard');

    // Resource routes
    Route::resource('budgets',      BudgetController::class);
    Route::post('budgets/{budget}/collaborators', [BudgetCollaboratorController::class, 'store'])->name('budgets.collaborators.store');
    Route::delete('budgets/{budget}/collaborators/{user}', [BudgetCollaboratorController::class, 'destroy'])->name('budgets.collaborators.destroy');
    Route::resource('expenses',     ExpenseController::class);
    Route::resource('incomes',      IncomeController::class);
    Route::resource('categories',   CategoryController::class);
    Route::resource('savings-goals', SavingsGoalController::class);

    // Stripe
    Route::get('/subscribe',             [StripeController::class, 'showPlans'])->name('subscribe');
    Route::post('/stripe/checkout',      [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/stripe/success',        [StripeController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel',         [StripeController::class, 'cancel'])->name('stripe.cancel');

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/',              [AdminController::class, 'index'])->name('dashboard');
        Route::get('/users',         [AdminController::class, 'users'])->name('users');
        Route::get('/transactions',  [AdminController::class, 'transactions'])->name('transactions');
        Route::post('/users/{user}/toggle-role', [AdminController::class, 'toggleUserRole'])->name('users.toggle-role');
    });
});