<?php

namespace Tests\Feature;

use App\Http\Controllers\StripeController;
use App\Models\PaymentTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Spatie\Permission\Models\Role;
use Stripe\StripeClient;
use Tests\TestCase;

class StripePaymentRegressionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'premium']);
    }

    public function test_subscription_plans_page_renders(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user)
            ->get(route('subscribe'))
            ->assertStatus(200)
            ->assertSee('Premium Monthly')
            ->assertSee('Premium Annual');
    }

    public function test_monthly_checkout_creates_a_stripe_session_without_granting_premium(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->mockCheckoutSession('monthly');

        $this->actingAs($user)
            ->post(route('stripe.checkout'), ['plan' => 'monthly'])
            ->assertRedirect('https://checkout.stripe.test/session_monthly');

        $this->assertDatabaseCount('payment_transactions', 0);
        $this->assertFalse($user->fresh()->hasRole('premium'));
    }

    public function test_yearly_checkout_preserves_the_existing_price_and_interval(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->mockCheckoutSession('yearly');

        $this->actingAs($user)
            ->post(route('stripe.checkout'), ['plan' => 'yearly'])
            ->assertRedirect('https://checkout.stripe.test/session_yearly');

        $this->assertDatabaseCount('payment_transactions', 0);
        $this->assertFalse($user->fresh()->hasRole('premium'));
    }

    public function test_invalid_plan_is_rejected(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user)
            ->from(route('subscribe'))
            ->post('/stripe/checkout', ['plan' => 'lifetime'])
            ->assertSessionHasErrors('plan');
    }

    public function test_unauthenticated_users_cannot_initiate_checkout(): void
    {
        $this->post('/stripe/checkout', ['plan' => 'monthly'])
            ->assertRedirect('/login');
    }

    public function test_verified_success_grants_premium_and_records_one_transaction(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $this->mockRetrievedSession($user->id, 'monthly');

        $this->actingAs($user)
            ->get('/stripe/success?session_id=cs_test_monthly')
            ->assertStatus(200);

        $this->actingAs($user)
            ->get('/stripe/success?session_id=cs_test_monthly')
            ->assertStatus(200);

        $this->assertSame(1, PaymentTransaction::where('stripe_payment_id', 'cs_test_monthly')->count());
        $this->assertDatabaseHas('payment_transactions', [
            'stripe_payment_id' => 'cs_test_monthly',
            'user_id' => $user->id,
            'amount' => '500.00',
            'currency' => 'LKR',
            'status' => 'paid',
        ]);
        $this->assertTrue($user->fresh()->hasRole('premium'));
    }

    public function test_invalid_stripe_session_does_not_grant_premium_or_create_transaction(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $this->mockStripeRetrieveFailure();

        $this->actingAs($user)
            ->get('/stripe/success?session_id=cs_test_invalid')
            ->assertRedirect(route('subscribe'))
            ->assertSessionHasErrors('stripe');

        $this->assertDatabaseCount('payment_transactions', 0);
        $this->assertFalse($user->fresh()->hasRole('premium'));
    }

    public function test_session_for_another_user_does_not_grant_premium(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $this->mockRetrievedSession($user->id + 1, 'monthly');

        $this->actingAs($user)
            ->get('/stripe/success?session_id=cs_test_wrong_user')
            ->assertRedirect(route('subscribe'))
            ->assertSessionHasErrors('stripe');

        $this->assertDatabaseCount('payment_transactions', 0);
        $this->assertFalse($user->fresh()->hasRole('premium'));
    }

    public function test_unsuccessful_stripe_session_does_not_grant_premium(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $this->mockRetrievedSession($user->id, 'monthly', ['payment_status' => 'unpaid']);

        $this->actingAs($user)
            ->get('/stripe/success?session_id=cs_test_unpaid')
            ->assertRedirect(route('subscribe'))
            ->assertSessionHasErrors('stripe');

        $this->assertDatabaseCount('payment_transactions', 0);
        $this->assertFalse($user->fresh()->hasRole('premium'));
    }

    private function mockCheckoutSession(string $plan): void
    {
        config(['services.stripe.secret' => 'sk_test_valid_for_tests']);

        $sessions = Mockery::mock();
        $sessions->shouldReceive('create')
            ->once()
            ->withArgs(function (array $payload) use ($plan): bool {
                return $payload['metadata']['plan'] === $plan
                    && $payload['line_items'][0]['price_data']['unit_amount'] === ($plan === 'yearly' ? 500000 : 50000)
                    && $payload['line_items'][0]['price_data']['recurring']['interval'] === ($plan === 'yearly' ? 'year' : 'month');
            })
            ->andReturn((object) ['url' => 'https://checkout.stripe.test/session_'.$plan]);

        $client = Mockery::mock(StripeClient::class);
        $client->checkout = (object) ['sessions' => $sessions];
        $this->bindStripeClient($client);
    }

    private function mockRetrievedSession(int $userId, string $plan, array $overrides = []): void
    {
        config(['services.stripe.secret' => 'sk_test_valid_for_tests']);
        $amount = $plan === 'yearly' ? 500000 : 50000;
        $interval = $plan === 'yearly' ? 'year' : 'month';
        $name = $plan === 'yearly' ? 'BudgetX Premium Yearly' : 'BudgetX Premium Monthly';
        $session = (object) array_merge([
            'id' => 'cs_test_monthly',
            'client_reference_id' => (string) $userId,
            'metadata' => ['user_id' => (string) $userId, 'plan' => $plan],
            'status' => 'complete',
            'payment_status' => 'paid',
            'mode' => 'subscription',
            'amount_total' => $amount,
            'currency' => 'lkr',
            'line_items' => (object) ['data' => [(object) ['price' => (object) [
                'unit_amount' => $amount,
                'currency' => 'lkr',
                'recurring' => (object) ['interval' => $interval],
                'product' => (object) ['name' => $name],
            ]]]],
        ], $overrides);

        $sessions = Mockery::mock();
        $sessions->shouldReceive('retrieve')->andReturn($session);
        $client = Mockery::mock(StripeClient::class);
        $client->checkout = (object) ['sessions' => $sessions];
        $this->bindStripeClient($client);
    }

    private function mockStripeRetrieveFailure(): void
    {
        config(['services.stripe.secret' => 'sk_test_valid_for_tests']);
        $sessions = Mockery::mock();
        $sessions->shouldReceive('retrieve')->once()->andThrow(new \RuntimeException('Stripe API unavailable.'));
        $client = Mockery::mock(StripeClient::class);
        $client->checkout = (object) ['sessions' => $sessions];
        $this->bindStripeClient($client);
    }

    private function bindStripeClient(StripeClient $client): void
    {
        $controller = Mockery::mock(StripeController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods()
            ->shouldReceive('stripeClient')
            ->andReturn($client);
        $this->app->instance(StripeController::class, $controller);
    }

    public function test_cancel_route_is_accessible_to_authenticated_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user)
            ->get('/stripe/cancel')
            ->assertStatus(200)
            ->assertSee('Your checkout process was cancelled');
    }
}
