<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
    }

    public function test_user_can_view_expenses()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $category = Category::create(['user_id' => $user->id, 'name' => 'Food', 'type' => 'expense']);
        Expense::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 75.50,
            'date' => now()->format('Y-m-d'),
            'description' => 'Groceries',
        ]);

        $response = $this->actingAs($user)->get(route('expenses.index'));

        $response->assertStatus(200);
        $response->assertSee('Groceries');
        $response->assertSee('75.50');
    }

    public function test_user_can_create_expense()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $category = Category::create(['user_id' => $user->id, 'name' => 'Utilities', 'type' => 'expense']);

        $response = $this->actingAs($user)->post(route('expenses.store'), [
            'category_id' => $category->id,
            'amount' => 120.00,
            'date' => now()->format('Y-m-d'),
            'description' => 'Electricity Bill',
        ]);

        $response->assertRedirect(route('expenses.index'));
        $this->assertDatabaseHas('expenses', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 120.00,
            'description' => 'Electricity Bill',
        ]);
    }

    public function test_user_cannot_delete_other_users_expense()
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');
        $otherUser = User::factory()->create();
        $otherUser->assignRole('user');
        $category = Category::create(['user_id' => $owner->id, 'name' => 'Misc', 'type' => 'expense']);

        $expense = Expense::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'amount' => 50.00,
            'date' => now()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($otherUser)->delete(route('expenses.destroy', $expense));

        $response->assertStatus(403);
    }

    public function test_user_cannot_create_expense_with_another_users_category()
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');
        $otherUser = User::factory()->create();
        $otherUser->assignRole('user');
        $category = Category::create([
            'user_id' => $owner->id,
            'name' => 'Private category',
            'type' => 'expense',
        ]);

        $response = $this->actingAs($otherUser)
            ->from(route('expenses.create'))
            ->post(route('expenses.store'), [
                'category_id' => $category->id,
                'amount' => 25,
                'date' => now()->toDateString(),
            ]);

        $response->assertSessionHasErrors(['category_id']);
        $this->assertDatabaseMissing('expenses', [
            'user_id' => $otherUser->id,
            'category_id' => $category->id,
        ]);
    }
}
