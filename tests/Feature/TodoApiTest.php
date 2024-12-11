<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_todos()
    {
        Todo::factory()->count(5)->create();

        $response = $this->getJson('/api/todos');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function test_can_filter_todos_by_status()
    {
        Todo::factory()->count(3)->create(['status' => 'completed']);
        Todo::factory()->count(2)->create(['status' => 'in progress']);

        $response = $this->getJson('/api/todos?status=completed');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_search_todos()
    {
        Todo::factory()->create(['title' => 'Test Todo']);
        Todo::factory()->create(['title' => 'Another Todo']);

        $response = $this->getJson('/api/todos?search=Test');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_create_todo()
    {
        $todoData = [
            'title' => 'New Todo',
            'details' => 'Todo Details',
            'status' => 'not started'
        ];

        $response = $this->postJson('/api/todos', $todoData);

        $response->assertStatus(201)
            ->assertJson($todoData);
    }

    public function test_can_update_todo()
    {
        $todo = Todo::factory()->create();
        $updateData = [
            'title' => 'Updated Todo',
            'status' => 'completed'
        ];

        $response = $this->putJson("/api/todos/{$todo->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson($updateData);
    }

    public function test_can_delete_todo()
    {
        $todo = Todo::factory()->create();

        $response = $this->deleteJson("/api/todos/{$todo->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }
}
