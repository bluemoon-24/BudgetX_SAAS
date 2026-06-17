<?php
$viewsDir = __DIR__ . '/resources/views/stripe/';
if (!is_dir($viewsDir)) {
    mkdir($viewsDir, 0755, true);
}

$plans = <<<'EOT'
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">💎 Upgrade to Pro</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-3xl font-extrabold text-gray-900 mb-4">Choose Your Plan</h3>
            <p class="text-gray-500 mb-8">Unlock unlimited budgets, savings goals, and advanced insights.</p>
            
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Monthly Plan -->
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-premium hover:border-brand-500 transition">
                    <h4 class="text-xl font-bold">Monthly</h4>
                    <p class="text-4xl font-extrabold mt-4">$9<span class="text-base text-gray-500 font-normal">/mo</span></p>
                    <ul class="mt-6 space-y-3 text-sm text-gray-600 text-left">
                        <li>✅ Unlimited budgets & goals</li>
                        <li>✅ Advanced reporting</li>
                        <li>✅ Smart notifications</li>
                    </ul>
                    <form action="{{ route('stripe.checkout') }}" method="POST" class="mt-8">
                        @csrf
                        <input type="hidden" name="plan" value="monthly">
                        <button type="submit" class="w-full py-3 bg-brand-600 text-white rounded-xl font-bold hover:bg-brand-700">Subscribe Monthly</button>
                    </form>
                </div>

                <!-- Yearly Plan -->
                <div class="bg-gradient-to-br from-brand-600 to-accent-600 text-white rounded-2xl p-8 shadow-premium relative">
                    <span class="absolute top-4 right-4 bg-white/20 px-3 py-1 text-xs rounded-full font-semibold">Save 15%</span>
                    <h4 class="text-xl font-bold">Yearly</h4>
                    <p class="text-4xl font-extrabold mt-4">$89<span class="text-base text-white/70 font-normal">/yr</span></p>
                    <ul class="mt-6 space-y-3 text-sm text-white/90 text-left">
                        <li>✅ Unlimited budgets & goals</li>
                        <li>✅ Advanced reporting</li>
                        <li>✅ Smart notifications</li>
                    </ul>
                    <form action="{{ route('stripe.checkout') }}" method="POST" class="mt-8">
                        @csrf
                        <input type="hidden" name="plan" value="yearly">
                        <button type="submit" class="w-full py-3 bg-white text-brand-700 rounded-xl font-bold hover:bg-gray-50">Subscribe Yearly</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
EOT;
file_put_contents($viewsDir . 'plans.blade.php', $plans);

$success = <<<'EOT'
<x-app-layout>
    <div class="py-24 text-center">
        <div class="max-w-md mx-auto bg-white rounded-2xl p-8 shadow-premium">
            <span class="text-6xl">🎉</span>
            <h2 class="text-2xl font-bold text-gray-900 mt-4">Payment Successful!</h2>
            <p class="text-gray-500 mt-2">Thank you for subscribing to BudgetX Pro. Your account has been upgraded.</p>
            <a href="{{ route('dashboard') }}" class="mt-6 inline-block w-full py-3 bg-brand-600 text-white rounded-xl font-bold hover:bg-brand-700">Go to Dashboard</a>
        </div>
    </div>
</x-app-layout>
EOT;
file_put_contents($viewsDir . 'success.blade.php', $success);

$cancel = <<<'EOT'
<x-app-layout>
    <div class="py-24 text-center">
        <div class="max-w-md mx-auto bg-white rounded-2xl p-8 shadow-premium">
            <span class="text-6xl">⚠️</span>
            <h2 class="text-2xl font-bold text-gray-900 mt-4">Payment Cancelled</h2>
            <p class="text-gray-500 mt-2">Your checkout process was cancelled. You have not been charged.</p>
            <a href="{{ route('subscribe') }}" class="mt-6 inline-block w-full py-3 border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50">Try Again</a>
        </div>
    </div>
</x-app-layout>
EOT;
file_put_contents($viewsDir . 'cancel.blade.php', $cancel);

echo "Stripe views created.\n";
