<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\AuthenticatedUserController;
use App\Http\Requests\SignInFormRequest;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticatedUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_success(): void
    {
        $this->get(action([AuthenticatedUserController::class, 'create']))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function test_authenticated_success(): void
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

    public function test_authenticated_fail_with_error_email(): void
    {
        $request = SignInFormRequest::factory()->create();

        $this->post(action([AuthenticatedUserController::class, 'store']), $request)
            ->assertSessionHasErrors(['email']);

        $this->assertGuest();
    }

    public function test_authenticated_fail_with_error_password(): void
    {
        $user = UserFactory::new()->create();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $this->post(action([AuthenticatedUserController::class, 'store']), $request)
            ->assertSessionHasErrors(['email']);

        $this->assertGuest();
    }

    public function test_authenticated_fail_with_empty_form(): void
    {
        $this->post(action([AuthenticatedUserController::class, 'store']))
            ->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest();
    }

    public function test_logout_success(): void
    {
        $user = UserFactory::new()->create();

        $this->actingAs($user)
            ->delete(action([AuthenticatedUserController::class, 'destroy']));

        $this->assertGuest();
    }
}
