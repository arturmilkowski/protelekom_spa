<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Admin\Product\Condition;

class ConditionTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeCondition(): void
    {
        $condition = Condition::factory()->make();

        $this->assertInstanceOf(Condition::class, $condition);
    }

    public function testMakeCreate(): void
    {
        $condition = Condition::factory()->create();

        $this->assertModelExists($condition);
        $this->assertDatabaseHas('conditions', [
            'slug' => $condition->slug,
            'name' => $condition->name,
        ]);
    }
}
