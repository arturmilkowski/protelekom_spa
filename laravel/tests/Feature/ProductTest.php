<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin\Product\{Brand, Category, Product};

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $user, $product, $product1, $product2, $brand, $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->brand = Brand::factory()->create();
        $this->category = Category::factory()->create();
        $this->product = Product::factory()->for($this->brand)->for($this->category)->create(); // ->has(Type::factory()->for(Condition::factory()))
        $this->product1 = Product::factory()->for($this->brand)->for($this->category)->make();
        $this->product2 = Product::factory()->for($this->brand)->for($this->category)->make(['name' => '']);
    }

    // todo
    public function testProductIndex(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->getJson(route('products.index'));

        $response->assertStatus(200);
    }

    public function testProductStore(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('products.store'), $this->product1->toArray());

        $response->assertStatus(201)->assertJson(['name' => $this->product1->name]);
        $response->assertJsonIsObject();
        $response->assertJsonStructure(['name', 'slug']);
        $this->assertDatabaseHas('products', ['name' => $this->product1->name]);
    }

    public function testProductStoreWithValidationError(): void
    {
        $response = $this->postJson(route('products.store'), $this->product2->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name field is required.'], $responseKey = 'errors');
        $this->assertDatabaseMissing('products', ['name' => $this->product2->name]);
    }

    public function testProductStoreWithDuplicateValidationError(): void
    {
        $response = $this->postJson(route('products.store'), $this->product->toArray());
        $response = $this->postJson(route('products.store'), $this->product->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name has already been taken.'], $responseKey = 'errors');
    }

    // todo
    public function testProductShow(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson(route('products.show', $this->product));

        $response->assertStatus(200)->assertJson(['data' => ['name' => $this->product->name]]);
    }

    public function testProductUpdate(): void
    {
        $response = $this->withoutExceptionHandling();
        $response = $this->putJson(route('products.update', $this->product), $this->product1->toArray());

        $response->assertJsonIsObject();
        $response->assertStatus(200)->assertJson(['name' => $this->product1->name, 'brand_id' => $this->product1->brand_id]);
        $this->assertDatabaseHas('products', ['name' => $this->product1->name]);
    }

    public function testProductUpdateWithValidationError(): void
    {
        $response = $this->putJson(route('products.update', $this->product), $this->product2->toArray());

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('name', $responseKey = 'errors');
        $this->assertDatabaseMissing('products', ['name' => $this->product2->name]);
    }

    public function testProductDelete(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->deleteJson(route('products.destroy', $this->product));

        // $response->assertStatus(204);
        $response->assertNoContent($status = 204);
        $this->assertDatabaseMissing('products', ['name' => $this->product->name]);
    }
}
