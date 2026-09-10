<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight font-display flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-purple-600"></i> Premium Analytics
                </h2>
                <p class="text-xs text-slate-500 mt-1">Deep insights, rule-based alerts, and long-term financial trends.</p>
            </div>
            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-glow">
                <i class="fa-solid fa-crown mr-1.5 text-yellow-300"></i> Premium Member
            </span>
        </div>
    </x-slot>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        $monthlyExpensesData = json_decode($monthlyExpenses, true) ?? [];
        $monthlyIncomesData = json_decode($monthlyIncomes, true) ?? [];
        $categoryBreakdownData = json_decode($categoryBreakdown, true) ?? [];
        $hasExpenseData = !empty($monthlyExpensesData);
        $hasIncomeData = !empty($monthlyIncomesData);
        $hasCategoryData = !empty($categoryBreakdownData);
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            @php
                $summary = $summary ?? [];
                $totalIncome = (float) ($summary['total_income'] ?? 0);
                $totalExpenses = (float) ($summary['total_expenses'] ?? 0);
                $netCashFlow = (float) ($summary['net_cash_flow'] ?? 0);
                $savingsRate = (float) ($summary['savings_rate'] ?? 0);
                $avgMonthlyIncome = (float) ($summary['avg_monthly_income'] ?? 0);
                $avgMonthlyExpense = (float) ($summary['avg_monthly_expense'] ?? 0);
                $topCategory = $summary['top_category'] ?? null;
                $topCategoryTotal = (float) ($summary['top_category_total'] ?? 0);
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
                <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Income</p>
                        <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-arrow-trend-up"></i></span>
                    </div>
                    <p class="text-2xl font-extrabold text-slate-800">{{ auth()->user()->formatCurrency($totalIncome) }}</p>
                </div>

                <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Spend</p>
                        <span class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center"><i class="fa-solid fa-arrow-trend-down"></i></span>
                    </div>
                    <p class="text-2xl font-extrabold text-slate-800">{{ auth()->user()->formatCurrency($totalExpenses) }}</p>
                </div>

                <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Net Cash Flow</p>
                        <span class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center"><i class="fa-solid fa-wallet"></i></span>
                    </div>
                    <p class="text-2xl font-extrabold {{ $netCashFlow >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ auth()->user()->formatCurrency($netCashFlow) }}</p>
                </div>

                <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Savings Rate</p>
                        <span class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center"><i class="fa-solid fa-piggy-bank"></i></span>
                    </div>
                    <p class="text-2xl font-extrabold text-slate-800">{{ number_format($savingsRate, 1) }}%</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Avg. Monthly Income</p>
                    <p class="mt-2 text-xl font-bold text-slate-800">{{ auth()->user()->formatCurrency($avgMonthlyIncome) }}</p>
                </div>
                <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Avg. Monthly Spend</p>
                    <p class="mt-2 text-xl font-bold text-slate-800">{{ auth()->user()->formatCurrency($avgMonthlyExpense) }}</p>
                </div>
                <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Top Category</p>
                    <p class="mt-2 text-xl font-bold text-slate-800">{{ $topCategory ?: 'N/A' }}</p>
                    @if($topCategory)
                        <p class="text-xs text-slate-500 mt-1">{{ auth()->user()->formatCurrency($topCategoryTotal) }}</p>
                    @endif
                </div>
            </div>

            @if(!empty($alerts))
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold font-display text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> Overspending Alerts
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                A category is flagged when current-month spending exceeds 150% of its 6-month historical average.
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($alerts as $alert)
                            <div class="bg-white p-6 border-l-4 border-rose-500 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start">
                                    <h4 class="text-base font-bold text-slate-800">{{ $alert['category'] }}</h4>
                                    <span class="text-xs font-bold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-full border border-rose-100">
                                        +{{ $alert['pct_over'] }}% over
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-3 font-medium">
                                    Current: <strong class="text-rose-600 font-bold">{{ auth()->user()->formatCurrency($alert['current_spend']) }}</strong>
                                    <span class="text-slate-300 mx-1">|</span> Avg: {{ auth()->user()->formatCurrency($alert['avg_spend']) }}
                                </p>
                                <div class="mt-4 pt-3 border-t border-slate-100 flex justify-between items-center text-xs text-slate-400">
                                    <span>Excess spend:</span>
                                    <span class="font-bold text-rose-600">+{{ auth()->user()->formatCurrency($alert['excess']) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="p-6 bg-gradient-to-r from-emerald-50 to-emerald-100/50 border border-emerald-200 rounded-3xl text-sm text-emerald-800 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-200/60 flex items-center justify-center text-emerald-700 text-xl shrink-0">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-emerald-900 font-display">Spending Under Control</h4>
                        <p class="text-xs text-emerald-700 mt-0.5 font-medium">
                            No overspending alerts triggered this month. Your category spending is well within your 6-month historical baseline.
                        </p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @if(!empty(json_decode($monthlyExpenses, true) ?? []) || !empty(json_decode($monthlyIncomes, true) ?? []))
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold font-display text-slate-800 mb-6">Monthly Cash Flow</h3>
                        <div class="relative h-64 w-full">
                            <canvas id="monthlyCashFlowChart"></canvas>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-dashed border-slate-200 flex items-center justify-center min-h-[240px]">
                        <div class="text-center">
                            <i class="fa-solid fa-chart-line text-slate-300 text-3xl mb-3"></i>
                            <p class="text-sm font-semibold text-slate-600">No transaction history yet</p>
                            <p class="text-xs text-slate-400 mt-1">Add income and expense entries to generate this chart.</p>
                        </div>
                    </div>
                @endif

                @if(!empty(json_decode($monthlyExpenses, true) ?? []) || !empty(json_decode($monthlyIncomes, true) ?? []))
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold font-display text-slate-800 mb-6">Income vs Expense Comparison</h3>
                        <div class="relative h-64 w-full">
                            <canvas id="incomeVsExpenseChart"></canvas>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-dashed border-slate-200 flex items-center justify-center min-h-[240px]">
                        <div class="text-center">
                            <i class="fa-solid fa-chart-column text-slate-300 text-3xl mb-3"></i>
                            <p class="text-sm font-semibold text-slate-600">No income or expense data yet</p>
                            <p class="text-xs text-slate-400 mt-1">Once you add transactions, this comparison will appear.</p>
                        </div>
                    </div>
                @endif
            </div>

            @if(!empty(json_decode($categoryBreakdown, true) ?? []))
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold font-display text-slate-800 mb-6">Cumulative Spend by Category</h3>
                    <div class="relative h-72 w-full">
                        <canvas id="categoryBarChart"></canvas>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-dashed border-slate-200 flex items-center justify-center min-h-[220px]">
                    <div class="text-center">
                        <i class="fa-solid fa-chart-simple text-slate-300 text-3xl mb-3"></i>
                        <p class="text-sm font-semibold text-slate-600">No category spending data yet</p>
                        <p class="text-xs text-slate-400 mt-1">Add expense entries to generate your category breakdown.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const currencyCode = '{{ auth()->user()?->currencyCode() ?? 'USD' }}';
            const monthlyExpenses = {!! $monthlyExpenses !!};
            const monthlyIncomes = {!! $monthlyIncomes !!};
            const categoryBreakdown = {!! $categoryBreakdown !!};
            const monthlyTrend = {!! $monthlyTrend ?? '[]' !!};

            const trendLabels = monthlyTrend.map(r => r.month_label);
            const trendIncome = monthlyTrend.map(r => parseFloat(r.income || 0));
            const trendExpense = monthlyTrend.map(r => parseFloat(r.expense || 0));
            const netFlow = monthlyTrend.map(r => parseFloat(r.net || 0));

            const ctxCash = document.getElementById('monthlyCashFlowChart');
            if (ctxCash && monthlyTrend.length) {
                new Chart(ctxCash, {
                    type: 'line',
                    data: {
                        labels: trendLabels,
                        datasets: [
                            {
                                label: 'Income',
                                data: trendIncome,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.12)',
                                borderWidth: 2.5,
                                fill: true,
                                tension: 0.35
                            },
                            {
                                label: 'Expenses',
                                data: trendExpense,
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.10)',
                                borderWidth: 2.5,
                                fill: true,
                                tension: 0.35
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'top' } },
                        scales: {
                            y: { beginAtZero: false, grid: { color: '#f1f5f9' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            const expenseLabels = monthlyExpenses.map(r => r.month_label);
            const expenseData = monthlyExpenses.map(r => parseFloat(r.total));
            const incomeMap = {};
            monthlyIncomes.forEach(r => { incomeMap[r.month_key] = parseFloat(r.total); });
            const alignedIncomes = monthlyExpenses.map(r => incomeMap[r.month_key] ?? 0);

            const ctx2 = document.getElementById('incomeVsExpenseChart');
            if (ctx2 && (monthlyExpenses.length || monthlyIncomes.length)) {
                new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: expenseLabels.length ? expenseLabels : (monthlyIncomes.map(r => r.month_label) || []),
                        datasets: [
                            {
                                label: 'Income',
                                data: alignedIncomes.length ? alignedIncomes : monthlyIncomes.map(r => parseFloat(r.total)),
                                backgroundColor: '#10b981',
                                borderRadius: 6
                            },
                            {
                                label: 'Expenses',
                                data: expenseData.length ? expenseData : monthlyExpenses.map(r => parseFloat(r.total)),
                                backgroundColor: '#f43f5e',
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'top' } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            const catLabels = categoryBreakdown.map(r => r.category_name);
            const catTotals = categoryBreakdown.map(r => parseFloat(r.total));

            const ctx3 = document.getElementById('categoryBarChart');
            if (ctx3 && categoryBreakdown.length) {
                new Chart(ctx3, {
                    type: 'bar',
                    data: {
                        labels: catLabels,
                        datasets: [{
                            label: 'Total Spend (' + currencyCode + ')',
                            data: catTotals,
                            backgroundColor: ['#6366f1', '#8b5cf6', '#ec4899', '#f97316', '#10b981', '#3b82f6', '#f59e0b', '#14b8a6', '#94a3b8'],
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                            y: { grid: { display: false } }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
