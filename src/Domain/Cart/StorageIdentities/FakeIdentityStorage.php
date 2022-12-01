<?php

namespace Domain\Cart\StorageIdentities;

use Domain\Cart\Contract\CartIdentityStorageContract;

class FakeIdentityStorage implements CartIdentityStorageContract
{
    public function get(): string
    {
        return 'tests';
    }
}
