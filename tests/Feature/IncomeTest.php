<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Income;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IncomeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
    }

    public function test_user_can_view_income_index()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $category = Category::create(['user_id' => $user->id, 'name' => 'Salary', 'type' => 'income']);

        Income::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 500.00,
            'date' => now()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($user)->get(route('incomes.index'));

        $response->assertStatus(200);
        $response->assertSee('500.00');
    }

    public function test_user_can_create_income()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $category = Category::create(['user_id' => $user->id, 'name' => 'Salary', 'type' => 'income']);

        $response = $this->actingAs($user)->post(route('incomes.store'), [
            'category_id' => $category->id,
            'amount' => 2500.50,
            'date' => now()->format('Y-m-d'),
            'description' => 'Monthly Salary',
        ]);

        $response->assertRedirect(route('incomes.index'));
        $this->assertDatabaseHas('incomes', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 2500.50,
        ]);
    }

    public function test_income_form_uses_default_categories_when_user_has_none(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)->get(route('incomes.create'));

        $response->assertOk();
        $response->assertSee('Salary');
        $response->assertSee('Freelance');
        $this->assertDatabaseHas('categories', ['user_id' => null, 'type' => 'income', 'name' => 'Salary']);
    }

    public function test_user_can_update_own_income()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $category = Category::create(['user_id' => $user->id, 'name' => 'Bonus', 'type' => 'income']);

        $income = Income::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 1000.00,
            'date' => now()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($user)->put(route('incomes.update', $income), [
            'category_id' => $category->id,
            'amount' => 1500.00,
            'date' => now()->format('Y-m-d'),
            'description' => 'Updated bonus',
        ]);

        $response->assertRedirect(route('incomes.index'));
        $this->assertDatabaseHas('incomes', [
            'id' => $income->id,
            'amount' => 1500.00,
        ]);
    }

    public function test_user_cannot_update_other_users_income()
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');
        $otherUser = User::factory()->create();
        $otherUser->assignRole('user');

        $category = Category::create(['user_id' => $owner->id, 'name' => 'Salary', 'type' => 'income']);
        $otherCategory = Category::create(['user_id' => $otherUser->id, 'name' => 'Other income', 'type' => 'income']);

        $income = Income::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'amount' => 1000.00,
            'date' => now()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($otherUser)->put(route('incomes.update', $income), [
            'category_id' => $otherCategory->id,
            'amount' => 9999.00,
            'date' => now()->format('Y-m-d'),
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_income()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $category = Category::create(['user_id' => $user->id, 'name' => 'Salary', 'type' => 'income']);

        $income = Income::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 1000.00,
            'date' => now()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($user)->delete(route('incomes.destroy', $income));

        $response->assertRedirect(route('incomes.index'));
        $this->assertDatabaseMissing('incomes', ['id' => $income->id]);
    }
}
