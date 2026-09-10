<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('incomes.index') }}" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight flex items-center gap-2 font-display">
                    <i class="fa-solid fa-wallet text-emerald-500"></i> Edit Income
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Update income record details.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-6 sm:p-8 bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 rounded-2xl shadow-sm">
                <x-validation-errors class="mb-4" />
                
                <form method="POST" action="{{ route('incomes.update', $income) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="amount" value="Income Amount ({{ auth()->user()?->currencyCode() ?? 'USD' }})" />
                        <x-input id="amount" name="amount" type="number" step="0.01" min="0.01" class="mt-1 block w-full" value="{{ old('amount', $income->amount) }}" required autofocus />
                    </div>

                    <div>
                        <x-label for="category_id" value="Source Category" />
                        <select id="category_id" name="category_id" class="mt-1 block w-full border-slate-300 dark:border-slate-700 dark:bg-slate-900/80 dark:text-slate-100 rounded-xl shadow-sm text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 transition" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id', $income->category_id) == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-label for="date" value="Date Received" />
                        <x-input id="date" name="date" type="date" class="mt-1 block w-full" value="{{ old('date', $income->date->format('Y-m-d')) }}" required />
                    </div>

                    <div>
                        <x-label for="description" value="Description (Optional)" />
                        <x-input id="description" name="description" type="text" class="mt-1 block w-full" value="{{ old('description', $income->description) }}" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <a href="{{ route('incomes.index') }}" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-check mr-2"></i> Update Income
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
