<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            <i class="fa-solid fa-arrow-trend-up text-emerald-500"></i> Add Income
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <x-validation-errors class="mb-4" />
                <form method="POST" action="{{ route('incomes.store') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <x-label for="amount" value="Income Amount (LKR)" />
                            <x-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" required autofocus />
                        </div>
                        <div>
                            <x-label for="category_id" value="Source" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" required>
                                <option value="">Select a source</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-label for="description" value="Description (Optional)" />
                            <x-input id="description" name="description" type="text" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-label for="date" value="Date" />
                            <x-input id="date" name="date" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                        </div>
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">Cancel</a>
                            <button type="submit" class="px-6 py-3 bg-emerald-500 text-white rounded-xl font-bold hover:bg-emerald-600 transition shadow-lg shadow-emerald-500/20"><i class="fa-solid fa-check mr-2"></i> Save Income</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
