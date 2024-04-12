<?php

namespace App\Models\Admin\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'condition_id',
        'slug',
        'name',
        'price',
        'promo_price',
        'quantity',
        'hide',
        'description',
        'img'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }
}
