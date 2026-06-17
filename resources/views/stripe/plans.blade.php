<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            💳 Subscription Plans
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h3 class="text-3xl font-extrabold text-gray-900 mb-4">Upgrade to Premium</h3>
                <p class="text-lg text-gray-500">Unlock advanced features, unlimited budgets, and superior analytics.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Current Free Plan -->
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm relative flex flex-col opacity-75">
                    <h4 class="font-bold text-2xl text-gray-900 mb-2">Basic</h4>
                    <p class="text-gray-500 text-sm mb-6">Your current plan.</p>
                    <div class="mb-8">
                        <span class="text-5xl font-extrabold text-gray-900">LKR 0</span>
                    </div>
                    <button disabled class="w-full inline-block text-center py-4 rounded-xl font-bold text-gray-500 bg-gray-100 cursor-not-allowed">Current Plan</button>
                </div>

                <!-- Premium Plan -->
                <div class="bg-gradient-to-br from-indigo-900 to-purple-900 rounded-2xl p-8 border border-indigo-700 shadow-xl relative flex flex-col">
                    <h4 class="font-bold text-2xl text-white mb-2">Premium</h4>
                    <p class="text-indigo-200 text-sm mb-6">Unlock full potential.</p>
                    <div class="mb-8">
                        <span class="text-5xl font-extrabold text-white">LKR 9</span>
                        <span class="text-indigo-200 font-medium">/month</span>
                    </div>
                    
                    <form action="{{ route('stripe.checkout') }}" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="plan" value="monthly">
                        <button type="submit" class="w-full inline-block text-center py-4 rounded-xl font-bold text-indigo-900 bg-white hover:bg-gray-100 transition shadow-lg shadow-white/20">
                            Upgrade Now (Test Mode)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>