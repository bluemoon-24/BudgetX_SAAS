<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('profile.show') }}" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight font-display flex items-center gap-2">
                    <i class="fa-solid fa-key text-primary-500"></i> {{ __('API Tokens') }}
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Generate and manage developer tokens to access BudgetX programmatically.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('api.api-token-manager')
        </div>
    </div>
</x-app-layout>
