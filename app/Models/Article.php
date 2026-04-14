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
        'article_gif',
        'views_count',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ArticleImage::class)->orderBy('order');
    }

    public function views(): HasMany
    {
        return $this->hasMany(ArticleView::class);
    }

    // Toplam görüntülenme sayısını hesapla
    public function getTotalViewsAttribute(): int
    {
        return $this->views()->sum('views_count');
    }
}
