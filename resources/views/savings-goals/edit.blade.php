<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            <i class="fa-solid fa-bullseye text-amber-500"></i> Edit Savings Goal
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <x-validation-errors class="mb-4" />
                <form method="POST" action="{{ route('savings-goals.update', $savingsGoal) }}">
                    @csrf @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <x-label for="name" value="Goal Name" />
                            <x-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$savingsGoal->name" required />
                        </div>
                        <div>
                            <x-label for="target_amount" value="Target Amount (LKR)" />
                            <x-input id="target_amount" name="target_amount" type="number" step="0.01" class="mt-1 block w-full" :value="$savingsGoal->target_amount" required />
                        </div>
                        <div>
                            <x-label for="current_amount" value="Current Amount (LKR)" />
                            <x-input id="current_amount" name="current_amount" type="number" step="0.01" class="mt-1 block w-full" :value="$savingsGoal->current_amount" />
                        </div>
                        <div>
                            <x-label for="deadline" value="Target Date (Optional)" />
                            <x-input id="deadline" name="deadline" type="date" class="mt-1 block w-full" :value="$savingsGoal->deadline?->format('Y-m-d')" />
                        </div>
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('savings-goals.index') }}" class="px-6 py-3 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">Cancel</a>
                            <button type="submit" class="px-6 py-3 bg-amber-500 text-white rounded-xl font-bold hover:bg-amber-600 transition shadow-lg shadow-amber-500/20"><i class="fa-solid fa-check mr-2"></i> Update Goal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
