<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2 font-display">
                <i class="fa-solid fa-chart-line text-indigo-600"></i> Dashboard
            </h2>
            @if(!auth()->user()->hasRole('premium'))
                <a href="{{ route('subscribe') }}" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg text-sm font-bold shadow-lg shadow-indigo-500/30 hover:scale-105 transition-transform">
                    <i class="fa-solid fa-crown mr-1 text-yellow-300"></i> Upgrade to Premium
                </a>
            @else
                <span class="px-3 py-1 bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 rounded-full text-xs font-bold border border-indigo-200">
                    <i class="fa-solid fa-crown mr-1 text-indigo-600"></i> Premium Member
                </span>
            @endif
        </div>
    </x-slot>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-medium shadow-sm flex items-center gap-3">
                    <i class="fa-solid fa-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Skeleton Loading State (Alpine.js) --}}
            <template x-if="loading">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-pulse">
                    <div class="h-32 bg-slate-200 rounded-3xl"></div>
                    <div class="h-32 bg-slate-200 rounded-3xl"></div>
                    <div class="h-32 bg-slate-200 rounded-3xl"></div>
                </div>
            </template>

            {{-- Actual Content --}}
            <template x-if="!loading">
                <div class="space-y-8">
                    {{-- Stats Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Net Balance --}}
                        <div class="bg-gradient-to-br from-slate-900 to-indigo-950 text-white rounded-3xl p-8 shadow-xl shadow-slate-900/20 relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-2xl"></div>
                            <p class="text-indigo-200 text-sm font-bold uppercase tracking-widest mb-1 relative z-10">Net Balance</p>
                            <p class="text-4xl lg:text-5xl font-display font-extrabold relative z-10">LKR {{ number_format($netBalance, 2) }}</p>
                            <p class="text-indigo-300/70 text-xs mt-3 relative z-10"><i class="fa-regular fa-calendar mr-1"></i> {{ now()->format('F Y') }}</p>
                        </div>

                        {{-- Total Income --}}
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <p class="text-slate-500 text-sm font-bold uppercase tracking-widest">Total Income</p>
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-arrow-down"></i></div>
                                </div>
                                <p class="text-3xl font-display font-extrabold text-slate-800">LKR {{ number_format($totalIncome, 2) }}</p>
                            </div>
                            <a href="{{ route('incomes.create') }}" class="inline-block mt-4 text-sm text-emerald-600 font-bold hover:text-emerald-700 transition-colors"><i class="fa-solid fa-plus mr-1"></i> Add Income</a>
                        </div>

                        {{-- Total Expenses --}}
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <p class="text-slate-500 text-sm font-bold uppercase tracking-widest">Total Expenses</p>
                                    <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center"><i class="fa-solid fa-arrow-up"></i></div>
                                </div>
                                <p class="text-3xl font-display font-extrabold text-slate-800">LKR {{ number_format($totalExpenses, 2) }}</p>
                            </div>
                            <a href="{{ route('expenses.create') }}" class="inline-block mt-4 text-sm text-rose-600 font-bold hover:text-rose-700 transition-colors"><i class="fa-solid fa-plus mr-1"></i> Add Expense</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Charts (Premium preview or actual) --}}
                        <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                            <h3 class="font-display font-bold text-slate-800 text-xl mb-6">Income vs Expenses Overview</h3>
                            @if(auth()->user()->hasRole('premium'))
                                <div class="relative h-64 w-full">
                                    <canvas id="cashFlowChart"></canvas>
                                </div>
                            @else
                                <div class="relative h-64 w-full flex items-center justify-center bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                                    <div class="text-center p-6">
                                        <i class="fa-solid fa-chart-bar text-4xl text-slate-300 mb-4"></i>
                                        <h4 class="text-lg font-bold text-slate-700 mb-2">Advanced Analytics Locked</h4>
                                        <p class="text-sm text-slate-500 mb-4">Upgrade to Premium to visualize your financial trends and categorize spending.</p>
                                        <a href="{{ route('subscribe') }}" class="inline-block px-6 py-2 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800 transition">Upgrade Now</a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Quick Actions --}}
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                            <h3 class="font-display font-bold text-slate-800 text-xl mb-6">Quick Actions</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <a href="{{ route('expenses.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 rounded-2xl bg-rose-50 hover:bg-rose-100 transition text-rose-700 border border-rose-100 group">
                                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform"><i class="fa-solid fa-receipt"></i></div>
                                    <span class="text-xs font-bold text-center">Expense</span>
                                </a>
                                <a href="{{ route('incomes.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 rounded-2xl bg-emerald-50 hover:bg-emerald-100 transition text-emerald-700 border border-emerald-100 group">
                                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform"><i class="fa-solid fa-money-bill-wave"></i></div>
                                    <span class="text-xs font-bold text-center">Income</span>
                                </a>
                                <a href="{{ route('budgets.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 rounded-2xl bg-indigo-50 hover:bg-indigo-100 transition text-indigo-700 border border-indigo-100 group">
                                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform"><i class="fa-solid fa-wallet"></i></div>
                                    <span class="text-xs font-bold text-center">Budget</span>
                                </a>
                                <a href="{{ route('savings-goals.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 rounded-2xl bg-amber-50 hover:bg-amber-100 transition text-amber-700 border border-amber-100 group">
                                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform"><i class="fa-solid fa-bullseye"></i></div>
                                    <span class="text-xs font-bold text-center">Goal</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Recent Transactions & Savings Goals --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        {{-- Recent Expenses --}}
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-display font-bold text-slate-800 text-xl">Recent Transactions</h3>
                                <a href="{{ route('expenses.index') }}" class="text-sm text-indigo-600 font-bold hover:text-indigo-700 transition">View all <i class="fa-solid fa-arrow-right ml-1"></i></a>
                            </div>

                            @if($recentExpenses->count())
                            <div class="space-y-4">
                                @foreach($recentExpenses as $expense)
                                <div class="flex justify-between items-center p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-slate-100 transition">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm text-lg text-slate-500">
                                            <i class="fa-solid fa-tag"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800">{{ $expense->description ?? 'Expense' }}</p>
                                            <p class="text-xs text-slate-500 font-medium">{{ $expense->category->name }} &bull; {{ $expense->date->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <p class="font-display font-bold text-rose-600 text-lg">-LKR {{ number_format($expense->amount, 2) }}</p>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="flex flex-col items-center justify-center py-10 text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                                <i class="fa-solid fa-receipt text-5xl mb-4 text-slate-300"></i>
                                <p class="font-medium text-slate-600 mb-2">No transactions recorded yet.</p>
                                <a href="{{ route('expenses.create') }}" class="text-sm text-indigo-600 font-bold hover:underline">Add your first expense</a>
                            </div>
                            @endif
                        </div>

                        {{-- Savings Goals --}}
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-display font-bold text-slate-800 text-xl">Savings Goals</h3>
                                <a href="{{ route('savings-goals.index') }}" class="text-sm text-indigo-600 font-bold hover:text-indigo-700 transition">Manage <i class="fa-solid fa-arrow-right ml-1"></i></a>
                            </div>

                            @if($savingsGoals->count())
                            <div class="space-y-6">
                                @foreach($savingsGoals as $goal)
                                @php $pct = min(($goal->current_amount / max($goal->target_amount, 1)) * 100, 100); @endphp
                                <div class="group">
                                    <div class="flex justify-between items-end mb-2">
                                        <div>
                                            <p class="font-bold text-slate-800">{{ $goal->name }}</p>
                                            <p class="text-xs text-slate-500 font-medium mt-0.5">LKR {{ number_format($goal->current_amount, 2) }} saved</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-display font-bold text-indigo-600">{{ round($pct) }}%</p>
                                            <p class="text-xs text-slate-500 font-medium mt-0.5">of LKR {{ number_format($goal->target_amount, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                                        <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-1000 ease-out group-hover:brightness-110" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="flex flex-col items-center justify-center py-10 text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                                <i class="fa-solid fa-bullseye text-5xl mb-4 text-slate-300"></i>
                                <p class="font-medium text-slate-600 mb-2">No active savings goals.</p>
                                <a href="{{ route('savings-goals.create') }}" class="text-sm text-indigo-600 font-bold hover:underline">Create a new goal</a>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </template>
        </div>
    </div>

    @if(auth()->user()->hasRole('premium'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const ctx = document.getElementById('cashFlowChart');
                if(ctx) {
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                            datasets: [{
                                label: 'Income',
                                data: [4000, 4200, 4100, 4500, 4300, {{ $totalIncome }}],
                                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                                borderRadius: 4,
                            }, {
                                label: 'Expenses',
                                data: [2500, 2800, 2400, 3100, 2900, {{ $totalExpenses }}],
                                backgroundColor: 'rgba(244, 63, 94, 0.8)',
                                borderRadius: 4,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8 } }
                            },
                            scales: {
                                y: { beginAtZero: true, grid: { borderDash: [4, 4] } },
                                x: { grid: { display: false } }
                            }
                        }
                    });
                }
            }, 850);
        });
    </script>
    @endif
</x-app-layout>