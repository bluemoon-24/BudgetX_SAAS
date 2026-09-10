<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            <i class="fa-solid fa-bullseye text-indigo-600"></i> Goal Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $budget->category->name ?? 'Goal' }}</h3>
                <p class="text-3xl font-extrabold text-indigo-600 mb-6" style="font-family: 'Outfit', sans-serif;">{{ auth()->user()?->formatCurrency($budget->amount) ?? '$' . number_format($budget->amount, 2) }}</p>
                <div class="flex gap-3">
                    <a href="{{ route('budgets.edit', $budget) }}" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition"><i class="fa-solid fa-pen mr-2"></i> Edit</a>
                    <a href="{{ route('budgets.index') }}" class="px-6 py-3 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">Back</a>
                </div>
            </div>

            <!-- Collaborators Section -->
            <div class="mt-8 bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                @php
                    $totalContributions = $budget->total_contributions;
                    $remaining = max($budget->amount - $totalContributions, 0);
                @endphp

                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Contribution Tracker</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total contributed</p>
                        <p class="mt-2 text-xl font-bold text-emerald-600">{{ auth()->user()?->formatCurrency($totalContributions) ?? '$' . number_format($totalContributions, 2) }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Budget limit</p>
                        <p class="mt-2 text-xl font-bold text-slate-800">{{ auth()->user()?->formatCurrency($budget->amount) ?? '$' . number_format($budget->amount, 2) }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Remaining</p>
                        <p class="mt-2 text-xl font-bold text-slate-800">{{ auth()->user()?->formatCurrency($remaining) ?? '$' . number_format($remaining, 2) }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('budgets.contributions.store', $budget) }}" class="space-y-4 mb-8">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Amount ({{ auth()->user()?->currencyCode() ?? 'USD' }})</label>
                            <input type="number" step="0.01" name="amount" required placeholder="250.00" class="w-full text-sm rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Contribution Date</label>
                            <input type="date" name="contribution_date" required value="{{ date('Y-m-d') }}" class="w-full text-sm rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1">Note (Optional)</label>
                            <input type="text" name="note" placeholder="Team contribution" class="w-full text-sm rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition">Add Contribution</button>
                    </div>
                </form>

                @if($budget->contributions->count() > 0)
                    <div class="overflow-x-auto border border-slate-100 rounded-2xl">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Contributor</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Note</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach($budget->contributions()->latest()->get() as $contribution)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-slate-600">{{ \Carbon\Carbon::parse($contribution->contribution_date)->format('M d, Y') }}</td>
                                        <td class="px-4 py-3 text-sm text-slate-700">{{ $contribution->user->name ?? 'Unknown user' }}</td>
                                        <td class="px-4 py-3 text-sm text-slate-500">{{ $contribution->note ?: '—' }}</td>
                                        <td class="px-4 py-3 text-right text-sm font-bold text-emerald-600">+{{ auth()->user()?->formatCurrency($contribution->amount) ?? '$' . number_format($contribution->amount, 2) }}</td>
                                        <td class="px-4 py-3 text-right">
                                            @if(auth()->id() === $contribution->user_id || auth()->id() === $budget->user_id)
                                                <form method="POST" action="{{ route('budgets.contributions.destroy', [$budget, $contribution]) }}" onsubmit="return confirm('Delete this contribution?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs font-semibold">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-slate-500 pb-2">No contributions have been added yet.</p>
                @endif
            </div>

            <div class="mt-8 bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Collaborators</h3>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm font-medium">
                        {{ session('error') }}
                    </div>
                @endif
                <x-validation-errors class="mb-4" />

                @if($budget->collaborators->count() > 0)
                    <div class="space-y-3 mb-8">
                        @foreach($budget->collaborators as $collab)
                            <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs uppercase">
                                        {{ substr($collab->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $collab->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $collab->email }}</p>
                                    </div>
                                </div>
                                @if(auth()->id() === $budget->user_id)
                                    <form method="POST" action="{{ route('budgets.collaborators.destroy', [$budget, $collab]) }}" onsubmit="return confirm('Remove this collaborator?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 text-sm font-semibold transition">Remove</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500 mb-8 pb-8 border-b border-slate-100">No one else has access to this goal yet.</p>
                @endif

                @if(auth()->id() === $budget->user_id)
                    @if(auth()->user()->hasRole('premium') || auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('budgets.collaborators.store', $budget) }}">
                            @csrf
                            <h4 class="text-sm font-bold text-slate-700 mb-2">Invite a Collaborator</h4>
                            <p class="text-xs text-slate-500 mb-4">Enter the email address of a registered BudgetX user to share this goal with them.</p>
                            <div class="flex gap-3">
                                <input type="email" name="email" placeholder="friend@example.com" class="flex-1 rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition">Invite</button>
                            </div>
                        </form>
                    @else
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100/50 text-center">
                            <i class="fa-solid fa-crown text-yellow-500 text-3xl mb-3"></i>
                            <h4 class="text-lg font-bold text-slate-800 mb-2">Unlock Shared Goals</h4>
                            <p class="text-sm text-slate-600 mb-4">Upgrade to Premium to invite friends or family to collaborate on this goal with you!</p>
                            <a href="{{ route('subscribe') }}" class="inline-block px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">Upgrade Now</a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
