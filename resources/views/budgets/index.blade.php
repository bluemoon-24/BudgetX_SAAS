<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2 font-display">
                    <i class="fa-solid fa-users text-indigo-600"></i> Shared Budgets
                </h2>
                <p class="text-xs text-slate-500 mt-1">Set spending thresholds and invite collaborators to track collective budgets.</p>
            </div>
            <a href="{{ route('budgets.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 hover:bg-indigo-700 transition flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-xs"></i> New Shared Budget
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
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i> {{ session('error') }}
                    @if(!auth()->user()->hasRole('premium'))
                        <a href="{{ route('subscribe') }}" class="ml-auto px-4 py-1.5 bg-rose-600 text-white rounded-lg text-xs font-bold hover:bg-rose-700 transition">Upgrade</a>
                    @endif
                </div>
            @endif

            @if($budgets->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($budgets as $budget)
                        @php
                            $spent = $budget->spent_amount;
                            $pct = $budget->amount > 0 ? min(($spent / $budget->amount) * 100, 100) : 0;
                            $color = $pct >= 90 ? 'rose' : ($pct >= 70 ? 'amber' : 'emerald');
                        @endphp
                        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-bold text-lg text-slate-800 font-display">{{ $budget->category->name ?? 'Budget' }}</h3>
                                            @if(auth()->id() !== $budget->user_id)
                                                <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded text-[10px] font-bold uppercase tracking-wider">Shared with me</span>
                                            @elseif($budget->collaborators->count() > 0)
                                                <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded text-[10px] font-bold uppercase tracking-wider">Shared</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ ucfirst($budget->period ?? 'Monthly') }} limit</p>
                                    </div>
                                    <div class="flex gap-1.5">
                                        <a href="{{ route('budgets.show', $budget) }}" class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-emerald-50 hover:text-emerald-600 transition" title="View Collaborators">
                                            <i class="fa-solid fa-users text-xs"></i>
                                        </a>
                                        @can('update', $budget)
                                            <a href="{{ route('budgets.edit', $budget) }}" class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Edit">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $budget)
                                            <form method="POST" action="{{ route('budgets.destroy', $budget) }}" onsubmit="return confirm('Delete this budget?')">
                                                @csrf @method('DELETE')
                                                <button class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition" title="Delete">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <livewire:budget-progress-bar :budget="$budget" :key="'budget-progress-'.$budget->id" />
                                </div>

                                <p class="text-xs text-slate-400">Limit: <strong class="text-slate-700">{{ auth()->user()->formatCurrency($budget->amount) }}</strong></p>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-user-group text-slate-400"></i>
                                    {{ $budget->collaborators->count() }} collaborator(s)
                                </span>
                                <a href="{{ route('budgets.show', $budget) }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                                    Manage &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $budgets->links() }}</div>
            @else
                <div class="bg-white rounded-3xl p-16 text-center border border-dashed border-slate-200 shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-display">No shared budgets created yet</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto mb-6">Create a shared budget category to invite partners, friends, or roommates to collaborate on spending limits.</p>
                    <a href="{{ route('budgets.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition shadow-sm">
                        <i class="fa-solid fa-plus mr-1.5"></i> Create Shared Budget
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
