<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'php' => PHP_VERSION,
            'laravel' => app()->version(),
            'environment' => app()->environment(),
            'user' => Auth::user(),
        ]);
    }
}
