<?php

namespace Database\Seeders;

use App\Models\CourseArea;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\Slide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Load the starting website content from config/prolis.php.
     *
     * Each section is only seeded while its table is empty, so content
     * edited in the admin dashboard is never overwritten.
     */
    public function run(): void
    {
        $this->seedSlides();
        $this->seedCourseAreas();
        $this->seedFaqs();
        $this->seedSettings();
    }

    private function seedSlides(): void
    {
        if (Slide::exists()) {
            return;
        }

        foreach (config('prolis.slides') as $index => $slide) {
            Slide::create([
                'title' => $slide['title'],
                'text' => $slide['text'],
                'image' => $this->copyToStorage(public_path($slide['image']), 'slides'),
                'image_alt' => $slide['image_alt'],
                'primary_button_text' => $slide['buttons'][0][0],
                'primary_button_url' => route($slide['buttons'][0][1], absolute: false),
                'secondary_button_text' => $slide['buttons'][1][0],
                'secondary_button_url' => route($slide['buttons'][1][1], absolute: false),
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedCourseAreas(): void
    {
        if (CourseArea::exists()) {
            return;
        }

        foreach (config('prolis.course_areas') as $index => $area) {
            CourseArea::create([
                'title' => $area['title'],
                'slug' => Str::slug($area['title']),
                'icon' => $area['icon'],
                'summary' => $area['summary'],
                'items' => $area['items'],
                'show_on_home' => $area['home'] ?? true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function seedFaqs(): void
    {
        if (Faq::exists()) {
            return;
        }

        foreach (config('prolis.faqs') as $index => [$question, $answer]) {
            Faq::create(['question' => $question, 'answer' => $answer, 'sort_order' => $index + 1]);
        }
    }

    private function seedSettings(): void
    {
        $defaults = array_intersect_key(config('prolis.contact'), Setting::FIELDS);

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        if (! Setting::where('key', 'welcome_image')->exists()) {
            Setting::create(['key' => 'welcome_image', 'value' => $this->copyToStorage(public_path('images/welcome.jpg'), 'site')]);
        }

        Cache::forget(Setting::CACHE_KEY);
    }

    /**
     * Copy a bundled image onto the public disk and return its stored path.
     */
    private function copyToStorage(string $source, string $directory): ?string
    {
        if (! File::exists($source)) {
            return null;
        }

        $path = $directory.'/'.basename($source);

        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->put($path, File::get($source));
        }

        return $path;
    }
}
