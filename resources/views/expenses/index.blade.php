<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800">💸 Expenses</h2>
            <a href="{{ route('expenses.create') }}" class="px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition">+ Add Expense</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm font-medium">✅ {{ session('success') }}</div>
            @endif

            {{-- Filters --}}
            <form method="GET" action="{{ route('expenses.index') }}" class="bg-white rounded-2xl shadow-premium p-5 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search description..." class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500 col-span-1 md:col-span-2" />
                    <select name="category_id" class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition">Filter</button>
                </div>
            </form>

            {{-- Table --}}
            <div class="bg-white rounded-2xl shadow-premium border border-gray-100 overflow-hidden">
                @if($expenses->count())
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($expenses as $expense)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $expense->description ?? '—' }}</td>
                            <td class="px-6 py-4"><span class="px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium">{{ $expense->category->name }}</span></td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $expense->date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right font-bold text-red-500">LKR {{ number_format($expense->amount, 2) }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('expenses.edit', $expense) }}" class="text-brand-600 hover:underline text-xs font-semibold">Edit</a>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('Delete this expense?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline text-xs font-semibold">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-sm font-semibold text-gray-600">Total</td>
                            <td class="px-6 py-3 text-right font-extrabold text-red-600">LKR {{ number_format($totalAmount, 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="px-6 py-4 border-t border-gray-100">{{ $expenses->links() }}</div>
                @else
                <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                    <span class="text-6xl mb-3">💸</span>
                    <p class="font-semibold text-lg">No expenses found.</p>
                    <a href="{{ route('expenses.create') }}" class="mt-3 text-sm text-brand-600 font-semibold hover:underline">Add your first expense →</a>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
