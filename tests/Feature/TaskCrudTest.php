<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_can_be_created(): void
    {
        $response = $this->post('/tasks', [
            'title' => 'Finish assignment',
            'status' => 'pending',
            'task_date' => '2026-11-20',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'title' => 'Finish assignment',
            'status' => 'pending',
            'task_date' => '2026-11-20',
            'is_archived' => 0,
        ]);
    }

    public function test_task_forms_reject_invalid_data(): void
    {
        $response = $this->from('/tasks/create')->post('/tasks', [
            'title' => '',
            'status' => 'invalid',
            'task_date' => 'not-a-date',
        ]);

        $response->assertRedirect('/tasks/create');
        $response->assertSessionHasErrors(['title', 'status', 'task_date']);
    }

    public function test_tasks_can_be_updated(): void
    {
        $task = Task::create([
            'title' => 'Old title',
            'status' => 'pending',
            'task_date' => '2026-11-20',
        ]);

        $response = $this->put('/tasks/'.$task->id, [
            'title' => 'Updated title',
            'status' => 'done',
            'task_date' => '2026-11-21',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated title',
            'status' => 'done',
            'task_date' => '2026-11-21',
        ]);
    }

    public function test_tasks_can_be_archived_without_being_deleted(): void
    {
        $task = Task::create([
            'title' => 'Archive this task',
            'status' => 'pending',
            'task_date' => '2026-11-20',
        ]);

        $response = $this->patch('/tasks/'.$task->id.'/archive');

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_archived' => 1,
        ]);

        $this->get('/tasks')->assertDontSee('Archive this task');
    }
}
