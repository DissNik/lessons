<?php

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function (Model $model) {
            $model->makeSlug();
        });
    }

    protected function makeSlug(): void
    {
        if (!$this->{$this->slugColumn()}) {
            $slug = $this->slugUnique(
                str($this->{$this->slugFrom()})
                    ->slug()
                    ->value()
            );

            $this->{$this->slugColumn()} = $slug;
        }
    }

    protected function slugUnique(string $slug): string
    {
        $originalSlug = $slug;
        $i = 0;

        while ($this->isSlugExists($slug)) {
            $i++;

            $slug = $originalSlug . '-' . $i;
        }

        return $slug;
    }

    protected function isSlugExists(string $slug): bool
    {
        $query = $this->newQuery()
            ->where($this->slugColumn(), $slug)
            ->where($this->getKeyName(), '!=', $this->getKey())
            ->withoutGlobalScopes();

        return $query->exists();
    }

    protected function slugFrom(): string
    {
        return 'title';
    }

    protected function slugColumn(): string
    {
        return 'slug';
    }
}
