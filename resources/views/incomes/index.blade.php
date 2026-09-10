<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2 font-display">
                <i class="fa-solid fa-wallet text-emerald-500"></i> Income Records
            </h2>
            <a href="{{ route('incomes.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-xs"></i> Add Income
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-center gap-3">
                    <i class="fa-solid fa-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                @if($incomes->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50/80">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Source</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($incomes as $income)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 font-medium">
                                        {{ \Carbon\Carbon::parse($income->date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            <i class="fa-solid fa-tag mr-1 text-[10px]"></i> {{ $income->category->name ?? 'Salary' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-700 font-medium">
                                        {{ $income->description ?: '—' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600 text-right font-display">
                                        +{{ auth()->user()->formatCurrency($income->amount) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('incomes.edit', $income) }}" class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-emerald-100 hover:text-emerald-700 transition" title="Edit">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </a>
                                            <form method="POST" action="{{ route('incomes.destroy', $income) }}" onsubmit="return confirm('Delete this income record?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition" title="Delete">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(method_exists($incomes, 'links'))
                        <div class="px-6 py-4 border-t border-slate-100">{{ $incomes->links() }}</div>
                    @endif
                @else
                    <div class="py-16 text-center text-slate-500 bg-slate-50/50">
                        <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 text-2xl">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 mb-1 font-display">No income entries found</h3>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto mb-6">Record your salary, freelance earnings, or investment returns to calculate your net savings.</p>
                        <a href="{{ route('incomes.create') }}" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 shadow-sm transition">
                            <i class="fa-solid fa-plus mr-1.5"></i> Add First Income
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
