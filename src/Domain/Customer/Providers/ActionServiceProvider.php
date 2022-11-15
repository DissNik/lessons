<?php

namespace Domain\Customer\Providers;

// use Illuminate\Support\Facades\Gate;
use Domain\Customer\Actions\RegisterUserAction;
use Domain\Customer\Contracts\RegisterUserContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterUserContract::class => RegisterUserAction::class
    ];
}
