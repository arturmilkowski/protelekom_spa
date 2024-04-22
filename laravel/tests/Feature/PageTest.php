<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin\Product\{Brand, Category, Product};

class PageTest extends TestCase
{
    use RefreshDatabase;

    private $user, $product, $brand, $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->brand = Brand::factory()->create();
        $this->category = Category::factory()->create();
        $this->product = Product::factory()->for($this->brand)->for($this->category)->count(1)->create();
    }

    public function testIndex(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson(route('pages.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'brand_id',
                    'brand',
                    'category_id',
                    'category',
                    'slug',
                    'name',
                    'description',
                    'img',
                    'site_description',
                    'site_keyword',
                    'hide'
                ]
            ]
        ]);
    }

    public function testAbout(): void
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->user);
        $response = $this
            ->actingAs($this->user)
            ->getJson(route('pages.about'));

        $response->assertStatus(200);
    }
}
