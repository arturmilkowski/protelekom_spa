<?php

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Product\{Product, Type};

class DestroyTypeImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Product $product, Type $type): Response
    {
        Storage::delete(config('settings.filepath.type') . $type->img);
        $type->update(['img' => null]);

        return response()->noContent();
    }
}
