<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
    }

    public function test_non_admin_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)->get(route('admin.users'));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_user_management()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.users'));

        $response->assertStatus(200);
        $response->assertSee('Manage Users');
    }

    public function test_admin_can_toggle_user_role()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $targetUser = User::factory()->create();
        $targetUser->assignRole('user');

        $response = $this->actingAs($admin)->post(route('admin.users.toggle-role', $targetUser));

        $response->assertRedirect();
        $this->assertTrue($targetUser->fresh()->hasRole('admin'));
    }

    public function test_admin_cannot_demote_themselves()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->post(route('admin.users.toggle-role', $admin));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertTrue($admin->fresh()->hasRole('admin'));
    }

    public function test_admin_cannot_view_user_transactions()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.transactions'));

        $response->assertStatus(403);
    }

    public function test_admin_dashboard_remains_admin_only()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertDontSee('Income');
        $response->assertDontSee('Expenses');
        $response->assertDontSee('Shared Budgets');
    }
}
