<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BudgetResource;
use App\Http\Requests\StoreBudgetRequest;
use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetApiController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->budgets()->with('category');
        
        $query = $this->applyFilters($query, $request, ['name', 'amount']);

        $budgets = $query->paginate($request->input('per_page', 20));
        
        return BudgetResource::collection($budgets)->additional([
            'success' => true,
            'message' => 'Budgets retrieved successfully.'
        ]);
    }

    public function store(StoreBudgetRequest $request)
    {
        $budget = auth()->user()->budgets()->create($request->validated());
        return $this->successResponse(new BudgetResource($budget->load('category')), 'Budget created successfully.', 201);
    }

    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);
        return $this->successResponse(new BudgetResource($budget->load('category')), 'Budget retrieved successfully.');
    }

    public function update(StoreBudgetRequest $request, Budget $budget)
    {
        $this->authorize('update', $budget);
        $budget->update($request->validated());
        return $this->successResponse(new BudgetResource($budget->load('category')), 'Budget updated successfully.');
    }

    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);
        $budget->delete();
        return $this->successResponse(null, 'Budget deleted successfully.');
    }
}