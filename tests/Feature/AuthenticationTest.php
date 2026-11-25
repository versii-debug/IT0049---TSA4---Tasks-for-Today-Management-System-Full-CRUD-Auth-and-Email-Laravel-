<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_authentication_forms(): void
    {
        $this->get('/login')->assertOk()->assertSee('name="_token"', false);
        $this->get('/register')->assertOk()->assertSee('name="password_confirmation"', false);
        $this->get('/')->assertOk()->assertSee('Log in')->assertDontSee('Log out');
    }

    public function test_task_management_and_archived_routes_require_authentication(): void
    {
        foreach ([
            ['GET', '/tasks/archived'],
            ['GET', '/tasks/archived/1'],
            ['GET', '/tasks/create'],
            ['POST', '/tasks'],
            ['GET', '/tasks/1/edit'],
            ['PUT', '/tasks/1'],
            ['PATCH', '/tasks/1/archive'],
        ] as [$method, $uri]) {
            $this->call($method, $uri)->assertRedirect('/login');
        }

        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_users_can_register_with_a_hashed_password(): void
    {
        $this->post('/register', [
            'name' => 'Alex',
            'email' => 'Alex@Example.com',
            'password' => 'a-secure-password',
            'password_confirmation' => 'a-secure-password',
        ])->assertRedirect('/tasks');

        $user = User::where('email', 'alex@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('a-secure-password', $user->password));
        $this->assertAuthenticatedAs($user);
        $this->get('/tasks')->assertOk()->assertSee('Alex');
    }

    public function test_registration_rejects_duplicate_emails_and_unconfirmed_passwords(): void
    {
        User::factory()->create(['email' => 'alex@example.com']);

        $this->from('/register')->post('/register', [
            'name' => 'Alex',
            'email' => 'ALEX@example.com',
            'password' => 'short',
            'password_confirmation' => 'different',
        ])->assertRedirect('/register')->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
        $this->assertNull(session()->getOldInput('password'));
        $this->assertNull(session()->getOldInput('password_confirmation'));
    }

    public function test_login_renews_the_session_and_returns_to_the_requested_page(): void
    {
        $user = User::factory()->create(['email' => 'alex@example.com']);
        $this->get('/tasks/create')->assertRedirect('/login');
        $oldSessionId = session()->getId();

        $this->post('/login', [
            'email' => 'ALEX@example.com',
            'password' => 'password',
        ])->assertRedirect('/tasks/create');

        $this->assertAuthenticatedAs($user);
        $this->assertNotSame($oldSessionId, session()->getId());
        $this->get('/tasks/create')->assertOk();
    }

    public function test_invalid_credentials_use_a_generic_error_and_do_not_flash_passwords(): void
    {
        User::factory()->create(['email' => 'alex@example.com']);

        foreach (['alex@example.com', 'missing@example.com'] as $email) {
            $this->from('/login')->post('/login', [
                'email' => $email,
                'password' => 'incorrect-password',
            ])->assertRedirect('/login')->assertSessionHasErrors([
                'email' => 'Invalid email or password.',
            ]);

            $this->assertGuest();
            $this->assertNull(session()->getOldInput('password'));
        }
    }

    public function test_login_is_throttled_after_five_failures_and_recovers_after_expiry(): void
    {
        $user = User::factory()->create(['email' => 'alex@example.com']);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/login', [
                'email' => $user->email,
                'password' => 'wrong',
            ])->assertSessionHasErrors('email');
        }

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');
        $this->assertStringContainsString('Too many login attempts', session('errors')->first('email'));
        $this->assertGuest();

        $this->travel(61)->seconds();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/tasks');
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_users_are_redirected_away_from_authentication_routes(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/login')->assertRedirect('/tasks');
        $this->get('/register')->assertRedirect('/tasks');
        $this->post('/login')->assertRedirect('/tasks');
        $this->post('/register')->assertRedirect('/tasks');
    }

    public function test_logout_invalidates_the_session_and_requires_post(): void
    {
        $this->actingAs(User::factory()->create());
        $this->get('/')->assertOk()->assertSee('Log out')->assertSee('action="'.route('logout').'"', false);
        $this->withSession(['private_marker' => 'discard-me'])->get('/tasks')->assertOk();
        $oldSessionId = session()->getId();
        $oldToken = session()->token();

        $this->get('/logout')->assertMethodNotAllowed();
        $this->assertAuthenticated();
        $this->post('/logout')->assertRedirect('/login');

        $this->assertGuest();
        $this->assertNull(session('private_marker'));
        $this->assertNotSame($oldSessionId, session()->getId());
        $this->assertNotSame($oldToken, session()->token());
        $this->get('/tasks')->assertOk();
        $this->get('/')->assertOk()->assertDontSee('Log out')->assertSee('Log in');
    }

    public function test_authentication_posts_require_a_valid_csrf_token(): void
    {
        // Laravel normally bypasses CSRF verification in the testing environment.
        $this->app['env'] = 'local';

        $this->post('/login')->assertStatus(419);
        $this->post('/register')->assertStatus(419);
        $this->actingAs(User::factory()->create());
        $this->post('/logout')->assertStatus(419);
        $this->assertAuthenticated();

        $this->withSession(['_token' => 'valid-test-token'])->post('/logout', [
            '_token' => 'valid-test-token',
        ])->assertRedirect('/login');
        $this->assertGuest();
    }
}
