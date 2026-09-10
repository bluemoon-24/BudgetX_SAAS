<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Http\Requests\StoreExpenseRequest;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->expenses()->with('category');

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        $totalAmount = (clone $query)->sum('amount');
        $expenses    = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();
        $categories  = Category::where('type', 'expense')->where(fn($q) => $q->whereNull('user_id')->orWhere('user_id', auth()->id()))->get();

        return view('expenses.index', compact('expenses', 'categories', 'totalAmount'));
    }

    public function create()
    {
        Category::ensureSystemDefaults();
        $categories = Category::where('type', 'expense')->where(fn($q) => $q->whereNull('user_id')->orWhere('user_id', auth()->id()))->get();
        return view('expenses.create', compact('categories'));
    }

    public function store(StoreExpenseRequest $request)
    {
        auth()->user()->expenses()->create($request->validated());
        return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
    }

    public function show(Expense $expense)
    {
        $this->authorize('view', $expense);
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $this->authorize('update', $expense);
        $categories = Category::where('type', 'expense')->where(fn($q) => $q->whereNull('user_id')->orWhere('user_id', auth()->id()))->get();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(StoreExpenseRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense);
        $expense->update($request->validated());
        return redirect()->route('expenses.index')->with('success', 'Expense updated!');
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted.');
    }
}