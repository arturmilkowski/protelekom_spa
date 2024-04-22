<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AdminSlugTest extends TestCase
{
    use RefreshDatabase;

    public function testSlugCreate(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->postJson(route('admins.slugs', ['text' => 'Jakiś tekst']));

        $response->assertStatus(200)->assertJson(['slug' => 'jakis-tekst']);
    }
}
