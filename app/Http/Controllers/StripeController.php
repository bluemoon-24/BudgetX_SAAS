<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentTransaction;

class StripeController extends Controller
{
    /**
     * Show subscription plans page.
     */
    public function showPlans()
    {
        return view('stripe.plans');
    }

    /**
     * Create a Stripe Checkout session and redirect.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:monthly,yearly',
        ]);

        $stripeSecret = config('services.stripe.secret');
        $currency = 'lkr';
        $amount = $request->plan === 'yearly' ? 5000.00 : 500.00;

        if (empty($stripeSecret) || $this->isMockStripeSecret($stripeSecret)) {
            return redirect()->route('subscribe')->withErrors([
                'stripe' => 'Stripe is not configured for real checkout. Add your real Stripe test keys to .env and run php artisan config:clear.',
            ]);
        }

        try {
            $stripe = $this->stripeClient();

            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => $currency,
                        'product_data' => [
                            'name' => 'BudgetX Premium ' . ucfirst($request->plan),
                        ],
                        'unit_amount' => (int) round($amount * 100),
                        'recurring' => [
                            'interval' => $request->plan === 'yearly' ? 'year' : 'month',
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode'        => 'subscription',
                'client_reference_id' => (string) auth()->id(),
                'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => route('stripe.cancel'),
                'metadata'    => [
                    'user_id' => auth()->id(),
                    'plan'    => $request->plan,
                    'currency' => 'LKR',
                ],
            ]);

            return redirect($session->url);
        } catch (\Throwable $e) {
            Log::error('Stripe Checkout session creation failed.', [
                'user_id' => auth()->id(),
                'plan' => $request->plan,
                'exception' => $e::class,
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('subscribe')->withErrors([
                'stripe' => 'We could not start checkout. Please try again later.',
            ]);
        }
    }

    private function isMockStripeSecret(?string $secret): bool
    {
        return $secret === 'sk_test_mock_secret_replace_me'
            || str_starts_with((string) $secret, 'sk_test_mock');
    }

    private function ensureRoleExists(string $roleName): void
    {
        \Spatie\Permission\Models\Role::firstOrCreate(
            ['name' => $roleName, 'guard_name' => 'web'],
            ['name' => $roleName, 'guard_name' => 'web']
        );
    }

    private function recordPaymentTransaction(int $userId, string $stripePaymentId, string $amount, string $currency, string $status): PaymentTransaction
    {
        $transaction = PaymentTransaction::where('stripe_payment_id', $stripePaymentId)->first();

        if ($transaction && (int) $transaction->user_id !== $userId) {
            throw new \RuntimeException('Stripe transaction belongs to another user.');
        }

        return $transaction ?? PaymentTransaction::create([
            'user_id' => $userId,
            'stripe_payment_id' => $stripePaymentId,
            'amount' => $amount,
            'currency' => $currency,
            'status' => $status,
        ]);
    }

    protected function stripeClient(): \Stripe\StripeClient
    {
        $secret = config('services.stripe.secret');

        if (empty($secret) || $this->isMockStripeSecret($secret)) {
            throw new \RuntimeException('Stripe is not configured.');
        }

        return new \Stripe\StripeClient($secret);
    }

    private function expectedPlan(string $plan): array
    {
        return match ($plan) {
            'monthly' => ['amount' => 50000, 'interval' => 'month', 'name' => 'BudgetX Premium Monthly'],
            'yearly' => ['amount' => 500000, 'interval' => 'year', 'name' => 'BudgetX Premium Yearly'],
            default => throw new \RuntimeException('Unexpected Stripe plan.'),
        };
    }

    private function sessionMetadata(mixed $metadata): array
    {
        if ($metadata instanceof \Stripe\StripeObject) {
            return $metadata->toArray();
        }

        return is_array($metadata) ? $metadata : (array) $metadata;
    }

    private function value(mixed $object, string $key): mixed
    {
        if (is_array($object)) {
            return $object[$key] ?? null;
        }

        return is_object($object) ? ($object->{$key} ?? null) : null;
    }

    private function verifyCheckoutSession(string $sessionId, int $userId): array
    {
        $session = $this->stripeClient()->checkout->sessions->retrieve($sessionId, [
            'expand' => ['line_items.data.price.product'],
        ]);
        $metadata = $this->sessionMetadata($this->value($session, 'metadata'));
        $plan = (string) ($metadata['plan'] ?? '');
        $expected = $this->expectedPlan($plan);
        $lineItems = $this->value($this->value($session, 'line_items'), 'data') ?? [];
        $lineItem = is_array($lineItems) && count($lineItems) === 1 ? $lineItems[0] : null;
        $price = $this->value($lineItem, 'price');
        $recurring = $this->value($price, 'recurring');
        $product = $this->value($price, 'product');

        if (
            (string) $this->value($session, 'id') !== $sessionId
            || (string) ($metadata['user_id'] ?? '') !== (string) $userId
            || ($this->value($session, 'client_reference_id') !== null && (string) $this->value($session, 'client_reference_id') !== (string) $userId)
            || $this->value($session, 'status') !== 'complete'
            || $this->value($session, 'payment_status') !== 'paid'
            || $this->value($session, 'mode') !== 'subscription'
            || (int) $this->value($session, 'amount_total') !== $expected['amount']
            || strtolower((string) $this->value($session, 'currency')) !== 'lkr'
            || !$lineItem
            || (int) $this->value($price, 'unit_amount') !== $expected['amount']
            || strtolower((string) $this->value($price, 'currency')) !== 'lkr'
            || $this->value($recurring, 'interval') !== $expected['interval']
            || ($product !== null && $this->value($product, 'name') !== $expected['name'])
        ) {
            throw new \RuntimeException('Stripe Checkout session verification failed.');
        }

        return [
            'id' => $sessionId,
            'amount' => number_format($expected['amount'] / 100, 2, '.', ''),
            'currency' => 'LKR',
            'status' => 'paid',
        ];
    }

    /**
     * Handle a verified successful payment.
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $user = $request->user();

        if (!$sessionId || !$user) {
            return redirect()->route('subscribe')->withErrors([
                'stripe' => 'We could not verify this payment.',
            ]);
        }

        try {
            $payment = $this->verifyCheckoutSession((string) $sessionId, (int) $user->id);
            $this->recordPaymentTransaction(
                (int) $user->id,
                $payment['id'],
                $payment['amount'],
                $payment['currency'],
                $payment['status']
            );

            $this->ensureRoleExists('premium');
            if (!$user->hasRole('premium')) {
                $user->assignRole('premium');
            }
            $user->forceFill(['role' => 'premium'])->save();
        } catch (\Throwable $e) {
            Log::warning('Stripe Checkout session verification failed.', [
                'user_id' => $user->id,
                'session_id' => (string) $sessionId,
                'exception' => $e::class,
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('subscribe')->withErrors([
                'stripe' => 'We could not verify this payment. Premium access was not changed.',
            ]);
        }

        return view('stripe.success');
    }

    /**
     * Handle cancelled payment.
     */
    public function cancel()
    {
        return view('stripe.cancel');
    }
}
