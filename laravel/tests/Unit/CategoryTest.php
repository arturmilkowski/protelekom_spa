<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use App\Models\Admin\Product\{Category, Brand, Product};

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeCategory(): void
    {
        $category = Category::factory()->make();

        $this->assertInstanceOf(Category::class, $category);
    }

    public function testCreateCategory(): void
    {
        $category = Category::factory()->create();

        $this->assertModelExists($category);
        $this->assertDatabaseHas('categories', [
            'slug' => $category->slug,
            'name' => $category->name,
        ]);
    }

    public function testCategoryHasManyProducts(): void
    {
        $category = Category::factory()
            ->has(
                Product::factory()
                    ->for(Brand::factory())
                    ->for(Category::factory())
            )
            ->create();
        $products = $category->products;

        $this->assertInstanceOf(Collection::class, $products);
    }
}
