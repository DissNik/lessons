<?php

namespace App\Sorting;

use Domain\Catalog\Sorting\AbstractSorting;
use Illuminate\Database\Eloquent\Builder;

class PriceSorting extends AbstractSorting
{
    public function apply(Builder $query): Builder
    {
        return $query->when($this->isRequestValue(), function (Builder $q) {
            $q->orderBy('price', $this->direction());
        });
    }

    public function values(): array
    {
        return [
            'price' => 'Price low to high',
            '-price' => 'Price high to low'
        ];
    }
}
