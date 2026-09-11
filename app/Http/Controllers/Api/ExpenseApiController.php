<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseApiController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = auth()->user()->expenses()->with('category');

        if (isset($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }
        if (! empty($validated['from'])) {
            $query->whereDate('date', '>=', $validated['from']);
        }
        if (! empty($validated['to'])) {
            $query->whereDate('date', '<=', $validated['to']);
        }

        return ExpenseResource::collection($query->orderBy('date', 'desc')->paginate($validated['per_page'] ?? 20));
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
