<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center animate-fade-in-up">
            <h1 class="text-3xl font-display font-bold text-gray-900 tracking-tight">Expense History</h1>
            <a href="{{ route('expenses.create') }}" class="mt-4 sm:mt-0 bg-primary-600 hover:bg-primary-700 text-white shadow-md font-medium py-2.5 px-6 rounded-full transition-all hover:-translate-y-0.5 active:scale-95 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                Add Expense
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-center gap-3">
                    <i class="fa-solid fa-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif

            <livewire:expense-filter />
        </div>
    </div>
</x-app-layout>
