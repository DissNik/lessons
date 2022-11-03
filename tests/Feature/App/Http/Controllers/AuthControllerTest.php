<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatedUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Customer\Models\User;
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
        $this->get(action([AuthenticatedUserController::class, 'create']))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function test_sign_in_success(): void
    {
        $password = '12345678';

        $user = UserFactory::new()->create([
            'password' => Hash::make($password)
        ]);

        $request = SignInFormRequest::factory()
            ->create([
                'email' => $user->email,
                'password' => $password,
            ]);

        $response = $this->post(action([AuthenticatedUserController::class, 'store']), $request);

        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

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

    public function test_forgot_page_success(): void
    {
        $this->get(action([ForgotPasswordController::class, 'create']))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    public function test_forgot_password_success(): void
    {
        Notification::fake();

        $user = UserFactory::new()->create();

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $response = $this->post(action([ForgotPasswordController::class, 'store']), $request);

        $response->assertValid();

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_page_success(): void
    {
        Notification::fake();

        $user = UserFactory::new()->create();

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $this->post(action([ForgotPasswordController::class, 'store']), $request);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get(action(
                [
                    ResetPasswordController::class,
                    'create',
                ],
                $notification->token
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

        $user = UserFactory::new()->create();

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $this->post(action([ForgotPasswordController::class, 'store']), $request);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $request = ResetPasswordFormRequest::factory()->create([
                'token' => $notification->token,
                'email' => $user->email,
            ]);

            $response = $this->post(action([ResetPasswordController::class, 'store'], $request));

            $user = User::query()->find($user->id);

            $this->assertTrue(Hash::check($request['password'], $user->password));

            Event::assertDispatched(PasswordReset::class);

            $response->assertRedirect(route('login'));

            return true;
        });
    }

    public function test_logout_success(): void
    {
        $user = UserFactory::new()->create();

        $this->actingAs($user)
            ->delete(action([AuthenticatedUserController::class, 'destroy']));

        $this->assertGuest();
    }
}
