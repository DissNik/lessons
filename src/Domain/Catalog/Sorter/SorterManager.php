<?php

namespace Domain\Catalog\Sorter;

class SorterManager
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
