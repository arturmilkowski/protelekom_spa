<?php

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Admin\Product\StoreConditionRequest;
use App\Http\Resources\Admin\Product\ConditionResource;
use App\Models\Admin\Product\Condition;

class ConditionController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ConditionResource::collection(Condition::latest()->get());
    }

    public function store(StoreConditionRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $condition = Condition::create($validated);

        return response()->json($condition, 201);
    }

    public function show(Condition $condition): ConditionResource
    {
        return new ConditionResource($condition);
    }

    public function update(StoreConditionRequest $request, Condition $condition): JsonResponse
    {
        $validated = $request->validated();
        $condition->update($validated);

        return response()->json($condition, 200);
    }

    public function destroy(Condition $condition): Response
    {
        $condition->delete();

        return response()->noContent();
    }
}
