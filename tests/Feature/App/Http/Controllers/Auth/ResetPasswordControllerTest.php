<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use Database\Factories\UserFactory;
use Domain\Customer\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_reset_password_with_error_token(): void
    {
        Notification::fake();
        Event::fake();

        $user = UserFactory::new()->create();

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $this->post(action([ForgotPasswordController::class, 'store']), $request);

        Notification::assertSentTo($user, ResetPassword::class, function () use ($user) {
            $request = ResetPasswordFormRequest::factory()->create([
                'token' => Str::random(10),
                'email' => $user->email,
            ]);

            $response = $this->post(action([ResetPasswordController::class, 'store'], $request));

            $response->assertSessionHasErrors(['email']);

            return true;
        });
    }
}
