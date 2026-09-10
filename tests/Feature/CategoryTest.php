<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
    }

    public function test_user_can_view_system_and_custom_categories()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $systemCategory = Category::create([
            'user_id' => null,
            'name' => 'System Utilities',
            'type' => 'expense',
        ]);

        $userCategory = Category::create([
            'user_id' => $user->id,
            'name' => 'Personal Hobby',
            'type' => 'expense',
        ]);

        $response = $this->actingAs($user)->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertSee('System Utilities');
        $response->assertSee('Personal Hobby');
    }

    public function test_user_can_create_custom_category()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'Freelance Projects',
            'type' => 'income',
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', [
            'user_id' => $user->id,
            'name' => 'Freelance Projects',
            'type' => 'income',
        ]);
    }

    public function test_regular_user_cannot_update_system_category()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $systemCategory = Category::create([
            'user_id' => null,
            'name' => 'System Bills',
            'type' => 'expense',
        ]);

        $response = $this->actingAs($user)->put(route('categories.update', $systemCategory), [
            'name' => 'Modified Bills',
            'type' => 'expense',
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_system_category()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $systemCategory = Category::create([
            'user_id' => null,
            'name' => 'System Bills',
            'type' => 'expense',
        ]);

        $response = $this->actingAs($admin)->put(route('categories.update', $systemCategory), [
            'name' => 'Admin Updated Bills',
            'type' => 'expense',
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $systemCategory->id,
            'name' => 'Admin Updated Bills',
        ]);
    }
}
