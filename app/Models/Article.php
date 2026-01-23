<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'seo_title',
        'seo_description',
        'content',
        'featured_image',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ArticleImage::class)->orderBy('order');
    }
}
