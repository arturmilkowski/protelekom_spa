<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin\Product\{Brand, Category, Condition, Product, Type};

class TypeTest extends TestCase
{
    use RefreshDatabase;

    private $user, $product, $product1, $product2, $brand, $category, $type, $type1, $type2;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->brand = Brand::factory()->create();
        $this->category = Category::factory()->create();
        $this->product = Product::factory()->for($this->brand)->for($this->category)->has(Type::factory()->for(Condition::factory()))->create();
        $this->type = Type::factory()->for(Condition::factory())->for($this->product)->create();
        $this->type1 = Type::factory()->for(Condition::factory())->for($this->product)->make();
        $this->type2 = Type::factory()->for(Condition::factory())->for($this->product)->make(['name' => '']);
    }

    public function testTypeIndex(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->getJson(route('types.index', $this->product));

        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        $this->withoutExceptionHandling();
        // dd($this->product);
        $response = $this->postJson(route('types.store', $this->product), $this->type1->toArray());

        $response->assertStatus(201)->assertJson(['name' => $this->type1->name]);
        $response->assertJsonIsObject();
        $response->assertJsonStructure(['name', 'slug']);
        $this->assertDatabaseHas('types', ['name' => $this->type1->name]);
    }

    public function testStoreWithValidationError(): void
    {
        $response = $this->postJson(route('types.store', $this->product), $this->type2->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name field is required.'], $responseKey = 'errors');
        $this->assertDatabaseMissing('types', ['name' => $this->type2->name]);
    }

    public function testShow(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson(route('types.show', [$this->product, $this->product->types[0]]));

        // $response->dump();
        $response->assertStatus(200)->assertJson(['data' => ['name' => $this->product->types[0]['name']]]);
    }

    public function testUpdate(): void
    {
        // dd($this->product->types[0]);
        $response = $this->putJson(route('types.update', [$this->product, $this->product->types[0]]), $this->type1->toArray());

        $response->assertJsonIsObject();
        // $response->assertStatus(200)->assertJson(['name' => $this->product1->name, 'brand_id' => $this->product1->brand_id]);
        $this->assertDatabaseHas('types', ['name' => $this->type1->name]);
    }

    public function testUpdateWithValidationError(): void
    {
        $response = $this->putJson(route('types.update', [$this->product, $this->product->types[0]]), $this->type2->toArray());

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('name', $responseKey = 'errors');
        $this->assertDatabaseMissing('types', ['name' => $this->type2->name]);
    }

    public function testDestroy(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->deleteJson(route('types.destroy', [$this->product, $this->product->types[0]]));

        // $response->assertStatus(204);
        $response->assertNoContent($status = 204);
        $this->assertDatabaseMissing('types', ['name' => $this->product->types[0]->name]);
    }
}
