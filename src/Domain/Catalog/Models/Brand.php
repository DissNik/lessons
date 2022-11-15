<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
 * @method static Builder|Brand query()
 * @method Builder|Brand homePage()
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

    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(4);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
