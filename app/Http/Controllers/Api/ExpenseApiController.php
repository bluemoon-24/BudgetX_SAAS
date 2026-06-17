<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseApiController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->expenses()->with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        return ExpenseResource::collection($query->orderBy('date', 'desc')->paginate(20));
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = auth()->user()->expenses()->create($request->validated());
        return new ExpenseResource($expense->load('category'));
    }

    public function show(Expense $expense)
    {
        $this->authorize('view', $expense);
        return new ExpenseResource($expense->load('category'));
    }

    public function update(StoreExpenseRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense);
        $expense->update($request->validated());
        return new ExpenseResource($expense->load('category'));
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete();
        return response()->json(['message' => 'Expense deleted.'], 200);
    }
}