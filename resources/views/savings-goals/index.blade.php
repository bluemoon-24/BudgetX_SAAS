<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
                <i class="fa-solid fa-bullseye text-amber-500"></i> Savings Goals
            </h2>
            <a href="{{ route('savings-goals.create') }}" class="px-5 py-2.5 bg-amber-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-amber-500/20 hover:bg-amber-600 transition">
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

            @if($goals->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($goals as $goal)
                @php
                    $pct = $goal->target_amount > 0 ? min(($goal->current_amount / $goal->target_amount) * 100, 100) : 0;
                    $color = $pct >= 100 ? 'emerald' : ($pct >= 50 ? 'amber' : 'indigo');
                @endphp
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800">{{ $goal->name }}</h3>
                            @if($goal->deadline)
                                <p class="text-xs text-slate-500 mt-0.5"><i class="fa-regular fa-calendar mr-1"></i> {{ $goal->deadline->format('M d, Y') }}</p>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('savings-goals.edit', $goal) }}" class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-indigo-100 hover:text-indigo-600 transition"><i class="fa-solid fa-pen text-xs"></i></a>
                            <form method="POST" action="{{ route('savings-goals.destroy', $goal) }}" onsubmit="return confirm('Delete this goal?')">
                                @csrf @method('DELETE')
                                <button class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition"><i class="fa-solid fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="flex justify-between items-end mb-2">
                        <p class="text-2xl font-bold text-slate-800" style="font-family: 'Outfit', sans-serif;">LKR {{ number_format($goal->target_amount, 2) }}</p>
                        <span class="text-sm font-bold text-{{ $color }}-600">{{ round($pct) }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="h-full rounded-full bg-{{ $color }}-500 transition-all duration-700" style="width: {{ $pct }}%"></div>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">LKR {{ number_format($goal->current_amount, 2) }} saved of LKR {{ number_format($goal->target_amount, 2) }}</p>
                </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $goals->links() }}</div>
            @else
            <div class="bg-white rounded-3xl p-16 text-center border border-dashed border-slate-300 shadow-sm">
                <i class="fa-solid fa-bullseye text-6xl text-slate-300 mb-6"></i>
                <h3 class="text-xl font-bold text-slate-700 mb-2">No savings goals yet</h3>
                <p class="text-slate-500 mb-6">Set a savings goal to start building your financial future.</p>
                <a href="{{ route('savings-goals.create') }}" class="inline-block px-6 py-3 bg-amber-500 text-white rounded-xl font-bold hover:bg-amber-600 transition shadow-lg shadow-amber-500/20">
                    <i class="fa-solid fa-plus mr-2"></i> Create Goal
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
