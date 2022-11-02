<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_success(): void
    {
        $this->get(action([AuthController::class, 'index']))
            ->assertOk()
            ->assertViewIs('auth.index');
    }

    public function test_sign_in_success(): void
    {
        $password = '12345678';

        $user = User::factory()->create([
            'password' => Hash::make($password)
        ]);

        $request = SignInFormRequest::factory()
            ->create([
                'email' => $user->email,
                'password' => $password,
            ]);

        $response = $this->post(action([AuthController::class, 'signIn']), $request);

        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_sign_up_page_success(): void
    {
        $this->get(action([AuthController::class, 'signUp']))
            ->assertOk()
            ->assertViewIs('auth.sign-up');
    }

    public function test_store_success(): void
    {
        Notification::fake();
        Event::fake();

        $request = SignUpFormRequest::factory()->create();

        $this->assertDatabaseMissing('users', [
            'email' => $request['email'],
        ]);

        $response = $this->post(
            route('store'),
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

    public function test_forgot_page_success(): void
    {
        $this->get(action([AuthController::class, 'forgot']))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    public function test_forgot_password_success(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $response = $this->post(action([AuthController::class, 'forgotPassword']), $request);

        $response->assertValid();

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_page_success(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $this->post(action([AuthController::class, 'forgotPassword']), $request);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get(action([
                AuthController::class,
                'reset',
            ], $notification->token
            ));

            $response->assertOk()
                ->assertViewIs('auth.reset-password');

            return true;
        });
    }

    public function test_reset_password_success(): void
    {
        Notification::fake();
        Event::fake();

        $user = User::factory()->create();

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $this->post(action([AuthController::class, 'forgotPassword']), $request);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $request = ResetPasswordFormRequest::factory()->create([
                'token' => $notification->token,
                'email' => $user->email,
            ]);

            $response = $this->post(action([AuthController::class, 'resetPassword'], $request));

            $user = User::query()->find($user->id);

            $this->assertTrue(Hash::check($request['password'], $user->password));

            Event::assertDispatched(PasswordReset::class);

            $response->assertRedirect(route('login'));

            return true;
        });
    }

    public function test_logout_success(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->delete(action([AuthController::class, 'logOut']));

        $this->assertGuest();
    }
}
