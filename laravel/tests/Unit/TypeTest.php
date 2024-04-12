<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Admin\Product\{Brand, Category, Product, Condition, Type};

class TypeTest extends TestCase
{
    use RefreshDatabase;

    private $product, $brand, $category, $condition, $type;

    public function setUp(): void
    {
        parent::setUp();

        $this->brand = Brand::factory()->create();
        $this->category = Category::factory()->create();
        $this->condition = Condition::factory()->create();
        $this->product = Product::factory()->for($this->brand)->for($this->category)->create();
    }

    public function testMakeType(): void
    {
        $type = Type::factory()->make();

        $this->assertInstanceOf(Type::class, $type);
    }

    public function testCreateType(): void
    {
        $type = Type::factory()->for($this->product)->for($this->condition)->create();

        $this->assertModelExists($type);
        $this->assertDatabaseHas('types', [
            'product_id' => $this->product->id,
            'condition_id' => $this->condition->id,
            'slug' => $type->slug,
            'name' => $type->name,
            'price' => $type->price,
            'promo_price' => $type->promo_price,
            'quantity' => $type->quantity,
            'hide' => $type->hide,
        ]);
    }

    public function testTypeBelongsToProduct(): void
    {
        $type = Type::factory()->for($this->product)->for($this->condition)->create();

        $this->assertInstanceOf(Product::class, $type->product);
    }

    public function testTypeBelongsToCondition(): void
    {
        $type = Type::factory()->for($this->product)->for($this->condition)->create();

        $this->assertInstanceOf(Condition::class, $type->condition);
    }
}
