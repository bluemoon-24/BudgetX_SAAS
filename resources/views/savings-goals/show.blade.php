<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('savings-goals.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 mb-1 inline-block">&larr; Back to Goals</a>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2 font-display">
                    <i class="fa-solid fa-bullseye text-amber-500"></i> {{ $savingsGoal->name }}
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('savings-goals.edit', $savingsGoal) }}" class="px-4 py-2 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-50 transition">
                    <i class="fa-solid fa-pen mr-1"></i> Edit
                </a>
                <form method="POST" action="{{ route('savings-goals.destroy', $savingsGoal) }}" onsubmit="return confirm('Delete this goal and all contributions?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 border border-rose-200 text-rose-600 rounded-xl text-xs font-bold hover:bg-rose-50 transition">
                        <i class="fa-solid fa-trash mr-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-center gap-3">
                    <i class="fa-solid fa-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif

            @php
                $paid = $savingsGoal->payments->sum('amount');
                $target = $savingsGoal->target_amount;
                $pct = $target > 0 ? min(round(($paid / $target) * 100), 100) : 0;
                $remaining = max($target - $paid, 0);

                if ($pct >= 100) {
                    $badgeText = 'Achieved! 🎉';
                    $badgeClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                    $barColor = 'from-emerald-500 to-teal-500';
                } elseif ($pct >= 75) {
                    $badgeText = 'Almost There!';
                    $badgeClass = 'bg-indigo-100 text-indigo-800 border-indigo-200';
                    $barColor = 'from-indigo-500 to-purple-500';
                } elseif ($pct >= 50) {
                    $badgeText = 'Halfway There!';
                    $badgeClass = 'bg-amber-100 text-amber-800 border-amber-200';
                    $barColor = 'from-amber-500 to-yellow-500';
                } else {
                    $badgeText = 'Making Progress';
                    $badgeClass = 'bg-slate-100 text-slate-700 border-slate-200';
                    $barColor = 'from-indigo-400 to-indigo-600';
                }
            @endphp

            <!-- Goal Milestone Overview Card -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                            {{ $badgeText }}
                        </span>
                        @if($savingsGoal->target_date)
                            <p class="text-xs text-slate-400 mt-2"><i class="fa-regular fa-calendar mr-1"></i> Target Date: {{ \Carbon\Carbon::parse($savingsGoal->target_date)->format('M d, Y') }}</p>
                        @endif
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-3xl font-extrabold font-display text-slate-800">{{ $pct }}%</span>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Completed</p>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-slate-100 rounded-full h-3.5 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r {{ $barColor }} transition-all duration-700" style="width: {{ $pct }}%"></div>
                </div>

                <!-- 3 Metric Blocks -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                    <div class="bg-slate-50/70 p-4 rounded-2xl border border-slate-100 text-center">
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Target Goal</p>
                        <p class="text-xl font-bold font-display text-slate-800 mt-1">{{ auth()->user()?->formatCurrency($target) ?? '$' . number_format($target, 2) }}</p>
                    </div>
                    <div class="bg-emerald-50/70 p-4 rounded-2xl border border-emerald-100 text-center">
                        <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider">Total Contributed</p>
                        <p class="text-xl font-bold font-display text-emerald-600 mt-1">{{ auth()->user()?->formatCurrency($paid) ?? '$' . number_format($paid, 2) }}</p>
                    </div>
                    <div class="bg-slate-50/70 p-4 rounded-2xl border border-slate-100 text-center">
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Remaining</p>
                        <p class="text-xl font-bold font-display text-slate-800 mt-1">{{ auth()->user()?->formatCurrency($remaining) ?? '$' . number_format($remaining, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Record Contribution Form -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold font-display text-slate-800 mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-indigo-600"></i> Record a Contribution
                </h3>
                <p class="text-xs text-slate-500 mb-6">Add funds saved towards this target to update your progress bar.</p>

                <form method="POST" action="{{ route('savings-goals.payments.store', $savingsGoal) }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Amount ({{ auth()->user()?->currencyCode() ?? 'USD' }})</label>
                            <input type="number" step="0.01" name="amount" required placeholder="5000.00" class="w-full text-sm rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Contribution Date</label>
                            <input type="date" name="payment_date" required value="{{ date('Y-m-d') }}" class="w-full text-sm rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Note (Optional)</label>
                            <input type="text" name="note" placeholder="Monthly savings deposit" class="w-full text-sm rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:bg-indigo-700 transition">
                            Save Contribution
                        </button>
                    </div>
                </form>
            </div>

            <!-- Payment Contributions Ledger -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-display font-bold text-slate-800 text-base">Payment History</h3>
                    <span class="text-xs font-bold text-slate-400">{{ $savingsGoal->payments->count() }} contributions</span>
                </div>

                @if($savingsGoal->payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50/80">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Note</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($savingsGoal->payments as $payment)
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-500">
                                            {{ $payment->note ?: '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-emerald-600 font-display">
                                            +{{ auth()->user()?->formatCurrency($payment->amount) ?? '$' . number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <form method="POST" action="{{ route('savings-goals.payments.destroy', [$savingsGoal, $payment]) }}" onsubmit="return confirm('Delete this payment contribution?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-slate-100 inline-flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-10 text-center text-slate-400 text-sm">
                        No payments have been recorded towards this goal yet.
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
