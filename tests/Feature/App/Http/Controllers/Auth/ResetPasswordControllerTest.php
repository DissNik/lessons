<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::new()->create();
    }

    public function test_reset_page_success(): void
    {
        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $this->user->email,
        ]);

        $this->post(action([ForgotPasswordController::class, 'store']), $request);

        Notification::assertSentTo($this->user, ResetPassword::class, function ($notification) {
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

    public function test_reset_password_success_with_mock()
    {
        $request = ResetPasswordFormRequest::factory()->create([
            'email' => $this->user->email,
        ]);

        Password::shouldReceive('reset')
            ->once()
            ->withSomeOfArgs($request)
            ->andReturn(Password::PASSWORD_RESET);

        $this->post(action([ResetPasswordController::class, 'store']), $request)
            ->assertRedirect(route('login'));
    }

    public function test_reset_password_success(): void
    {
        Event::fake();

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $this->user->email,
        ]);

        $this->post(action([ForgotPasswordController::class, 'store']), $request);

        Notification::assertSentTo($this->user, ResetPassword::class, function ($notification) {
            $request = ResetPasswordFormRequest::factory()->create([
                'token' => $notification->token,
                'email' => $this->user->email,
            ]);

            $response = $this->post(action([ResetPasswordController::class, 'store'], $request));

            $this->assertFalse(Hash::check($request['password'], $this->user->password));

            Event::assertDispatched(PasswordReset::class);

            $response->assertRedirect(route('login'));

            return true;
        });
    }

    public function test_reset_password_with_error_token(): void
    {
        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $this->user->email,
        ]);

        $this->post(action([ForgotPasswordController::class, 'store']), $request);

        Notification::assertSentTo($this->user, ResetPassword::class, function () {
            $request = ResetPasswordFormRequest::factory()->create([
                'token' => Str::random(10),
                'email' => $this->user->email,
            ]);

            $response = $this->post(action([ResetPasswordController::class, 'store'], $request));

            $response->assertInvalid(['email']);

            return true;
        });
    }
}
