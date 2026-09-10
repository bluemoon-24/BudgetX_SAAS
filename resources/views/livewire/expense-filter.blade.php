<div>
    <!-- Search & Filter Controls -->
    <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 shadow-soft border border-gray-100 mb-8 animate-fade-in-up">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Keyword Search -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Search</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search description..." class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-primary-500 focus:ring-primary-500 transition-colors bg-white/50">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                <select wire:model.live="selectedCategory" class="w-full py-2.5 px-4 text-sm rounded-xl border border-gray-200 focus:border-primary-500 focus:ring-primary-500 transition-colors bg-white/50">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">From Date</label>
                <input type="date" wire:model.live="dateFrom" class="w-full py-2.5 px-4 text-sm rounded-xl border border-gray-200 focus:border-primary-500 focus:ring-primary-500 transition-colors bg-white/50">
            </div>

            <!-- Date To -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">To Date</label>
                <input type="date" wire:model.live="dateTo" class="w-full py-2.5 px-4 text-sm rounded-xl border border-gray-200 focus:border-primary-500 focus:ring-primary-500 transition-colors bg-white/50">
            </div>
        </div>

        <div class="mt-6 pt-5 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="text-sm text-gray-600 font-medium flex items-center gap-2">
                <span class="p-1.5 bg-red-100 rounded text-red-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg></span>
                Total Filtered Spending: <span class="font-bold text-red-600 font-display text-lg tracking-tight">{{ auth()->user()?->formatCurrency($totalFiltered) ?? '$' . number_format($totalFiltered, 2) }}</span>
            </div>
            @if(!empty($search) || !empty($selectedCategory) || !empty($dateFrom) || !empty($dateTo))
                <button wire:click="resetFilters" class="text-sm font-semibold text-gray-500 hover:text-primary-600 transition flex items-center gap-1.5 bg-gray-50 hover:bg-primary-50 px-3 py-1.5 rounded-lg border border-gray-200 hover:border-primary-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> 
                    Reset Filters
                </button>
            @endif
        </div>
    </div>

    <!-- Expenses Table Card -->
    <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
        @if($expenses->count() > 0)
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-soft border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Amount</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($expenses as $expense)
                                <tr class="hover:bg-red-50/30 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        {{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            {{ $expense->category->name ?? 'General' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $expense->description ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 text-right">
                                        -{{ auth()->user()?->formatCurrency($expense->amount) ?? '$' . number_format($expense->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('expenses.edit', $expense) }}" class="text-primary-600 hover:text-primary-900 bg-primary-50 hover:bg-primary-100 p-2 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <button wire:click="deleteExpense({{ $expense->id }})" wire:confirm="Are you sure you want to delete this expense?" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Delete">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $expenses->links() }}
                </div>
            </div>
        @else
            <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-16 text-center border border-dashed border-gray-200 shadow-sm flex flex-col items-center">
                <div class="h-20 w-20 bg-red-50 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <svg class="h-10 w-10 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-display font-bold text-gray-900 mb-2">No expenses found</h3>
                <p class="text-gray-500 max-w-sm mb-8">No records match your selected search or filter criteria. Add your first expense to see where your money goes.</p>
                <a href="{{ route('expenses.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white shadow-md font-medium py-2.5 px-8 rounded-full transition-all hover:-translate-y-0.5 active:scale-95">
                    Add New Expense
                </a>
            </div>
        @endif
    </div>
</div>
