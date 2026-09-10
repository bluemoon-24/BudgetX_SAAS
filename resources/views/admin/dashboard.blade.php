<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            <i class="fa-solid fa-shield-halved text-indigo-600"></i> Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-3xl p-6 text-white shadow-lg shadow-indigo-500/20">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-indigo-200 text-sm font-semibold">Total Users</span>
                        <i class="fa-solid fa-users text-indigo-200 text-xl"></i>
                    </div>
                    <p class="text-4xl font-extrabold" style="font-family: 'Outfit', sans-serif;">{{ number_format($totalUsers) }}</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-3xl p-6 text-white shadow-lg shadow-emerald-500/20">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-emerald-200 text-sm font-semibold">Active Accounts</span>
                        <i class="fa-solid fa-user-check text-emerald-200 text-xl"></i>
                    </div>
                    <p class="text-4xl font-extrabold" style="font-family: 'Outfit', sans-serif;">{{ number_format($activeUsers) }}</p>
                </div>
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-3xl p-6 text-white shadow-lg shadow-amber-500/20">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-amber-100 text-sm font-semibold">Premium Users</span>
                        <i class="fa-solid fa-crown text-amber-100 text-xl"></i>
                    </div>
                    <p class="text-4xl font-extrabold" style="font-family: 'Outfit', sans-serif;">{{ number_format($premiumUsers) }}</p>
                </div>
                <div class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-3xl p-6 text-white shadow-lg shadow-rose-500/20">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-rose-100 text-sm font-semibold">Blocked Accounts</span>
                        <i class="fa-solid fa-user-slash text-rose-100 text-xl"></i>
                    </div>
                    <p class="text-4xl font-extrabold" style="font-family: 'Outfit', sans-serif;">{{ number_format($blockedUsers) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-10">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="font-bold text-lg text-slate-800"><i class="fa-solid fa-bolt mr-2 text-indigo-500"></i> Quick Actions</h3>
                    </div>
                    <div class="space-y-3">
                        <a href="{{ route('admin.users') }}" class="flex items-center justify-between w-full px-4 py-3 rounded-xl bg-indigo-50 text-indigo-700 font-semibold hover:bg-indigo-100 transition">
                            <span><i class="fa-solid fa-users mr-2"></i> Manage Users</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ route('admin.users') }}" class="flex items-center justify-between w-full px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 font-semibold hover:bg-emerald-100 transition">
                            <span><i class="fa-solid fa-user-check mr-2"></i> Review Active Accounts</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ route('admin.users') }}" class="flex items-center justify-between w-full px-4 py-3 rounded-xl bg-rose-50 text-rose-700 font-semibold hover:bg-rose-100 transition">
                            <span><i class="fa-solid fa-shield-halved mr-2"></i> Security Review</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 xl:col-span-2">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="font-bold text-lg text-slate-800"><i class="fa-solid fa-user-plus mr-2 text-indigo-500"></i> Recent Signups</h3>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Latest users</span>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentUsers as $user)
                            <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-100 bg-slate-50/60 px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($user->hasRole('admin') || $user->role === 'admin')
                                        <span class="px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 text-[10px] font-bold uppercase">Admin</span>
                                    @elseif($user->hasRole('premium') || $user->role === 'premium')
                                        <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold uppercase">Premium</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full bg-slate-200 text-slate-700 text-[10px] font-bold uppercase">User</span>
                                    @endif
                                    <span class="text-xs text-slate-400">{{ $user->created_at?->diffForHumans() ?? 'Recently' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h3 class="font-bold text-lg text-slate-800"><i class="fa-solid fa-heart-pulse mr-2 text-emerald-500"></i> Account Health</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Active accounts</span>
                            <span class="text-lg font-bold text-emerald-600">{{ number_format($activeUsers) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Blocked accounts</span>
                            <span class="text-lg font-bold text-rose-600">{{ number_format($blockedUsers) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Premium memberships</span>
                            <span class="text-lg font-bold text-amber-600">{{ number_format($premiumUsers) }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h3 class="font-bold text-lg text-slate-800"><i class="fa-solid fa-chart-column mr-2 text-violet-500"></i> Platform Summary</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Total registered users</span>
                            <span class="text-lg font-bold text-slate-800">{{ number_format($totalUsers) }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Admin accounts</span>
                            <span class="text-lg font-bold text-indigo-600">{{ number_format(\App\Models\User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->count()) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">System status</span>
                            <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase">Healthy</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-lg text-slate-800"><i class="fa-solid fa-user-plus mr-2 text-indigo-500"></i> User List</h3>
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
