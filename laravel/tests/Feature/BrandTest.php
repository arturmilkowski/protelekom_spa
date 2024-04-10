<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin\Product\Brand;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    // json, getJson, postJson, putJson, patchJson, deleteJson
    public function testBrandIndex(): void
    {
        $response = $this->withoutExceptionHandling();
        $brand = Brand::factory(2)->create();
        $response = $this->getJson(route('brands.index'));

        $response->assertStatus(200);
        // $response->dumpHeaders();
        // $response->dumpSession();
        // $response->dump();
    }

    public function testBrandStore(): void
    {
        $response = $this->withoutExceptionHandling();
        $data = ['name' => 'Sally', 'slug' => 'sally'];
        $response = $this->postJson(route('brands.store', $data));

        $response->assertStatus(201);
        $this->assertDatabaseHas('brands', ['name' => 'Sally']);
    }

    public function testBrandStoreWithValidationError(): void
    {
        $brand = Brand::factory()->make(['name' => '']);
        $response = $this->postJson(route('brands.store'), $brand->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name field is required.'], $responseKey = 'errors');
        $this->assertDatabaseMissing('brands', ['name' => $brand->name]);
    }

    public function testBrandStoreWithDuplicateValidationError(): void
    {
        $brand = Brand::factory()->create();
        $response = $this->postJson(route('brands.store'), $brand->toArray());
        $response = $this->postJson(route('brands.store'), $brand->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name has already been taken.'], $responseKey = 'errors');
    }

    public function testBrandShow(): void
    {
        $response = $this->withoutExceptionHandling();
        $brand = Brand::factory()->create();
        $response = $this->getJson(route('brands.show', $brand));


        $response->assertStatus(200);
    }

    public function testBrandUpdate(): void
    {
        $response = $this->withoutExceptionHandling();
        $brand = Brand::factory()->create();
        $brand1 = Brand::factory()->make();
        $response = $this->putJson(route('brands.update', $brand), $brand1->toArray());

        $response->assertStatus(200);
        $this->assertDatabaseHas('brands', ['name' => $brand1->name]);
    }

    public function testBrandUpdateWithValidationError(): void
    {
        $brand = Brand::factory()->create();
        $brand1 = Brand::factory()->make(['name' => '']);
        $response = $this->putJson(route('brands.update', $brand), $brand1->toArray());

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('name', $responseKey = 'errors');
        $this->assertDatabaseMissing('brands', ['name' => $brand1->name]);
    }

    public function testBrandDelete(): void
    {
        $brand = Brand::factory()->create();
        $response = $this->withoutExceptionHandling()->deleteJson(route('brands.destroy', $brand));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('brands', ['name' => $brand->name]);
    }
}
