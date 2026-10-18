<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingsRequest;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    use HandlesImageUploads;

    public function edit(): View
    {
        return view('admin.settings.edit', [
            'values' => Setting::contact(),
            'welcomeImage' => Setting::welcomeImage(),
            'welcomeImageAlt' => Setting::get('welcome_image_alt'),
        ]);
    }

    public function update(SettingsRequest $request): RedirectResponse
    {
        Setting::store([
            ...$request->safe()->except('welcome_image'),
            'welcome_image' => $this->syncImage($request, 'welcome_image', 'site', Setting::get('welcome_image')),
        ]);

        return back()->with('status', 'Settings saved.');
    }
}
