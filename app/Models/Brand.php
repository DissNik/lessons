<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use App\Traits\Models\HasThumbnail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
