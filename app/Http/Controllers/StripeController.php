<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $appUrl       = config('app.url');

        $stripe = new \Stripe\StripeClient($stripeSecret);

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'lkr',
                    'product_data' => [
                        'name' => 'BudgetX Premium ' . ucfirst($request->plan),
                    ],
                    'unit_amount' => $request->plan === 'yearly' ? 9000 : 900, // $90.00 or $9.00
                    'recurring' => [
                        'interval' => $request->plan === 'yearly' ? 'year' : 'month',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode'        => 'subscription',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('stripe.cancel'),
            'metadata'    => [
                'user_id' => auth()->id(),
                'plan'    => $request->plan,
            ],
        ]);

        return redirect($session->url);
    }

    /**
     * Handle successful payment - store transaction.
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if ($sessionId) {
            $stripe  = new \Stripe\StripeClient(config('services.stripe.secret'));
            $session = $stripe->checkout->sessions->retrieve($sessionId);

            PaymentTransaction::create([
                'user_id'           => auth()->id(),
                'stripe_payment_id' => $session->id,
                'amount'            => $session->amount_total / 100,
                'currency'          => strtoupper($session->currency),
                'status'            => $session->payment_status,
            ]);

            // Assign premium role
            $user = auth()->user();
            if (! \Spatie\Permission\Models\Role::where('name', 'premium')->exists()) {
                \Spatie\Permission\Models\Role::create(['name' => 'premium']);
            }
            if (!$user->hasRole('premium')) {
                $user->assignRole('premium');
            }
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
