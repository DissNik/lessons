<?php

namespace Domain\Cart\StorageIdentities;

use Domain\Cart\Contract\CartIdentityStorageContract;

class SessionIdentityStorage implements CartIdentityStorageContract
{
    public function get(): string
    {
        return session()->getId();
    }
}
