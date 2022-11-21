<?php

namespace App\Sorting;

use Domain\Catalog\Sorting\AbstractSorting;
use Illuminate\Database\Eloquent\Builder;

class TitleSorting extends AbstractSorting
{
    public function apply(Builder $query): Builder
    {
        return $query->when($this->isRequestValue(), function (Builder $q) {
            $q->orderBy('title', $this->direction());
        });
    }

    public function values(): array
    {
        return [
            'title' => 'Name product',
        ];
    }
}
