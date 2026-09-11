<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ApiAuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
    }

    public function test_register_returns_token_and_user_data(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Alice Example',
            'email' => 'alice@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.user.email', 'alice@example.com')
            ->assertJsonPath('data.token', fn ($token) => is_string($token) && $token !== '');
    }

    public function test_login_rejects_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'alice@example.com',
            'password' => bcrypt('correct-password'),
        ]);
        $user->assignRole('user');

        $response = $this->postJson('/api/login', [
            'email' => 'alice@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'The provided credentials are incorrect.');
    }

    public function test_blocked_user_cannot_login_to_the_api(): void
    {
        $user = User::factory()->create([
            'email' => 'blocked@example.com',
            'password' => bcrypt('correct-password'),
            'status' => 'blocked',
        ]);
        $user->assignRole('user');

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'correct-password',
        ])->assertStatus(401)
            ->assertJsonPath('message', 'The provided credentials are incorrect.');
    }

    public function test_blocked_user_token_is_rejected_and_revoked(): void
    {
        $user = User::factory()->create(['status' => 'blocked']);
        $user->assignRole('user');
        $token = $user->createToken('blocked-device', ['*']);

        $this->withToken($token->plainTextToken)
            ->getJson('/api/user')
            ->assertStatus(403)
            ->assertJsonPath('message', 'Your account is suspended.');

        $this->assertDatabaseMissing('personal_access_tokens', ['id' => $token->accessToken->id]);
    }

    public function test_protected_endpoint_requires_sanctum_token(): void
    {
        $this->getJson('/api/budgets')->assertStatus(401);
    }

    public function test_user_model_uses_sanctum_api_tokens(): void
    {
        $this->assertContains(HasApiTokens::class, class_uses_recursive(User::class));
    }

    public function test_valid_sanctum_token_can_access_profile(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        Sanctum::actingAs($user, ['*']);

        $this->getJson('/api/user')
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.email', $user->email)
            ->assertJsonMissingPath('data.password')
            ->assertJsonMissingPath('data.two_factor_secret')
            ->assertJsonMissingPath('data.status');
    }

    public function test_revoked_sanctum_token_is_rejected(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $token = $user->createToken('api-test', ['*']);
        $plainToken = $token->plainTextToken;
        $beforeCount = $user->fresh()->tokens()->count();

        $this->withToken($plainToken)->postJson('/api/logout')
            ->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $token->accessToken->id,
        ]);
        $this->assertSame($beforeCount - 1, $user->fresh()->tokens()->count());
    }

    public function test_logout_all_revokes_every_token_for_the_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $firstToken = $user->createToken('first-device', ['*'])->plainTextToken;
        $secondToken = $user->createToken('second-device', ['*'])->plainTextToken;

        $this->withToken($firstToken)->postJson('/api/logout-all')
            ->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseCount('personal_access_tokens', 0);
        Auth::forgetGuards();
        $this->withToken($secondToken)->getJson('/api/user')->assertStatus(401);
    }

    public function test_user_cannot_view_another_users_category(): void
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');
        $other = User::factory()->create();
        $other->assignRole('user');

        $category = Category::create([
            'user_id' => $owner->id,
            'name' => 'Private Category',
            'type' => 'expense',
        ]);

        Sanctum::actingAs($other, ['*']);

        $this->getJson('/api/categories/'.$category->id)->assertStatus(403);
    }

    public function test_expense_creation_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $category = Category::create([
            'user_id' => $user->id,
            'name' => 'Groceries',
            'type' => 'expense',
        ]);

        Sanctum::actingAs($user, ['*']);

        $this->postJson('/api/expenses', [
            'category_id' => $category->id,
            'amount' => -10,
            'date' => '2026-09-10',
            'description' => 'bad',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['amount']);
    }

    public function test_expense_creation_rejects_another_users_category(): void
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');
        $other = User::factory()->create();
        $other->assignRole('user');
        $category = Category::create([
            'user_id' => $owner->id,
            'name' => 'Private category',
            'type' => 'expense',
        ]);

        Sanctum::actingAs($other, ['*']);

        $this->postJson('/api/expenses', [
            'category_id' => $category->id,
            'amount' => 25,
            'date' => now()->toDateString(),
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['category_id']);
    }

    public function test_budget_listing_rejects_unbounded_pagination_and_ignores_unknown_sort_columns(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        Sanctum::actingAs($user, ['*']);

        $this->getJson('/api/budgets?per_page=1000')
            ->assertStatus(422)
            ->assertJsonValidationErrors(['per_page']);

        $this->getJson('/api/budgets?sort=users.email')
            ->assertStatus(200);
    }

    public function test_admin_dashboard_requires_admin_role(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        Sanctum::actingAs($user, ['*']);

        $this->getJson('/api/admin/dashboard')->assertStatus(403);
    }

    public function test_admin_dashboard_returns_statistics_for_admin(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        User::factory()->count(2)->create();
        $user = User::factory()->create();
        $user->assignRole('user');

        $category = Category::create([
            'user_id' => $user->id,
            'name' => 'Rent',
            'type' => 'expense',
        ]);

        Budget::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 500,
            'period' => 'monthly',
        ]);

        Expense::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 120,
            'date' => now()->toDateString(),
            'description' => 'June rent',
        ]);

        Sanctum::actingAs($admin, ['*']);

        $this->getJson('/api/admin/dashboard')
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.total_users', 4)
            ->assertJsonPath('data.total_budgets', 1)
            ->assertJsonPath('data.total_expenses', 1);
    }
}
