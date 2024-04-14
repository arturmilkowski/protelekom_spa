<?php

namespace App\Http\Controllers\Api\Admin\Slug;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class SlugController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $slug = Str::slug($request->input('text', '-'));

        return response()->json(['slug' => $slug]);
    }
}
