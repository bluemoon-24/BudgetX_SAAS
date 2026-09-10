<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center animate-fade-in-up">
            <div>
                <h1 class="text-3xl font-display font-bold text-gray-900 tracking-tight">Dashboard</h1>
                <div class="text-sm text-gray-500 mt-1">Welcome back, {{ auth()->user()->name }}. Here is your financial overview.</div>
            </div>
            @if(auth()->user()->hasRole('premium'))
                <span class="mt-4 sm:mt-0 px-3.5 py-1.5 bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 rounded-full text-xs font-bold border border-indigo-200 flex items-center gap-1.5">
                    <i class="fa-solid fa-crown text-yellow-500"></i> Premium Active
                </span>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            
            {{-- Premium Promotion Banner for Basic Users --}}
            @if(!auth()->user()->hasRole('premium'))
                <div class="bg-gradient-to-r from-primary-600 to-secondary-600 rounded-2xl shadow-glow p-8 mb-8 text-white flex flex-col sm:flex-row justify-between items-center transform transition-all duration-300 hover:-translate-y-1 animate-fade-in-up relative overflow-hidden" style="animation-delay: 0.1s;">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
                    <div class="relative z-10">
                        <h2 class="text-xl font-display font-bold flex items-center gap-3">
                            <svg class="w-6 h-6 text-yellow-300 drop-shadow-md" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            Unlock Premium Analytics
                        </h2>
                        <p class="text-primary-50 text-sm mt-2 max-w-lg">Get deeper insights, custom reports, and shared financial goals to accelerate your financial freedom.</p>
                    </div>
                    <a href="{{ route('subscribe') }}" class="mt-6 sm:mt-0 relative z-10 inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-primary-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all hover:scale-105 active:scale-95">
                        Upgrade Now
                    </a>
                </div>
            @endif

            <!-- Key Metrics -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-gray-100 shadow-soft hover:shadow-glass hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-primary-50 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -mr-12 -mt-12"></div>
                    <div class="relative z-10">
                        <h3 class="text-sm font-semibold text-gray-500 tracking-wide flex items-center gap-2 uppercase">
                            <div class="p-1.5 bg-primary-100 rounded-lg text-primary-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            Balance
                        </h3>
                        <p class="mt-4 text-4xl font-display font-bold {{ $netBalance >= 0 ? 'text-gray-900' : 'text-red-600' }} tracking-tight group-hover:scale-105 transform origin-left transition-transform duration-300">
                            {{ auth()->user()->formatCurrency($netBalance) }}
                        </p>
                    </div>
                </div>
                
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-gray-100 shadow-soft hover:shadow-glass hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -mr-12 -mt-12"></div>
                    <div class="relative z-10">
                        <h3 class="text-sm font-semibold text-gray-500 tracking-wide flex items-center gap-2 uppercase">
                            <div class="p-1.5 bg-green-100 rounded-lg text-green-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            Income
                        </h3>
                        <p class="mt-4 text-4xl font-display font-bold text-green-600 tracking-tight group-hover:scale-105 transform origin-left transition-transform duration-300">
                            {{ auth()->user()->formatCurrency($totalIncome) }}
                        </p>
                    </div>
                </div>
                
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-gray-100 shadow-soft hover:shadow-glass hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-red-50 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -mr-12 -mt-12"></div>
                    <div class="relative z-10">
                        <h3 class="text-sm font-semibold text-gray-500 tracking-wide flex items-center gap-2 uppercase">
                            <div class="p-1.5 bg-red-100 rounded-lg text-red-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                            </div>
                            Expenses
                        </h3>
                        <p class="mt-4 text-4xl font-display font-bold text-red-600 tracking-tight group-hover:scale-105 transform origin-left transition-transform duration-300">
                            {{ auth()->user()->formatCurrency($totalExpenses) }}
                        </p>
                    </div>
                </div>
                
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-gray-100 shadow-soft hover:shadow-glass hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-secondary-50 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -mr-12 -mt-12"></div>
                    <div class="relative z-10">
                        <h3 class="text-sm font-semibold text-gray-500 tracking-wide flex items-center gap-2 uppercase">
                            <div class="p-1.5 bg-secondary-100 rounded-lg text-secondary-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            </div>
                            Goals
                        </h3>
                        <p class="mt-4 text-4xl font-display font-bold text-gray-900 tracking-tight group-hover:scale-105 transform origin-left transition-transform duration-300">
                            {{ $completedGoals }} <span class="text-lg font-normal text-gray-400">/ {{ $totalGoals }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 animate-fade-in-up" style="animation-delay: 0.3s;">
                <!-- Chart Section -->
                <div class="lg:col-span-2 bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-gray-100 shadow-soft">
                    <h3 class="text-lg font-display font-bold text-gray-900 mb-6">Expense Categories</h3>
                    @if($totalExpenses > 0 && count($categoryBreakdown) > 0)
                        <div class="relative h-72 w-full flex justify-center">
                            <canvas id="expenseChart"></canvas>
                        </div>
                    @else
                        <div class="h-64 flex flex-col items-center justify-center text-gray-500 bg-gray-50/50 rounded-xl border border-dashed border-gray-200">
                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            <p class="text-sm font-medium">No expenses to display yet.</p>
                        </div>
                    @endif
                </div>

                <!-- Active Goals -->
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-gray-100 shadow-soft flex flex-col">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-display font-bold text-gray-900">Active Goals</h3>
                        <a href="{{ route('savings-goals.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors bg-primary-50 px-3 py-1 rounded-full">View All</a>
                    </div>
                    
                    @if(count($activeGoals) === 0)
                        <div class="text-center py-12 text-gray-500 bg-gray-50/50 rounded-xl border border-dashed border-gray-200 flex-grow flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            <p class="text-sm font-medium">You have no active goals.</p>
                            <a href="{{ route('savings-goals.create') }}" class="mt-4 bg-primary-600 hover:bg-primary-700 text-white shadow-md text-xs py-2 px-4 rounded-full transition-colors">Set a Goal</a>
                        </div>
                    @else
                        <div class="space-y-6 flex-grow">
                            @foreach($activeGoals as $goal)
                                <div class="group">
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="font-medium text-gray-900 truncate" title="{{ $goal['name'] }}">
                                            <a href="{{ route('savings-goals.show', $goal['id']) }}" class="hover:text-primary-600 transition-colors">{{ $goal['name'] }}</a>
                                        </span>
                                        <span class="text-primary-600 font-bold">{{ $goal['progress_percentage'] }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-primary-400 to-secondary-500 h-2.5 rounded-full transform origin-left transition-transform duration-1000 group-hover:scale-x-105" style="width: {{ $goal['progress_percentage'] }}%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs mt-2 text-gray-500 font-medium">
                                        <span class="text-gray-700">{{ auth()->user()->formatCurrency($goal['total_paid']) }}</span>
                                        <span>Target: {{ auth()->user()->formatCurrency($goal['target_amount']) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in-up" style="animation-delay: 0.4s;">
                
                <!-- Recent Income -->
                <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-gray-100 shadow-soft overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <h3 class="text-lg font-display font-bold text-gray-900 flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            Recent Income
                        </h3>
                        <a href="{{ route('incomes.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors bg-primary-50 px-3 py-1 rounded-full">View All</a>
                    </div>
                    @if(count($recentIncomes) === 0)
                        <div class="p-8 text-center text-gray-500 text-sm">No recent income.</div>
                    @else
                        <ul class="divide-y divide-gray-50">
                            @foreach($recentIncomes as $inc)
                                <li class="px-6 py-4 flex justify-between items-center hover:bg-gray-50/50 transition-colors group cursor-pointer">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $inc->category->name ?? 'General Income' }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5 font-medium">{{ \Carbon\Carbon::parse($inc->date)->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-sm font-bold text-green-600 bg-green-50 px-3 py-1 rounded-lg">
                                        +{{ auth()->user()->formatCurrency($inc->amount) }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Recent Expenses -->
                <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-gray-100 shadow-soft overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <h3 class="text-lg font-display font-bold text-gray-900 flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-red-500"></div>
                            Recent Expenses
                        </h3>
                        <a href="{{ route('expenses.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors bg-primary-50 px-3 py-1 rounded-full">View All</a>
                    </div>
                    @if(count($recentExpenses) === 0)
                        <div class="p-8 text-center text-gray-500 text-sm">No recent expenses.</div>
                    @else
                        <ul class="divide-y divide-gray-50">
                            @foreach($recentExpenses as $exp)
                                <li class="px-6 py-4 flex justify-between items-center hover:bg-gray-50/50 transition-colors group cursor-pointer">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-600 group-hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $exp->category->name ?? 'General Expense' }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5 font-medium">{{ \Carbon\Carbon::parse($exp->date)->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-sm font-bold text-red-600 bg-red-50 px-3 py-1 rounded-lg">
                                        -{{ auth()->user()->formatCurrency($exp->amount) }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>

        </div>
    </div>

    @if($totalExpenses > 0 && count($categoryBreakdown) > 0)
    <!-- Load Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const breakdownData = @json($categoryBreakdown);
        
        if (breakdownData.length > 0 && document.getElementById('expenseChart')) {
            const labels = breakdownData.map(item => item.category_name);
            const data = breakdownData.map(item => parseFloat(item.total));
            
            // Premium brand colors matching Tailwind config
            const colors = [
                '#5380aa', // Main Blue
                '#f4a54a', // Orange/Gold
                '#759dc1', // Lighter Blue
                '#f8c67f', // Lighter Orange
                '#355375', // Darker Blue
                '#e16e16', // Darker Orange
                '#a5bed7', // Very light blue
                '#bb5315'  // Very dark orange
            ];

            const ctx = document.getElementById('expenseChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors.slice(0, data.length),
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: window.innerWidth < 640 ? 'bottom' : 'right',
                            labels: {
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 13,
                                    weight: '500'
                                },
                                usePointStyle: true,
                                padding: 24,
                                color: '#374151'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleFont: {
                                family: "'Inter', sans-serif",
                                size: 13
                            },
                            bodyFont: {
                                family: "'Inter', sans-serif",
                                size: 14,
                                weight: 'bold'
                            },
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += currencyCode + ' ' + context.parsed.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    cutout: '75%'
                }
            });
        }
    });
    </script>
    @endif
</x-app-layout>