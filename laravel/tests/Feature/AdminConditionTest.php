<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin\Product\Condition;

class AdminConditionTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testConditionIndex(): void
    {
        $response = $this->withoutExceptionHandling();
        $condition = Condition::factory(2)->create();
        $response = $this->getJson(route('admins.conditions.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'slug',
                    'name',
                ]
            ]
        ]);
    }

    public function testConditionStore(): void
    {
        $response = $this->withoutExceptionHandling();
        $data = ['name' => 'Sally', 'slug' => 'sally'];
        $response = $this->postJson(route('admins.conditions.store', $data));

        $response->assertStatus(201);
        $this->assertDatabaseHas('conditions', ['name' => 'Sally']);
    }

    public function testConditionStoreWithValidationError(): void
    {
        $condition = Condition::factory()->make(['name' => '']);
        $response = $this->postJson(route('admins.conditions.store'), $condition->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name field is required.'], $responseKey = 'errors');
        $this->assertDatabaseMissing('categories', ['name' => $condition->name]);
    }

    public function testConditionStoreWithDuplicateValidationError(): void
    {
        $condition = Condition::factory()->create();
        $response = $this->postJson(route('admins.conditions.store'), $condition->toArray());
        $response = $this->postJson(route('admins.conditions.store'), $condition->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name has already been taken.'], $responseKey = 'errors');
    }

    public function testConditionShow(): void
    {
        $response = $this->withoutExceptionHandling();
        $condition = Condition::factory()->create();
        $response = $this->getJson(route('admins.conditions.show', $condition));

        $response->assertJsonStructure([
            'data' => [
                'id',
                'slug',
                'name',
            ]
        ]);
        $response->assertStatus(200);
    }

    public function testConditionUpdate(): void
    {
        $response = $this->withoutExceptionHandling();
        $condition = Condition::factory()->create();
        $condition1 = Condition::factory()->make();
        $response = $this->putJson(route('admins.conditions.update', $condition), $condition1->toArray());

        $response->assertStatus(200);
        $this->assertDatabaseHas('conditions', ['name' => $condition1->name]);
    }

    public function testConditionUpdateWithValidationError(): void
    {
        $condition = Condition::factory()->create();
        $condition1 = Condition::factory()->make(['name' => '']);
        $response = $this->putJson(route('admins.conditions.update', $condition), $condition1->toArray());

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('name', $responseKey = 'errors');
        $this->assertDatabaseMissing('categories', ['name' => $condition1->name]);
    }

    public function testConditionDelete(): void
    {
        $condition = Condition::factory()->create();
        $response = $this->withoutExceptionHandling()->deleteJson(route('admins.conditions.destroy', $condition));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['name' => $condition->name]);
    }
}
