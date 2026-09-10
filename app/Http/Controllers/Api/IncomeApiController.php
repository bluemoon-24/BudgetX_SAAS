<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use App\Http\Requests\StoreIncomeRequest;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeApiController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = auth()->user()->incomes()->with('category');

        if (isset($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }
        if (! empty($validated['from'])) {
            $query->whereDate('date', '>=', $validated['from']);
        }
        if (! empty($validated['to'])) {
            $query->whereDate('date', '<=', $validated['to']);
        }

        return IncomeResource::collection($query->orderBy('date', 'desc')->paginate($validated['per_page'] ?? 20));
    }

    public function store(StoreIncomeRequest $request)
    {
        $income = auth()->user()->incomes()->create($request->validated());
        return new IncomeResource($income->load('category'));
    }

    public function show(Income $income)
    {
        $this->authorize('view', $income);
        return new IncomeResource($income->load('category'));
    }

    public function update(StoreIncomeRequest $request, Income $income)
    {
        $this->authorize('update', $income);
        $income->update($request->validated());
        return new IncomeResource($income->load('category'));
    }

    public function destroy(Income $income)
    {
        $this->authorize('delete', $income);
        $income->delete();
        return response()->json(['message' => 'Income deleted.'], 200);
    }
}
