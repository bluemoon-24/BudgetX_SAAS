<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'user']);
        Role::create(['name' => 'premium']);
        Role::create(['name' => 'admin']);
    }

    public function test_analytics_dashboard_renders_successfully()
    {
        $user = User::factory()->create();
        $user->assignRole('premium');

        $expenseCategory = Category::create([
            'user_id' => $user->id,
            'name' => 'General',
            'type' => 'expense',
        ]);

        $incomeCategory = Category::create([
            'user_id' => $user->id,
            'name' => 'Salary',
            'type' => 'income',
        ]);

        Income::create([
            'user_id' => $user->id,
            'category_id' => $incomeCategory->id,
            'amount' => 5000.00,
            'date' => now()->format('Y-m-d'),
        ]);

        Expense::create([
            'user_id' => $user->id,
            'category_id' => $expenseCategory->id,
            'amount' => 1500.00,
            'date' => now()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($user)->get(route('analytics'));

        $response->assertStatus(200);
        $response->assertSee('Analytics');
    }
}
