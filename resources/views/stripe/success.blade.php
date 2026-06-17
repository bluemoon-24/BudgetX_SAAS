<x-app-layout>
    <div class="py-24 text-center">
        <div class="max-w-md mx-auto bg-white rounded-3xl p-10 shadow-xl border border-slate-100">
            <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-check text-4xl text-emerald-600"></i>
            </div>
            <h2 class="text-3xl font-bold text-slate-900 mb-3" style="font-family: 'Outfit', sans-serif;">Payment Successful!</h2>
            <p class="text-slate-500 mb-8">Thank you for subscribing to BudgetX Premium. Your account has been upgraded and all features are now unlocked.</p>
            <a href="{{ route('dashboard') }}" class="inline-block w-full py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">
                <i class="fa-solid fa-arrow-right mr-2"></i> Go to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>