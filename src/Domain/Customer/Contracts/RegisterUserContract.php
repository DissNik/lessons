<?php

namespace Domain\Customer\Contracts;

interface RegisterUserContract
{

    public function __invoke(string $name, string $email, string $password);
}
