<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Database\Factories\CategoryFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

/**
 * @property string slug
 * @property string title
 * @property boolean on_home_page
 * @property integer sorting
 * @property string thumbnail
 *
 * @method static Builder|Brand query()
 * @method Builder|Brand homePage()
 */
class Category extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    protected function thumbnailDir(): string
    {
        return 'categories';
    }

    protected $fillable = [
        'slug',
        'title',
        'on_home_page',
        'sorting',
        'thumbnail',
    ];

    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
