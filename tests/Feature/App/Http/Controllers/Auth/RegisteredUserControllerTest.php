<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Requests\AuthGithubRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Customer\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisteredUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_success(): void
    {
        $this->get(action([RegisteredUserController::class, 'create']))
            ->assertOk()
            ->assertViewIs('auth.sign-up');
    }

    public function test_register_success(): void
    {
        Notification::fake();
        Event::fake();

        $request = SignUpFormRequest::factory()->create();

        $this->assertDatabaseMissing('users', [
            'email' => $request['email'],
        ]);

        $response = $this->post(
            route('register'),
            $request
        );

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email'],
        ]);

        $user = User::query()
            ->where('email', $request['email'])
            ->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }

    public function test_register_fail_with_existing_email(): void
    {
        Event::fake();
        Notification::fake();

        $user = UserFactory::new()->create();

        $request = SignUpFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $response = $this->post(
            route('register'),
            $request
        );

        $response->assertSessionHasErrors('email');

        Notification::assertNothingSentTo($user, NewUserNotification::class);

        $this->assertGuest();
    }

    public function test_register_fail_with_error_password_confirmation(): void
    {
        Notification::fake();
        Event::fake();

        $request = SignUpFormRequest::factory()->create([
            'password_confirmation' => Str::random(10),
        ]);

        $response = $this->post(
            route('register'),
            $request
        );

        $response->assertSessionHasErrors('password');

        Notification::assertNothingSent();

        $this->assertGuest();
    }
}
