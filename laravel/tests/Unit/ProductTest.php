<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use App\Models\Admin\Product\{Brand, Category, Product};

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $product, $brand, $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->brand = Brand::factory()->create();
        $this->category = Category::factory()->create();
        $this->product = Product::factory()
            ->for($this->brand)
            ->for($this->category)
            // ->has(Type::factory()->for(Condition::factory()))
            ->create();
    }

    public function testMakeProduct(): void
    {
        $product = Product::factory()->make();

        $this->assertInstanceOf(Product::class, $product);
    }

    public function testCreateProduct(): void
    {
        $this->assertModelExists($this->product);
        $this->assertDatabaseHas('products', [
            'slug' => $this->product->slug,
            'name' => $this->product->name,
            'description' => $this->product->description,
            'site_description' => $this->product->site_description,
            'site_keyword' => $this->product->site_keyword,
            'hide' => $this->product->hide,
        ]);
    }

    public function testProductBelongsToBrand(): void
    {
        $this->assertInstanceOf(Brand::class, $this->product->brand);
    }

    public function testProductBelongsToCategory(): void
    {
        $this->assertInstanceOf(Category::class, $this->product->category);
    }

    public function testProductHasManyTypes(): void
    {
        $this->assertInstanceOf(Collection::class, $this->product->types);
    }
}
