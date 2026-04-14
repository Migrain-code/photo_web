<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Aktif servisleri sıralı olarak getir
    public static function getActiveServices()
    {
        return self::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->pluck('name')
            ->toArray();
    }
}
