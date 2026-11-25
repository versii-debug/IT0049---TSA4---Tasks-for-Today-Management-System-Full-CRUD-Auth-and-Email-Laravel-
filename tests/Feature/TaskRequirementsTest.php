<?php

namespace Tests\Feature;

use App\Mail\TaskCompleted;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class TaskRequirementsTest extends TestCase
{
    use RefreshDatabase;

    private function task(array $attributes = []): Task
    {
        return Task::create(array_merge([
            'title' => 'Finish assignment',
            'task_date' => today()->format('Y-m-d'),
            'status' => 'pending',
        ], $attributes));
    }

    public function test_required_pages_are_public_and_management_controls_are_hidden_from_guests(): void
    {
        $task = $this->task();
        $user = User::factory()->create(['name' => 'Public Profile']);

        $this->get('/')->assertOk()->assertSee($task->title);
        $this->get('/tasks')->assertOk()->assertSee($task->title)
            ->assertDontSee(route('tasks.edit', $task->id))
            ->assertDontSee(route('tasks.archive', $task->id))
            ->assertDontSee(route('tasks.archived'))
            ->assertSee('Log in to manage tasks');
        $this->get('/profile')->assertOk()->assertSee($user->name)->assertSee($user->email);
        $this->get('/about')->assertOk()->assertSee('Jsean Eduard');
    }

    public function test_public_profile_handles_an_empty_users_table(): void
    {
        $this->get('/profile')->assertOk()->assertSee('No user found.');
    }

    public function test_welcome_shows_only_todays_active_tasks(): void
    {
        $this->task(['title' => 'Today active']);
        $this->task(['title' => 'Tomorrow active', 'task_date' => today()->addDay()->format('Y-m-d')]);
        $this->task(['title' => 'Today archived', 'is_archived' => true]);

        $this->get('/')->assertOk()->assertSee('Today active')
            ->assertDontSee('Tomorrow active')->assertDontSee('Today archived');
        $this->get('/tasks')->assertOk()->assertSee('Today active')
            ->assertSee('Tomorrow active')->assertDontSee('Today archived');
    }

    public function test_archiving_preserves_data_and_moves_the_task_to_the_archive_list_and_details(): void
    {
        Mail::fake();
        $this->actingAs(User::factory()->create());
        $active = $this->task(['title' => 'Keep active']);
        $archived = $this->task(['title' => 'Move to archive']);
        $createdAt = $archived->created_at;

        $this->patch('/tasks/'.$archived->id.'/archive')->assertRedirect('/tasks');

        $this->assertDatabaseCount('tasks', 2);
        $this->assertDatabaseHas('tasks', [
            'id' => $archived->id,
            'title' => 'Move to archive',
            'status' => 'pending',
            'task_date' => $archived->task_date,
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'is_archived' => 1,
        ]);
        $this->get('/tasks')->assertSee($active->title)->assertDontSee($archived->title)
            ->assertSee('Archived Tasks')->assertSee(route('tasks.archived'));
        $this->get('/tasks/archived')->assertOk()->assertSee($archived->title)
            ->assertDontSee($active->title)->assertSee(route('tasks.archived.show', $archived->id));
        $this->get('/tasks/archived/'.$archived->id)->assertOk()
            ->assertSee($archived->title)->assertSee($archived->task_date)
            ->assertSee('Pending')->assertSee('Archived: Yes')
            ->assertDontSee(route('tasks.edit', $archived->id));
        Mail::assertNothingSent();
    }

    public function test_archive_pages_handle_empty_missing_and_active_records(): void
    {
        $this->actingAs(User::factory()->create());
        $active = $this->task();

        $this->get('/tasks/archived')->assertOk()->assertSee('No archived tasks');
        $this->get('/tasks/archived/'.$active->id)->assertNotFound();
        $this->get('/tasks/archived/99999')->assertNotFound();
        $this->get('/tasks/99999/edit')->assertNotFound();
    }

    public function test_archived_tasks_cannot_be_edited_updated_archived_again_or_deleted(): void
    {
        Mail::fake();
        $this->actingAs(User::factory()->create());
        $task = $this->task(['is_archived' => true]);

        $this->get('/tasks/'.$task->id.'/edit')->assertNotFound();
        $this->put('/tasks/'.$task->id, [
            'title' => 'Changed', 'status' => 'done', 'task_date' => $task->task_date,
        ])->assertNotFound();
        $this->patch('/tasks/'.$task->id.'/archive')->assertNotFound();
        $this->delete('/tasks/'.$task->id)->assertMethodNotAllowed();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id, 'title' => $task->title, 'status' => 'pending', 'is_archived' => 1,
        ]);
        Mail::assertNothingSent();
    }

    public function test_archive_keeps_the_existing_shared_access_model_for_signed_in_users(): void
    {
        $first = User::factory()->create();
        $second = User::factory()->create();
        $this->actingAs($first)->post('/tasks', [
            'title' => 'Shared task', 'status' => 'pending', 'task_date' => today()->format('Y-m-d'),
        ])->assertRedirect('/tasks');
        $task = Task::firstOrFail();

        $this->actingAs($second)->patch('/tasks/'.$task->id.'/archive')->assertRedirect('/tasks');
        $this->actingAs($first)->get('/tasks/archived/'.$task->id)->assertOk()->assertSee('Shared task');
        $this->actingAs($second)->get('/tasks/archived/'.$task->id)->assertOk()->assertSee('Shared task');
    }

    public function test_completion_sends_once_to_the_configured_recipient_with_updated_details(): void
    {
        Mail::fake();
        config(['mail.task_completed_to' => 'reviewer@example.test']);
        $this->actingAs(User::factory()->create());
        $task = $this->task();
        $data = ['title' => 'Finished assignment', 'status' => 'done', 'task_date' => $task->task_date];

        $this->put('/tasks/'.$task->id, $data)->assertRedirect('/tasks');
        Mail::assertSent(TaskCompleted::class, fn ($mail) =>
            $mail->hasTo('reviewer@example.test') && $mail->task->id === $task->id
            && $mail->task->title === 'Finished assignment' && $mail->task->status === 'done'
        );
        $this->put('/tasks/'.$task->id, array_merge($data, ['title' => 'Still done']))->assertRedirect('/tasks');
        Mail::assertSent(TaskCompleted::class, 1);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'done', 'title' => 'Still done']);
    }

    public function test_pending_edits_creation_and_already_done_tasks_do_not_send_completion_mail(): void
    {
        Mail::fake();
        $this->actingAs(User::factory()->create());
        $pending = $this->task();
        $done = $this->task(['status' => 'done']);

        $this->put('/tasks/'.$pending->id, [
            'title' => 'Edited pending', 'status' => 'pending', 'task_date' => $pending->task_date,
        ])->assertRedirect('/tasks');
        $this->put('/tasks/'.$done->id, [
            'title' => 'Edited done', 'status' => 'done', 'task_date' => $done->task_date,
        ])->assertRedirect('/tasks');
        $this->post('/tasks', [
            'title' => 'Created done', 'status' => 'done', 'task_date' => $done->task_date,
        ])->assertRedirect('/tasks');
        Mail::assertNothingSent();
    }

    public function test_a_reopened_task_sends_again_only_when_completed_again(): void
    {
        Mail::fake();
        $this->actingAs(User::factory()->create());
        $task = $this->task(['status' => 'done']);

        foreach (['pending', 'pending', 'done', 'done'] as $status) {
            $this->put('/tasks/'.$task->id, [
                'title' => $task->title, 'status' => $status, 'task_date' => $task->task_date,
            ])->assertRedirect('/tasks');
        }

        Mail::assertSent(TaskCompleted::class, 1);
    }

    public function test_invalid_updates_do_not_change_the_task_or_send_mail(): void
    {
        Mail::fake();
        $this->actingAs(User::factory()->create());
        $task = $this->task();

        foreach (['', str_repeat('x', 151)] as $title) {
            $this->from('/tasks/'.$task->id.'/edit')->put('/tasks/'.$task->id, [
                'title' => $title, 'status' => 'invalid', 'task_date' => '2026-02-30',
            ])->assertRedirect('/tasks/'.$task->id.'/edit')
                ->assertSessionHasErrors(['title', 'status', 'task_date']);
        }

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => $task->title, 'status' => 'pending']);
        Mail::assertNothingSent();
    }

    public function test_client_supplied_archive_flag_is_ignored_when_creating_a_task(): void
    {
        $this->actingAs(User::factory()->create());
        $this->post('/tasks', [
            'title' => 'Active task', 'status' => 'pending',
            'task_date' => today()->format('Y-m-d'), 'is_archived' => true,
        ])->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['title' => 'Active task', 'is_archived' => 0]);
    }

    public function test_log_mailer_generates_one_email_for_a_completion_and_no_repeat(): void
    {
        $path = storage_path('logs/task-mail-test-'.uniqid().'.log');
        config([
            'mail.default' => 'log',
            'mail.mailers.log.channel' => 'task_mail_test',
            'mail.task_completed_to' => 'reviewer@example.test',
            'logging.channels.task_mail_test' => ['driver' => 'single', 'path' => $path, 'level' => 'debug'],
        ]);
        $this->actingAs(User::factory()->create());
        $task = $this->task(['title' => 'Log mail proof']);
        $data = ['title' => $task->title, 'status' => 'done', 'task_date' => $task->task_date];

        try {
            $this->put('/tasks/'.$task->id, $data)->assertRedirect('/tasks');
            $this->put('/tasks/'.$task->id, $data)->assertRedirect('/tasks');
            $message = file_get_contents($path);
            $this->assertStringContainsString('reviewer@example.test', $message);
            $this->assertStringContainsString('Log mail proof', $message);
            $this->assertStringContainsString('Status: done', $message);
            $this->assertSame(1, substr_count($message, 'Subject: Task completed:'));
        } finally {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    public function test_a_mail_failure_rolls_back_the_status_change_so_it_can_be_retried(): void
    {
        $this->actingAs(User::factory()->create());
        $task = $this->task();
        Mail::shouldReceive('to')->once()->andReturnSelf();
        Mail::shouldReceive('send')->once()->andThrow(new RuntimeException('Mail unavailable'));
        $this->withoutExceptionHandling();

        try {
            $this->put('/tasks/'.$task->id, [
                'title' => $task->title, 'status' => 'done', 'task_date' => $task->task_date,
            ]);
            $this->fail('The mail failure should propagate.');
        } catch (RuntimeException $exception) {
            $this->assertSame('Mail unavailable', $exception->getMessage());
        }

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'pending']);
    }

    public function test_task_mutations_require_csrf_tokens(): void
    {
        $this->app['env'] = 'local';
        $this->actingAs(User::factory()->create());
        $task = $this->task();

        $this->post('/tasks')->assertStatus(419);
        $this->put('/tasks/'.$task->id)->assertStatus(419);
        $this->patch('/tasks/'.$task->id.'/archive')->assertStatus(419);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'is_archived' => 0]);
    }
}
