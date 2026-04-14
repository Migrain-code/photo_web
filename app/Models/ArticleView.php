<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleView extends Model
{
    protected $fillable = [
        'date',
        'views_count',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
