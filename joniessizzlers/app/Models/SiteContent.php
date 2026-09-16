<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'key',
        'label',
        'value',
        'sort_order',
    ];

    public static function getValue(string $page, string $key, string $fallback = ''): string
    {
        return self::where('page', $page)->where('key', $key)->value('value') ?? $fallback;
    }

    public static function getPageEntries(string $page)
    {
        return self::where('page', $page)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    public static function getPageMap(string $page): \Illuminate\Support\Collection
    {
        return self::getPageEntries($page)->keyBy('key');
    }
}
