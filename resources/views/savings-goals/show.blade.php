<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            <i class="fa-solid fa-bullseye text-amber-500"></i> Goal Details
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                @php
                    $pct = $savingsGoal->target_amount > 0 ? min(($savingsGoal->current_amount / $savingsGoal->target_amount) * 100, 100) : 0;
                    $color = $pct >= 100 ? 'emerald' : ($pct >= 50 ? 'amber' : 'indigo');
                @endphp
                <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $savingsGoal->name }}</h3>
                @if($savingsGoal->deadline)
                    <p class="text-sm text-slate-400 mb-6"><i class="fa-regular fa-calendar mr-1"></i> Target: {{ $savingsGoal->deadline->format('M d, Y') }}</p>
                @endif
                <p class="text-3xl font-extrabold text-{{ $color }}-500 mb-4" style="font-family: 'Outfit', sans-serif;">LKR {{ number_format($savingsGoal->current_amount, 2) }} <span class="text-lg text-slate-400 font-normal">/ LKR {{ number_format($savingsGoal->target_amount, 2) }}</span></p>
                <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden mb-6">
                    <div class="h-full rounded-full bg-{{ $color }}-500 transition-all duration-700" style="width: {{ $pct }}%"></div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('savings-goals.edit', $savingsGoal) }}" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition"><i class="fa-solid fa-pen mr-2"></i> Edit</a>
                    <a href="{{ route('savings-goals.index') }}" class="px-6 py-3 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
