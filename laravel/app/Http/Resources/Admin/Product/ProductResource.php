<?php

namespace App\Http\Resources\Admin\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $img = null;
        if ($this->img) {
            $img = asset(config('settings.store_filepath.product')) . '/' . $this->img;
        }

        return [
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'brand' => $this->brand->name,
            'category_id' => $this->category_id,
            'category' => $this->category->name,
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'img' => $img,
            'site_description' => $this->site_description,
            'site_keyword' => $this->site_keyword,
            'hide' => $this->hide,
            'created_at' => $this->created_at, // ->format('Y-m-d'), // 'Y-m-d h:i:s'
            'updated_at' => $this->updated_at, // ->format('Y-m-d'),            
        ];
    }
}
