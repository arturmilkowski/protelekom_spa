<?php

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Admin\Product\StoreCategoryRequest;
use App\Http\Resources\Admin\Product\CategoryResource;
use App\Models\Admin\Product\Category;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::latest()->get());
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $category = Category::create($validated);

        return response()->json($category, 201);
    }

    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    public function update(StoreCategoryRequest $request, Category $category): JsonResponse
    {
        $validated = $request->validated();
        $category->update($validated);

        return response()->json($category, 200);
    }

    public function destroy(Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }
}
