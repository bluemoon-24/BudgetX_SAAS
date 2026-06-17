<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            <i class="fa-solid fa-receipt text-rose-500"></i> Expense Details
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $expense->category->name ?? 'Expense' }}</h3>
                <p class="text-sm text-slate-400 mb-6">{{ $expense->date->format('M d, Y') }}</p>
                <p class="text-3xl font-extrabold text-rose-500 mb-2" style="font-family: 'Outfit', sans-serif;">LKR {{ number_format($expense->amount, 2) }}</p>
                @if($expense->description)
                    <p class="text-slate-600 mb-6">{{ $expense->description }}</p>
                @endif
                <div class="flex gap-3">
                    <a href="{{ route('expenses.edit', $expense) }}" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition"><i class="fa-solid fa-pen mr-2"></i> Edit</a>
                    <a href="{{ route('expenses.index') }}" class="px-6 py-3 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
