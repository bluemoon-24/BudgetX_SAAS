<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StripeCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_mock_stripe_secret_is_rejected_before_payment(): void
    {
        config(['services.stripe.secret' => 'sk_test_mock_secret_replace_me']);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('subscribe'))
            ->post(route('stripe.checkout'), ['plan' => 'monthly'])
            ->assertRedirect(route('subscribe'));

        $this->assertFalse($user->fresh()->hasRole('premium'));
    }
}
