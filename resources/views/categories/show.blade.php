<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
            <i class="fa-solid fa-tags text-purple-500"></i> Category Details
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-md
                        {{ $category->type === 'income' ? 'bg-emerald-500' : 'bg-rose-500' }}">
                        <i class="fa-solid {{ $category->type === 'income' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">{{ $category->name }}</h3>
                        <span class="text-sm font-semibold uppercase tracking-wider {{ $category->type === 'income' ? 'text-emerald-500' : 'text-rose-500' }}">{{ $category->type }}</span>
                    </div>
                </div>
                <div class="flex gap-3">
                    @can('update', $category)
                        <a href="{{ route('categories.edit', $category) }}" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition"><i class="fa-solid fa-pen mr-2"></i> Edit</a>
                    @endcan
                    <a href="{{ route('categories.index') }}" class="px-6 py-3 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
