<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BlockedMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
    }

    public function test_blocked_user_is_logged_out_and_redirected_to_login()
    {
        $user = User::factory()->create([
            'status' => 'blocked',
        ]);
        $user->assignRole('user');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['email']);
    }

    public function test_active_user_can_access_dashboard()
    {
        $user = User::factory()->create([
            'status' => 'active',
        ]);
        $user->assignRole('user');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
    }
}
