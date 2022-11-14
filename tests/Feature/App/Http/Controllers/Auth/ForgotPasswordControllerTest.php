<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Requests\ForgotPasswordFormRequest;
use Database\Factories\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_page_success(): void
    {
        $this->get(action([ForgotPasswordController::class, 'create']))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    public function test_forgot_password_success(): void
    {
        $user = UserFactory::new()->create();

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $this->post(action([ForgotPasswordController::class, 'store']), $request)
            ->assertValid();

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_forgot_password_fail_with_error_email(): void
    {
        $request = ForgotPasswordFormRequest::factory()->create();

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);

        $this->post(action([ForgotPasswordController::class, 'store']), $request)
            ->assertInvalid(['email']);

        Notification::assertNothingSent();
    }

    public function test_forgot_password_fail_with_empty_form(): void
    {
        $this->post(action([ForgotPasswordController::class, 'store']))
            ->assertInvalid(['email']);

        Notification::assertNothingSent();
    }
}
