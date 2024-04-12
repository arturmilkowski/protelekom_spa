<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use App\Models\Admin\Product\{Condition, Brand, Category, Product, Type};

class ConditionTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeCondition(): void
    {
        $condition = Condition::factory()->make();

        $this->assertInstanceOf(Condition::class, $condition);
    }

    public function testCreateCondition(): void
    {
        $condition = Condition::factory()->create();

        $this->assertModelExists($condition);
        $this->assertDatabaseHas('conditions', [
            'slug' => $condition->slug,
            'name' => $condition->name,
        ]);
    }

    public function testConditionHasManyTypes(): void
    {
        $condition = Condition::factory()
            ->has(
                Type::factory()
                    ->for(Product::factory()->for(Brand::factory())->for(Category::factory()))
            )
            ->create();

        $this->assertInstanceOf(Collection::class, $condition->types);
    }
}
