<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    protected const CACHE_KEY = 'settings';
    protected const CACHE_TTL = 3600; // 1 hour

    /**
     * Get a setting value by key
     */
    public function get(string $key, $default = null)
    {
        $settings = $this->all();
        
        if (!isset($settings[$key])) {
            return $default;
        }

        return $settings[$key]->value;
    }

    /**
     * Get all settings as a collection keyed by key
     */
    public function all()
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return Setting::all()->keyBy('key');
        });
    }

    /**
     * Get a setting model by key
     */
    public function getSetting(string $key): ?Setting
    {
        $settings = $this->all();
        return $settings[$key] ?? null;
    }

    /**
     * Clear settings cache
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Get setting value with type handling
     */
    public function getValue(string $key, $default = null)
    {
        $setting = $this->getSetting($key);
        
        if (!$setting) {
            return $default;
        }

        // Handle different types
        switch ($setting->type) {
            case 'checkbox':
                return $setting->value === '1' || $setting->value === 'true' || $setting->value === true;
            case 'number':
                return is_numeric($setting->value) ? (float) $setting->value : $default;
            case 'image':
            case 'file':
                return $setting->value ? asset('storage/' . $setting->value) : $default;
            default:
                return $setting->value ?? $default;
        }
    }
}
