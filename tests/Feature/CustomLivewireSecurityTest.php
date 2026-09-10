<?php

namespace Tests\Feature;

use App\Livewire\BudgetProgressBar;
use App\Livewire\ExpenseFilter;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CustomLivewireSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_expense_filter_cannot_delete_another_users_expense(): void
    {
        $owner = User::factory()->create();
        $attacker = User::factory()->create();
        $category = Category::create([
            'user_id' => $owner->id,
            'name' => 'Food',
            'type' => 'expense',
        ]);
        $expense = Expense::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'amount' => 25,
            'date' => now()->toDateString(),
        ]);

        $this->actingAs($attacker);
        Livewire::test(ExpenseFilter::class)
            ->call('deleteExpense', $expense->id)
            ->assertStatus(403);
    }

    public function test_budget_progress_bar_cannot_mount_for_another_users_budget(): void
    {
        $owner = User::factory()->create();
        $attacker = User::factory()->create();
        $category = Category::create([
            'user_id' => $owner->id,
            'name' => 'Travel',
            'type' => 'expense',
        ]);
        $budget = Budget::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'amount' => 100,
            'period' => 'monthly',
        ]);

        $this->actingAs($attacker);
        Livewire::test(BudgetProgressBar::class, ['budget' => $budget])
            ->assertStatus(403);
    }

    public function test_expense_filter_rejects_invalid_filter_state(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(ExpenseFilter::class)
            ->set('search', str_repeat('x', 256))
            ->assertHasErrors(['search']);
    }
}
