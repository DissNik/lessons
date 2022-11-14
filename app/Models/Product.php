<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use App\Traits\Models\HasThumbnail;
use Database\Factories\ProductFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string slug
 * @property string title
 * @property integer brand_id
 * @property string thumbnail
 * @property integer price
 * @property boolean on_home_page
 * @property integer sorting
 *
 * @method static Builder|Brand query()
 * @method Builder|Brand homePage()
 */
class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    protected $fillable = [
        'slug',
        'title',
        'brand_id',
        'thumbnail',
        'price',
        'on_home_page',
        'sorting',
    ];

    protected static function newFactory(): Factory
    {
        return new ProductFactory();
    }

    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(8);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
