<?php

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Product\Product;

class DestroyProductImageController extends Controller
{
    public function __invoke(Product $product): Response
    {
        Storage::delete(config('settings.filepath.product') . $product->img);
        $product->update(['img' => null]);

        return response()->noContent();
    }
}
