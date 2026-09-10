<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\BudgetCollaboratorController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\BudgetContributionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StripeController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SavingsGoalPaymentController;

// Landing page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Authenticated user routes
Route::middleware([
    'auth',
    config('jetstream.auth_session'),
])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource routes
    Route::resource('budgets',      BudgetController::class);
    Route::post('budgets/{budget}/contributions', [BudgetContributionController::class, 'store'])->name('budgets.contributions.store');
    Route::delete('budgets/{budget}/contributions/{contribution}', [BudgetContributionController::class, 'destroy'])->name('budgets.contributions.destroy');
    Route::post('budgets/{budget}/collaborators', [BudgetCollaboratorController::class, 'store'])->name('budgets.collaborators.store');
    Route::delete('budgets/{budget}/collaborators/{user}', [BudgetCollaboratorController::class, 'destroy'])->name('budgets.collaborators.destroy');
    Route::resource('expenses',     ExpenseController::class);
    Route::resource('incomes',      IncomeController::class);
    Route::resource('categories',   CategoryController::class);
    Route::resource('savings-goals', SavingsGoalController::class);

    // Savings goal payments / contributions
    Route::post('savings-goals/{savingsGoal}/payments', [SavingsGoalPaymentController::class, 'store'])->name('savings-goals.payments.store');
    Route::delete('savings-goals/{savingsGoal}/payments/{payment}', [SavingsGoalPaymentController::class, 'destroy'])->name('savings-goals.payments.destroy');

    // Premium analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics')->middleware('role:premium|admin');

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
        Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    });
});