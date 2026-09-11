<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Models\Category;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->incomes()->with('category');

        if ($request->filled('search')) {
            $query->where('description', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $totalAmount = (clone $query)->sum('amount');
        $incomes = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();
        $categories = Category::where('type', 'income')->where(fn ($q) => $q->whereNull('user_id')->orWhere('user_id', auth()->id()))->get();

        return view('incomes.index', compact('incomes', 'categories', 'totalAmount'));
    }

    public function create()
    {
        Category::ensureSystemDefaults();
        $categories = Category::where('type', 'income')->where(fn ($q) => $q->whereNull('user_id')->orWhere('user_id', auth()->id()))->get();

        return view('incomes.create', compact('categories'));
    }

    public function store(StoreIncomeRequest $request)
    {
        auth()->user()->incomes()->create($request->validated());

        return redirect()->route('incomes.index')->with('success', 'Income added successfully!');
    }

    public function show(Income $income)
    {
        $this->authorize('view', $income);

        return view('incomes.show', compact('income'));
    }

    public function edit(Income $income)
    {
        $this->authorize('update', $income);
        $categories = Category::where('type', 'income')->where(fn ($q) => $q->whereNull('user_id')->orWhere('user_id', auth()->id()))->get();

        return view('incomes.edit', compact('income', 'categories'));
    }

    public function update(StoreIncomeRequest $request, Income $income)
    {
        $this->authorize('update', $income);
        $income->update($request->validated());

        return redirect()->route('incomes.index')->with('success', 'Income updated!');
    }

    public function destroy(Income $income)
    {
        $this->authorize('delete', $income);
        $income->delete();

        return redirect()->route('incomes.index')->with('success', 'Income deleted.');
    }
}
