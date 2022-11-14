<?php

namespace Domain\Customer\Actions;

use Domain\Customer\Contracts\RegisterUserContract;
use Domain\Customer\DTOs\NewUserDTO;
use Domain\Customer\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction implements RegisterUserContract
{
    public function __invoke(NewUserDTO $data)
    {
        $user = User::query()->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        event(new Registered($user));

        auth()->login($user);
    }
}
