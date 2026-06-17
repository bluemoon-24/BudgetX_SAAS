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
        $query = auth()->user()->incomes()->with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        return IncomeResource::collection($query->orderBy('date', 'desc')->paginate(20));
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
