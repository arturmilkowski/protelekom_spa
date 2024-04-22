<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
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
        $this->product = Product::factory()->for($this->brand)->for($this->category)->create();
    }

    public function testShow(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson(route('products.show', $this->product));

        $response->assertJson(
            [
                'data' => [
                    'id' => $this->product->id,
                    'brand_id' => $this->brand->id,
                    'brand' => $this->brand->name,
                    'category_id' => $this->category->id,
                    'category' => $this->category->name,
                    'slug' => $this->product->slug,
                    'name' => $this->product->name,
                    'description' => $this->product->description,
                    'site_description' => $this->product->site_description,
                    'site_keyword' => $this->product->site_keyword,
                    'hide' => $this->product->hide,
                ]
            ]
        );
        $response->assertStatus(200);
    }
}
