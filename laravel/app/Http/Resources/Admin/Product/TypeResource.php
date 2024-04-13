<?php

namespace App\Http\Resources\Admin\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
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
            $img = asset(config('settings.store_filepath.type')) . '/' . $this->img;
        }

        return [
            'id' => $this->id,
            'product_id' => $this->product->id,
            'product' => $this->product->name,
            'condition_id' => $this->condition->id,
            'condition' => $this->condition->name,
            'slug' => $this->slug,
            'name' => $this->name,
            'price' => $this->price,
            'promo_price' => $this->promo_price,
            'quantity' => $this->quantity,
            'hide' => $this->hide,
            'description' => $this->description,
            'img' => $img,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
