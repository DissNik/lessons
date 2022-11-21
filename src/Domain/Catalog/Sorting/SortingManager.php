<?php

namespace Domain\Catalog\Sorting;

class SortingManager
{
    public function __construct(
        protected array $items = []
    )
    {
    }

    public function registerSorting(array $items): void
    {
        $this->items = $items;
    }

    public function items(): array
    {
        return $this->items;
    }
}
