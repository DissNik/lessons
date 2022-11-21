<?php

namespace Domain\Catalog\Sorting;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractSorting
{
    public function __invoke(Builder $query, $next)
    {
        $this->apply($query);

        return $next($query);
    }

    abstract public function apply(Builder $query): Builder;

    abstract public function values(): array;

    public function direction(): string
    {
        return request()->str('sort')->contains('-') ? 'DESC' : 'ASC';
    }

    public function isRequestValue(): bool
    {
        return isset($this->values()[request('sort')]);
    }

}
