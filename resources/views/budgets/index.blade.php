<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
                <i class="fa-solid fa-bullseye text-indigo-600"></i> My Goals
            </h2>
            <a href="{{ route('budgets.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 hover:bg-indigo-700 transition">
                <i class="fa-solid fa-plus mr-1"></i> New Goal
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-center gap-3">
                    <i class="fa-solid fa-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-center gap-3">
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
                    $spent = $budget->expenses_sum ?? 0;
                    $pct = $budget->amount > 0 ? min(($spent / $budget->amount) * 100, 100) : 0;
                    $color = $pct >= 90 ? 'rose' : ($pct >= 70 ? 'amber' : 'emerald');
                @endphp
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-lg text-slate-800">{{ $budget->category->name ?? 'Goal' }}</h3>
                                @if(auth()->id() !== $budget->user_id)
                                    <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded text-[10px] font-bold uppercase tracking-wider">Shared with me</span>
                                @elseif($budget->collaborators->count() > 0)
                                    <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded text-[10px] font-bold uppercase tracking-wider">Shared</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $budget->period ?? 'Monthly' }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('budgets.show', $budget) }}" class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-emerald-100 hover:text-emerald-600 transition" title="View Details"><i class="fa-solid fa-eye text-xs"></i></a>
                            <a href="{{ route('budgets.edit', $budget) }}" class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-indigo-100 hover:text-indigo-600 transition" title="Edit"><i class="fa-solid fa-pen text-xs"></i></a>
                            <form method="POST" action="{{ route('budgets.destroy', $budget) }}" onsubmit="return confirm('Delete this goal?')">
                                @csrf @method('DELETE')
                                <button class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition"><i class="fa-solid fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="flex justify-between items-end mb-2">
                        <p class="text-2xl font-bold text-slate-800" style="font-family: 'Outfit', sans-serif;">LKR {{ number_format($budget->amount, 2) }}</p>
                        <span class="text-sm font-bold text-{{ $color }}-600">{{ round($pct) }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="h-full rounded-full bg-{{ $color }}-500 transition-all duration-700" style="width: {{ $pct }}%"></div>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">LKR {{ number_format($spent, 2) }} spent of LKR {{ number_format($budget->amount, 2) }}</p>
                </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $budgets->links() }}</div>
            @else
            <div class="bg-white rounded-3xl p-16 text-center border border-dashed border-slate-300 shadow-sm">
                <i class="fa-solid fa-bullseye text-6xl text-slate-300 mb-6"></i>
                <h3 class="text-xl font-bold text-slate-700 mb-2">No goals created yet</h3>
                <p class="text-slate-500 mb-6">Create your first goal to start tracking your spending limits.</p>
                <a href="{{ route('budgets.create') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">
                    <i class="fa-solid fa-plus mr-2"></i> Create Goal
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
