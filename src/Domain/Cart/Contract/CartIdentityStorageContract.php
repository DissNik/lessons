<?php

namespace Domain\Cart\Contract;

interface CartIdentityStorageContract
{
    public function get(): string;
}
