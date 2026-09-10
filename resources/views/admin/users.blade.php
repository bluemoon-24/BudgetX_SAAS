<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            <i class="fa-solid fa-users text-indigo-600"></i> Manage Users
        </h2>
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
                </div>
            @endif

            <!-- Search & Filter Controls -->
            <form method="GET" action="{{ route('admin.users') }}" class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..." class="w-full text-sm rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Role</label>
                    <select name="role" class="w-full text-sm rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Roles</option>
                        <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                        <option value="premium" @selected(request('role') === 'premium')>Premium</option>
                        <option value="user" @selected(request('role') === 'user')>User</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status</label>
                    <select name="status" class="w-full text-sm rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Statuses</option>
                        <option value="active" @selected(request('status') === 'active')>Active</option>
                        <option value="blocked" @selected(request('status') === 'blocked')>Blocked</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition">Filter</button>
                    @if(request()->hasAny(['search', 'role', 'status']))
                        <a href="{{ route('admin.users') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition">Reset</a>
                    @endif
                </div>
            </form>

            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                @if($users->count() > 0)
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->hasRole('admin') || $user->role === 'admin')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">Admin</span>
                                    @elseif($user->hasRole('premium') || $user->role === 'premium')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">Premium</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">Basic</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->status === 'blocked')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">Blocked</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Active</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">{{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.toggle-role', $user) }}">
                                                @csrf
                                                <button type="submit" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">Toggle Role</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" onsubmit="return confirm('Change status for {{ $user->name }}?')">
                                                @csrf
                                                @if($user->status === 'blocked')
                                                    <button type="submit" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 transition">Activate</button>
                                                @else
                                                    <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800 transition">Block</button>
                                                @endif
                                            </form>
                                        @else
                                            <span class="text-xs font-bold text-slate-400 italic">Current User</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-4 border-t border-slate-100">{{ $users->links() }}</div>
                @else
                    <div class="py-16 text-center text-slate-400">
                        <i class="fa-solid fa-users text-4xl mb-3 text-slate-300"></i>
                        <p class="text-base font-bold text-slate-700">No users found</p>
                        <p class="text-xs text-slate-400 mt-1">Try adjusting your search query or role/status filters.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
