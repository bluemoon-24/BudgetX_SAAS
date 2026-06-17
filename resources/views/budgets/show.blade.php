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
                <p class="text-3xl font-extrabold text-indigo-600 mb-6" style="font-family: 'Outfit', sans-serif;">LKR {{ number_format($budget->amount, 2) }}</p>
                <div class="flex gap-3">
                    <a href="{{ route('budgets.edit', $budget) }}" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition"><i class="fa-solid fa-pen mr-2"></i> Edit</a>
                    <a href="{{ route('budgets.index') }}" class="px-6 py-3 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">Back</a>
                </div>
            </div>

            <!-- Collaborators Section -->
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

                <!-- List Current Collaborators -->
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

                <!-- Invite Form (Only for Owner) -->
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
