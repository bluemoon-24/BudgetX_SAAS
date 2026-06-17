<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            <i class="fa-solid fa-shield-halved text-indigo-600"></i> Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-3xl p-6 text-white shadow-lg shadow-indigo-500/20">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-indigo-200 text-sm font-semibold">Total Users</span>
                        <i class="fa-solid fa-users text-indigo-200 text-xl"></i>
                    </div>
                    <p class="text-4xl font-extrabold" style="font-family: 'Outfit', sans-serif;">{{ number_format($totalUsers) }}</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-3xl p-6 text-white shadow-lg shadow-emerald-500/20">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-emerald-200 text-sm font-semibold">Total Income</span>
                        <i class="fa-solid fa-arrow-trend-up text-emerald-200 text-xl"></i>
                    </div>
                    <p class="text-4xl font-extrabold" style="font-family: 'Outfit', sans-serif;">LKR {{ number_format($totalIncomes, 2) }}</p>
                </div>
                <div class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-3xl p-6 text-white shadow-lg shadow-rose-500/20">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-rose-200 text-sm font-semibold">Total Expenses</span>
                        <i class="fa-solid fa-arrow-trend-down text-rose-200 text-xl"></i>
                    </div>
                    <p class="text-4xl font-extrabold" style="font-family: 'Outfit', sans-serif;">LKR {{ number_format($totalExpenses, 2) }}</p>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-lg text-slate-800"><i class="fa-solid fa-user-plus mr-2 text-indigo-500"></i> Recent Users</h3>
                </div>
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentUsers as $user)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
