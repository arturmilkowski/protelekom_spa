<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use App\Models\Admin\Product\{Brand, Category, Product};

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeBrand(): void
    {
        $brand = Brand::factory()->make();

        $this->assertInstanceOf(Brand::class, $brand);
    }

    public function testMakeCreate(): void
    {
        $brand = Brand::factory()->create();

        $this->assertModelExists($brand);
        $this->assertDatabaseHas('brands', [
            'slug' => $brand->slug,
            'name' => $brand->name,
        ]);
    }
    public function testBrandHasManyProducts(): void
    {
        $brand = Brand::factory()
            ->has(
                Product::factory()
                    ->for(Category::factory())
                    ->for(Brand::factory())
            )
            ->create();

        $this->assertInstanceOf(Collection::class, $brand->products);
    }
}
