<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">✏️ Edit Expense</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-premium border border-gray-100 p-8">
                <form action="{{ route('expenses.update', $expense) }}" method="POST" class="space-y-5">
                    @csrf @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                        <input type="text" name="description" value="{{ old('description', $expense->description) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-brand-500 focus:border-brand-500" />
                        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Amount *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">LKR</span>
                            <input type="number" name="amount" value="{{ old('amount', $expense->amount) }}" step="0.01" min="0.01" class="w-full border border-gray-200 rounded-xl pl-12 pr-4 py-2.5 text-sm focus:ring-brand-500 focus:border-brand-500" required />
                        </div>
                        @error('amount')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Category *</label>
                        <select name="category_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-brand-500 focus:border-brand-500" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id', $expense->category_id) == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Date *</label>
                        <input type="date" name="date" value="{{ old('date', $expense->date->format('Y-m-d')) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-brand-500 focus:border-brand-500" required />
                        @error('date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-brand-600 text-white rounded-xl font-semibold hover:bg-brand-700 transition text-sm">Update Expense</button>
                        <a href="{{ route('expenses.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-xl font-semibold hover:bg-gray-50 transition text-sm">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
