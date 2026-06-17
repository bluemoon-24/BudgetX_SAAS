<x-app-layout>
    <div class="py-24 text-center">
        <div class="max-w-md mx-auto bg-white rounded-3xl p-10 shadow-xl border border-slate-100">
            <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-xmark text-4xl text-amber-600"></i>
            </div>
            <h2 class="text-3xl font-bold text-slate-900 mb-3" style="font-family: 'Outfit', sans-serif;">Payment Cancelled</h2>
            <p class="text-slate-500 mb-8">Your checkout process was cancelled. You have not been charged. You can try again anytime.</p>
            <a href="{{ route('subscribe') }}" class="inline-block w-full py-4 border-2 border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition">
                <i class="fa-solid fa-rotate-left mr-2"></i> Try Again
            </a>
        </div>
    </div>
</x-app-layout>