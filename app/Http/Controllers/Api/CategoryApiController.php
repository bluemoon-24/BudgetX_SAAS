<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'type' => ['nullable', 'in:income,expense'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = Category::where(function ($q) {
            $q->where('user_id', auth()->id())
                ->orWhereNull('user_id');
        });

        if (! empty($validated['search'])) {
            $query->where('name', 'like', '%'.$validated['search'].'%');
        }

        if (! empty($validated['type'])) {
            $query->where('type', $validated['type']);
        }

        $categories = $query->orderBy('name')->paginate($validated['per_page'] ?? 20);

        return CategoryResource::collection($categories)->additional([
            'success' => true,
            'message' => 'Categories retrieved successfully.',
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = auth()->user()->categories()->create($request->validated());

        return $this->successResponse(new CategoryResource($category), 'Category created successfully.', 201);
    }

    public function show(Category $category)
    {
        $this->authorize('view', $category);

        return $this->successResponse(new CategoryResource($category), 'Category retrieved successfully.');
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);
        $category->update($request->validated());

        return $this->successResponse(new CategoryResource($category), 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();

        return $this->successResponse(null, 'Category deleted successfully.');
    }
}
