<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            <i class="fa-solid fa-bullseye text-indigo-600"></i> Create Goal
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <x-validation-errors class="mb-4" />
                <form method="POST" action="{{ route('budgets.store') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <x-label for="category_id" value="Category" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-label for="amount" value="Goal Limit (LKR)" />
                            <x-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-label for="period" value="Period" />
                            <select id="period" name="period" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" required>
                                <option value="monthly">Monthly</option>
                                <option value="weekly">Weekly</option>
                                <option value="yearly">Yearly</option>
                                <option value="daily">Daily</option>
                            </select>
                        </div>
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('budgets.index') }}" class="px-6 py-3 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">Cancel</a>
                            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20"><i class="fa-solid fa-check mr-2"></i> Create Goal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
