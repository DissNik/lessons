<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SocialAuthController;
use Database\Factories\UserFactory;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class SocialAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private function mockSocialiteCallback(string|int $githubId): MockInterface
    {
        $abstractUser = Mockery::mock(SocialiteUser::class);

        $abstractUser
            ->shouldReceive('getId')
            ->once()
            ->andReturn($githubId);

        $abstractUser
            ->shouldReceive('getName')
            ->once()
            ->andReturn(Str::random(10));

        $abstractUser
            ->shouldReceive('getEmail')
            ->once()
            ->andReturn(fake()->freeEmail);

        Socialite::shouldReceive('driver->user')
            ->once()
            ->andReturn($abstractUser);

        return $abstractUser;
    }

    public function test_github_redirect_success(): void
    {
        $this->get(
            action(
                [SocialAuthController::class, 'redirect'],
                ['driver' => 'github']
            )
        )->assertRedirectContains('github.com');
    }

    public function test_redirect_driver_not_found_exception(): void
    {
        $this->expectException(DomainException::class);

        $this
            ->withoutExceptionHandling()
            ->get(
                action(
                    [SocialAuthController::class, 'redirect'],
                    ['driver' => 'google']
                )
            );
    }

    public function test_callback_driver_not_found_exception(): void
    {
        $this->expectException(DomainException::class);

        $this
            ->withoutExceptionHandling()
            ->get(
                action(
                    [SocialAuthController::class, 'callback'],
                    ['driver' => 'google']
                )
            );
    }

    public function test_github_created_user_success(): void
    {
        $githubId = str()->random(10);

        $this->assertDatabaseMissing('users', [
            'github_id' => $githubId
        ]);

        $this->mockSocialiteCallback($githubId);
        $this->get(
            action(
                [SocialAuthController::class, 'callback'],
                ['driver' => 'github']
            )
        )->assertRedirect(route('home'));

        $this->assertDatabaseHas('users', [
            'github_id' => $githubId,
        ]);

        $this->assertAuthenticated();
    }


    public function test_authenticated_by_existing_user(): void
    {
        $githubId = str()->random(10);

        UserFactory::new()->create([
            'github_id' => $githubId
        ]);

        $this->assertDatabaseHas('users', [
            'github_id' => $githubId
        ]);

        $this->mockSocialiteCallback($githubId);
        $this->get(
            action(
                [SocialAuthController::class, 'callback'],
                ['driver' => 'github']
            )
        )->assertRedirect(route('home'));

        $this->assertAuthenticated();
    }
}
