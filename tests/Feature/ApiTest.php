<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
    }

    public function test_unauthenticated_api_request_returns_401()
    {
        $response = $this->getJson('/api/budgets');
        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_fetch_budgets_via_api()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $category = Category::create([
            'user_id' => $user->id,
            'name' => 'Healthcare',
            'type' => 'expense',
        ]);

        Budget::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 400.00,
            'period' => 'monthly',
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson('/api/budgets');

        $response->assertStatus(200);
        $response->assertJsonFragment(['amount' => '400.00']);
    }

    public function test_authenticated_user_can_search_budgets_via_api()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $category = Category::create([
            'user_id' => $user->id,
            'name' => 'Fitness',
            'type' => 'expense',
        ]);

        Budget::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 150.00,
            'period' => 'monthly',
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson('/api/budgets?search=Fitness');

        $response->assertStatus(200);
        $response->assertJsonFragment(['amount' => '150.00']);
    }

    public function test_authenticated_user_can_fetch_expenses_via_api()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $category = Category::create([
            'user_id' => $user->id,
            'name' => 'Groceries',
            'type' => 'expense',
        ]);

        Expense::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 85.00,
            'date' => now()->format('Y-m-d'),
            'description' => 'Supermarket run',
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson('/api/expenses');

        $response->assertStatus(200);
        $response->assertJsonFragment(['description' => 'Supermarket run']);
    }
}
