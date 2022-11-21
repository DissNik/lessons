<?php

namespace Domain\Catalog\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterContract
{
    public function title(): string;

    public function key(): string;

    public function apply(Builder $query): Builder;

    public function values(): array;

    public function view(): string;
}
