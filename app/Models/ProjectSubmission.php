<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSubmission extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'services',
    ];

    protected $casts = [
        'services' => 'array',
    ];

    public static function serviceOptions(): array
    {
        return [
            'Brand Strategy' => 'Brand Strategy',
            'Visual Identity' => 'Visual Identity',
            'Packaging & Product' => 'Packaging & Product',
            'Website & Digital' => 'Website & Digital',
            'Sales-Driven Creative' => 'Sales-Driven Creative',
            'Ongoing Partnership' => 'Ongoing Partnership',
        ];
    }
}
