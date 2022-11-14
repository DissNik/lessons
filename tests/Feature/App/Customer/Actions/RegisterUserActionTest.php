<?php

namespace Tests\Feature\App\Customer\Actions;

use Domain\Customer\Contracts\RegisterUserContract;
use Domain\Customer\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_user_created(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'test@nikushkin.ru'
        ]);

        $action = app(RegisterUserContract::class);

        $action(NewUserDTO::make('Test', 'test@nikushkin.ru', '1234567890'));

        $this->assertDatabaseHas('users', [
            'email' => 'test@nikushkin.ru'
        ]);
    }
}
