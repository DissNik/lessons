<?php

namespace Tests\Feature\App\Customer\DTOs;

use App\Http\Requests\SignUpFormRequest;
use Domain\Customer\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    public function test_instance_creates_from_form_request(): void
    {
        $dto = NewUserDTO::fromRequest(new SignUpFormRequest([
            'name' => fake()->name(),
            'email' => fake()->freeEmail(),
            'password' => Str::random(10)
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}
