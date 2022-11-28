<?php

namespace Domain\Catalog\Models;

use Database\Factories\BrandFactory;
use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

/**
 * @property string slug
 * @property string title
 * @property string thumbnail
 * @property boolean on_home_page
 * @property integer sorting
 *
 * @method static Brand|BrandQueryBuilder query()
 */
class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected static function newFactory()
    {
        return BrandFactory::new();
    }

    protected function thumbnailDir(): string
    {
        return 'brands';
    }

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_home_page',
        'sorting',
    ];

    public function newCollection(array $models = [])
    {
        return new BrandCollection($models);
    }

    public function newEloquentBuilder($query)
    {
        return new BrandQueryBuilder($query);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
