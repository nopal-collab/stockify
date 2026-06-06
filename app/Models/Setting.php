<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /*
    |--------------------------------------------------------------------------
    | GET — ambil value berdasarkan key, fallback ke $default jika null
    |--------------------------------------------------------------------------
    */

    public static function get(string $key, $default = null): mixed
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting?->value ?? $default;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | SET — update atau insert setting, lalu clear cache
    |--------------------------------------------------------------------------
    */

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting_{$key}");
    }

    /*
    |--------------------------------------------------------------------------
    | ALL AS ARRAY — { key => value } untuk view
    |--------------------------------------------------------------------------
    */

    public static function allAsArray(): array
    {
        return static::all()->pluck('value', 'key')->toArray();
    }
}