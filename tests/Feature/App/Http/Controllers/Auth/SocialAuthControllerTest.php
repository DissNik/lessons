<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SocialAuthController;
use Domain\Customer\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class SocialAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_socialite_redirect_success(): void
    {
        Http::fake([
            'https://github.com/login/oauth/authorize' => Http::response(['ok' => true])
        ]);

        $this->get(action([SocialAuthController::class, 'redirect'], ['driver' => 'github']))
            ->assertRedirect();
    }

    public function test_socialite_callback_success(): void
    {
        $email = fake()->freeEmail;

        $this->assertDatabaseMissing('users', [
            'email' => $email,
        ]);

        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn(rand())
            ->shouldReceive('getName')
            ->andReturn(Str::random(10))
            ->shouldReceive('getEmail')
            ->andReturn($email);

        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $this->get(action([SocialAuthController::class, 'callback'], ['driver' => 'github']))
            ->assertRedirect(route('home'));

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);

        $user = User::query()
            ->where('email', $email)
            ->first();

        $this->assertAuthenticatedAs($user);
    }
}
