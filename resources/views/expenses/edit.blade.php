<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('expenses.index') }}" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight flex items-center gap-2 font-display">
                    <i class="fa-solid fa-receipt text-rose-500"></i> Edit Expense
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Update expense details.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-6 sm:p-8 bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 rounded-2xl shadow-sm">
                <x-validation-errors class="mb-4" />
                
                <form action="{{ route('expenses.update', $expense) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <x-label for="amount" value="Amount ({{ auth()->user()?->currencyCode() ?? 'USD' }})" />
                        <x-input type="number" step="0.01" min="0.01" name="amount" id="amount" value="{{ old('amount', $expense->amount) }}" class="mt-1 block w-full" required autofocus />
                        @error('amount')
                            <p class="mt-2 text-sm text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-label for="category_id" value="Category" />
                        <select id="category_id" name="category_id" class="mt-1 block w-full border-slate-300 dark:border-slate-700 dark:bg-slate-900/80 dark:text-slate-100 rounded-xl shadow-sm text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 transition" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $expense->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-label for="date" value="Date" />
                        <x-input type="date" name="date" id="date" value="{{ old('date', $expense->date->format('Y-m-d')) }}" class="mt-1 block w-full" required />
                        @error('date')
                            <p class="mt-2 text-sm text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-label for="description" value="Description (Optional)" />
                        <x-input type="text" name="description" id="description" value="{{ old('description', $expense->description) }}" class="mt-1 block w-full" />
                        @error('description')
                            <p class="mt-2 text-sm text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <a href="{{ route('expenses.index') }}" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-check mr-2"></i> Update Expense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
