<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BudgetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'user']);
        Role::create(['name' => 'premium']);
        Role::create(['name' => 'admin']);
    }

    public function test_user_can_create_budget()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $category = Category::create(['user_id' => $user->id, 'name' => 'Food & Dining', 'type' => 'expense']);

        $response = $this->actingAs($user)->post(route('budgets.store'), [
            'category_id' => $category->id,
            'amount' => 500.00,
            'period' => 'monthly',
        ]);

        $response->assertRedirect(route('budgets.index'));
        $this->assertDatabaseHas('budgets', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 500.00,
            'period' => 'monthly',
        ]);
    }

    public function test_budget_spent_amount_accessor_calculates_expenses_correctly()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $category = Category::create(['user_id' => $user->id, 'name' => 'Transport', 'type' => 'expense']);

        $budget = Budget::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 200.00,
            'period' => 'monthly',
        ]);

        Expense::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 45.00,
            'date' => now()->format('Y-m-d'),
        ]);

        Expense::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 30.00,
            'date' => now()->format('Y-m-d'),
        ]);

        $this->assertEquals(75.00, $budget->fresh()->spent_amount);
    }

    public function test_user_can_add_contributions_to_shared_budget()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $category = Category::create(['user_id' => $user->id, 'name' => 'Travel', 'type' => 'expense']);

        $budget = Budget::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 500.00,
            'period' => 'monthly',
        ]);

        $response = $this->actingAs($user)->post(route('budgets.contributions.store', $budget), [
            'amount' => 125.50,
            'contribution_date' => now()->toDateString(),
            'note' => 'Monthly share',
        ]);

        $response->assertRedirect(route('budgets.show', $budget));
        $this->assertDatabaseHas('budget_contributions', [
            'budget_id' => $budget->id,
            'user_id' => $user->id,
            'amount' => 125.50,
            'note' => 'Monthly share',
        ]);
        $this->assertEquals(125.50, $budget->fresh()->total_contributions);
    }

    public function test_user_cannot_invite_nonexistent_email_to_shared_budget()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $user->assignRole('premium');
        $category = Category::create(['user_id' => $user->id, 'name' => 'Groceries', 'type' => 'expense']);

        $budget = Budget::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 400.00,
            'period' => 'monthly',
        ]);

        $response = $this->actingAs($user)->from(route('budgets.show', $budget))
            ->post(route('budgets.collaborators.store', $budget), [
                'email' => 'ghost@example.com',
            ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertStringContainsString('invalid email', strtolower($response->baseResponse->getSession()->get('errors')->first('email') ?? ''));
    }

    public function test_user_can_delete_own_budget()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $category = Category::create(['user_id' => $user->id, 'name' => 'Shopping', 'type' => 'expense']);

        $budget = Budget::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 300.00,
            'period' => 'monthly',
        ]);

        $response = $this->actingAs($user)->delete(route('budgets.destroy', $budget));

        $response->assertRedirect(route('budgets.index'));
        $this->assertDatabaseMissing('budgets', ['id' => $budget->id]);
    }
}
