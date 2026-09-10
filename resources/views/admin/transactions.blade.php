<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            <i class="fa-solid fa-money-bill-transfer text-indigo-600"></i> All Transactions
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($expenses as $expense)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">{{ $expense->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $expense->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-rose-500">{{ auth()->user()?->formatCurrency($expense->amount) ?? '$' . number_format($expense->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ Str::limit($expense->description, 30) ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">{{ $expense->date->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-receipt text-3xl mb-2 text-slate-300 block"></i>
                                No transactions found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-slate-100">{{ $expenses->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
