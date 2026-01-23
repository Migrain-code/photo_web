<?php

namespace App\Models;

use App\Services\SettingsService;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'name',
        'type',
        'value',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    protected static function booted(): void
    {
        static::saved(function (Setting $setting) {
            app(SettingsService::class)->clearCache();
        });

        static::deleted(function (Setting $setting) {
            app(SettingsService::class)->clearCache();
        });
    }
}
