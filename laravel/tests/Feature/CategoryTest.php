<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin\Product\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    // todo
    public function testCategoryIndex(): void
    {
        $response = $this->withoutExceptionHandling();
        $category = Category::factory(2)->create();
        $response = $this->getJson(route('categories.index'));

        $response->assertStatus(200);
    }

    public function testCategoryStore(): void
    {
        $response = $this->withoutExceptionHandling();
        $data = ['name' => 'Sally', 'slug' => 'sally'];
        $response = $this->postJson(route('categories.store', $data));

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', ['name' => 'Sally']);
    }

    public function testCategoryStoreWithValidationError(): void
    {
        $category = Category::factory()->make(['name' => '']);
        $response = $this->postJson(route('categories.store'), $category->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name field is required.'], $responseKey = 'errors');
        $this->assertDatabaseMissing('categories', ['name' => $category->name]);
    }

    public function testCategoryStoreWithDuplicateValidationError(): void
    {
        $category = Category::factory()->create();
        $response = $this->postJson(route('categories.store'), $category->toArray());
        $response = $this->postJson(route('categories.store'), $category->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name has already been taken.'], $responseKey = 'errors');
    }

    // todo
    public function testCategoryShow(): void
    {
        $response = $this->withoutExceptionHandling();
        $category = Category::factory()->create();
        $response = $this->getJson(route('categories.show', $category));


        $response->assertStatus(200);
    }

    public function testCategoryUpdate(): void
    {
        $response = $this->withoutExceptionHandling();
        $category = Category::factory()->create();
        $category1 = Category::factory()->make();
        $response = $this->putJson(route('categories.update', $category), $category1->toArray());

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', ['name' => $category1->name]);
    }

    public function testCategoryUpdateWithValidationError(): void
    {
        $category = Category::factory()->create();
        $category1 = Category::factory()->make(['name' => '']);
        $response = $this->putJson(route('categories.update', $category), $category1->toArray());

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('name', $responseKey = 'errors');
        $this->assertDatabaseMissing('categories', ['name' => $category1->name]);
    }

    public function testCategoryDelete(): void
    {
        $category = Category::factory()->create();
        $response = $this->withoutExceptionHandling()->deleteJson(route('categories.destroy', $category));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['name' => $category->name]);
    }
}
