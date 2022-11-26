<?php

namespace Domain\Catalog\Sorter;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractSorter
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
