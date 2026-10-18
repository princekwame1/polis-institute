<?php

namespace App\Models;

use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['key', 'value'])]
class Setting extends Model
{
    /** @use HasFactory<SettingFactory> */
    use HasFactory;

    public const CACHE_KEY = 'site-settings';

    /**
     * The settings editable from the admin dashboard, with their labels.
     */
    public const FIELDS = [
        'email' => 'Email address',
        'phone' => 'Telephone',
        'whatsapp' => 'WhatsApp number',
        'locations' => 'Locations',
        'hours' => 'Office hours',
        'facebook' => 'Facebook page URL',
        'instagram' => 'Instagram profile URL',
        'linkedin' => 'LinkedIn page URL',
        'youtube' => 'YouTube channel URL',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }

    /**
     * All stored settings as a key => value map.
     *
     * @return array<string, string|null>
     */
    public static function values(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, fn (): array => static::query()->pluck('value', 'key')->all());
    }

    /**
     * A single stored setting, or the default when it is empty.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        $value = static::values()[$key] ?? null;

        return filled($value) ? $value : $default;
    }

    /**
     * The photo shown in the home page welcome section.
     *
     * @return array{url: string, alt: string}
     */
    public static function welcomeImage(): array
    {
        $path = static::get('welcome_image');

        return [
            'url' => $path ? asset('storage/'.$path) : asset('images/welcome.jpg'),
            'alt' => static::get('welcome_image_alt', 'Professionals attending a training session'),
        ];
    }

    /**
     * Contact details for the website, with stored settings taking priority over the config defaults.
     *
     * @return array<string, string|null>
     */
    public static function contact(): array
    {
        $contact = array_merge(
            config('prolis.contact'),
            array_filter(
                array_intersect_key(static::values(), self::FIELDS),
                fn (?string $value): bool => filled($value),
            ),
        );

        $contact['phone_link'] = preg_replace('/[^\d+]/', '', (string) $contact['phone']);
        $contact['whatsapp_link'] = preg_replace('/\D/', '', (string) $contact['whatsapp']);

        return $contact;
    }

    /**
     * Save several settings at once.
     *
     * @param  array<string, string|null>  $values
     */
    public static function store(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
