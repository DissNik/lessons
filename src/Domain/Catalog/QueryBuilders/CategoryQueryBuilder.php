<?php

namespace Domain\Catalog\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class CategoryQueryBuilder extends Builder
{
    public function homePage(): CategoryQueryBuilder
    {
        return $this->select(['id', 'title', 'slug', 'thumbnail'])
            ->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }
}
