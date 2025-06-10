<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_tasks()
    {
        $user = User::factory()->create();
        Task::factory()->count(3)->for($user)->create();

        $response = $this->actingAs($user)->getJson('/api/tasks');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();
        $payload = [
            'title' => 'Nova tarefa',
            'description' => 'Descrição da tarefa',
            'status' => 'pending',
            'deadline' => now()->addDay()->toDateString(),
        ];

        $response = $this->actingAs($user)->postJson('/api/tasks', $payload);
        $response->assertCreated();
        $this->assertDatabaseHas('tasks', ['title' => 'Nova tarefa']);
    }

    public function test_user_can_view_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        $response = $this->actingAs($user)->getJson("/api/tasks/{$task->id}");
        $response->assertOk()->assertJson(['id' => $task->id]);
    }

    public function test_user_can_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();
        $payload = [
            'title' => 'Atualizado',
            'description' => 'Nova descrição',
            'status' => 'completed',
            'deadline' => now()->addDays(2)->toDateString(),
        ];

        $response = $this->actingAs($user)->putJson("/api/tasks/{$task->id}", $payload);
        $response->assertOk()->assertJson(['title' => 'Atualizado']);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Atualizado']);
    }

    public function test_user_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        $response = $this->actingAs($user)->deleteJson("/api/tasks/{$task->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
