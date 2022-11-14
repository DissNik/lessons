<?php

namespace Domain\Customer\Contracts;

use Domain\Customer\DTOs\NewUserDTO;

interface RegisterUserContract
{

    public function __invoke(NewUserDTO $data);
}
