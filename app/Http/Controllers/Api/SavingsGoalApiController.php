<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SavingsGoalResource;
use App\Http\Requests\StoreSavingsGoalRequest;
use App\Models\SavingsGoal;
use Illuminate\Http\Request;

class SavingsGoalApiController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->savingsGoals();

        return SavingsGoalResource::collection($query->orderBy('created_at', 'desc')->paginate(20));
    }

    public function store(StoreSavingsGoalRequest $request)
    {
        $savingsGoal = auth()->user()->savingsGoals()->create($request->validated());
        return new SavingsGoalResource($savingsGoal);
    }

    public function show(SavingsGoal $savingsGoal)
    {
        $this->authorize('view', $savingsGoal);
        return new SavingsGoalResource($savingsGoal);
    }

    public function update(StoreSavingsGoalRequest $request, SavingsGoal $savingsGoal)
    {
        $this->authorize('update', $savingsGoal);
        $savingsGoal->update($request->validated());
        return new SavingsGoalResource($savingsGoal);
    }

    public function destroy(SavingsGoal $savingsGoal)
    {
        $this->authorize('delete', $savingsGoal);
        $savingsGoal->delete();
        return response()->json(['message' => 'Savings goal deleted.'], 200);
    }
}
