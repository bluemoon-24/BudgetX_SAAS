<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('savings-goals.index') }}" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight flex items-center gap-2 font-display">
                    <i class="fa-solid fa-bullseye text-amber-500"></i> Edit Savings Goal
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Update savings goal target or timeline.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-6 sm:p-8 bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 rounded-2xl shadow-sm">
                <x-validation-errors class="mb-4" />
                
                <form method="POST" action="{{ route('savings-goals.update', $savingsGoal) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="name" value="Goal Name" />
                        <x-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $savingsGoal->name) }}" required autofocus />
                    </div>

                    <div>
                        <x-label for="target_amount" value="Target Amount ({{ auth()->user()?->currencyCode() ?? 'USD' }})" />
                        <x-input id="target_amount" name="target_amount" type="number" step="0.01" min="0.01" class="mt-1 block w-full" value="{{ old('target_amount', $savingsGoal->target_amount) }}" required />
                    </div>

                    <div>
                        <x-label for="current_amount" value="Current Amount Saved ({{ auth()->user()?->currencyCode() ?? 'USD' }})" />
                        <x-input id="current_amount" name="current_amount" type="number" step="0.01" min="0" class="mt-1 block w-full" value="{{ old('current_amount', $savingsGoal->current_amount) }}" />
                    </div>

                    <div>
                        <x-label for="target_date" value="Target Date (Optional)" />
                        <x-input id="target_date" name="target_date" type="date" class="mt-1 block w-full" value="{{ old('target_date', $savingsGoal->target_date?->format('Y-m-d')) }}" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <a href="{{ route('savings-goals.index') }}" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-check mr-2"></i> Update Goal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
