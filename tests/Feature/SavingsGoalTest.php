<?php

namespace Tests\Feature;

use App\Models\SavingsGoal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SavingsGoalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
    }

    public function test_user_can_create_savings_goal()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)->post(route('savings-goals.store'), [
            'name' => 'Emergency Fund',
            'target_amount' => 5000.00,
            'current_amount' => 500.00,
            'target_date' => now()->addYear()->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('savings-goals.index'));
        $this->assertDatabaseHas('savings_goals', [
            'user_id' => $user->id,
            'name' => 'Emergency Fund',
            'target_amount' => 5000.00,
            'current_amount' => 500.00,
        ]);
    }

    public function test_user_can_update_savings_goal()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $goal = SavingsGoal::create([
            'user_id' => $user->id,
            'name' => 'New Laptop',
            'target_amount' => 2000.00,
            'current_amount' => 1000.00,
            'target_date' => now()->addMonths(6)->format('Y-m-d'),
        ]);

        $response = $this->actingAs($user)->put(route('savings-goals.update', $goal), [
            'name' => 'MacBook Pro',
            'target_amount' => 2500.00,
            'current_amount' => 1500.00,
            'target_date' => now()->addMonths(3)->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('savings-goals.index'));
        $this->assertDatabaseHas('savings_goals', [
            'id' => $goal->id,
            'name' => 'MacBook Pro',
            'target_amount' => 2500.00,
            'current_amount' => 1500.00,
        ]);
    }

    public function test_user_can_delete_savings_goal()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $goal = SavingsGoal::create([
            'user_id' => $user->id,
            'name' => 'Vacation',
            'target_amount' => 1500.00,
            'current_amount' => 300.00,
        ]);

        $response = $this->actingAs($user)->delete(route('savings-goals.destroy', $goal));

        $response->assertRedirect(route('savings-goals.index'));
        $this->assertDatabaseMissing('savings_goals', ['id' => $goal->id]);
    }
}
