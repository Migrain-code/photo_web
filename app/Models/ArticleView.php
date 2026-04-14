<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleView extends Model
{
    protected $fillable = [
        'article_id',
        'date',
        'views_count',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
