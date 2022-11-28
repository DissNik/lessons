<?php

namespace App\Sorting;

use Domain\Catalog\Sorter\AbstractSorter;
use Illuminate\Database\Eloquent\Builder;

class PriceSorter extends AbstractSorter
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
