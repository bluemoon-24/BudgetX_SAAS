<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2" style="font-family: 'Outfit', sans-serif;">
                <i class="fa-solid fa-tags text-purple-500"></i> My Categories
            </h2>
            <a href="{{ route('categories.create') }}" class="px-5 py-2.5 bg-purple-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-purple-500/20 hover:bg-purple-600 transition">
                <i class="fa-solid fa-plus mr-1"></i> New Category
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

            @if($categories->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-md
                            {{ $category->type === 'income' ? 'bg-emerald-500' : 'bg-rose-500' }}">
                            <i class="fa-solid {{ $category->type === 'income' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">{{ $category->name }}</h3>
                            <span class="text-xs font-semibold uppercase tracking-wider {{ $category->type === 'income' ? 'text-emerald-500' : 'text-rose-500' }}">{{ $category->type }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('categories.edit', $category) }}" class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-indigo-100 hover:text-indigo-600 transition"><i class="fa-solid fa-pen text-xs"></i></a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition"><i class="fa-solid fa-trash text-xs"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $categories->links() }}</div>
            @else
            <div class="bg-white rounded-3xl p-16 text-center border border-dashed border-slate-300 shadow-sm">
                <i class="fa-solid fa-tags text-6xl text-slate-300 mb-6"></i>
                <h3 class="text-xl font-bold text-slate-700 mb-2">No categories yet</h3>
                <p class="text-slate-500 mb-6">Create categories to organize your income and expenses.</p>
                <a href="{{ route('categories.create') }}" class="inline-block px-6 py-3 bg-purple-500 text-white rounded-xl font-bold hover:bg-purple-600 transition shadow-lg shadow-purple-500/20">
                    <i class="fa-solid fa-plus mr-2"></i> Create Category
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
