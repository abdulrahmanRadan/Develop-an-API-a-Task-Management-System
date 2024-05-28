<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'pending',
        ]);

        $response->assertStatus(201)
                ->assertJson([
                    'title' => 'Test Task',
                    'description' => 'Test Description',
                    'status' => 'pending',
                ]);
    }

    // Additional tests for other endpoints...
}
