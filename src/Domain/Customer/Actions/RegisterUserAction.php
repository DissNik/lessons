<?php

namespace Domain\Customer\Actions;

use Domain\Customer\Contracts\RegisterUserContract;
use Domain\Customer\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction implements RegisterUserContract
{
    public function __invoke(string $name, string $email, string $password)
    {
        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        event(new Registered($user));

        auth()->login($user);
    }
}
