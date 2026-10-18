<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SlideRequest;
use App\Models\Slide;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SlideController extends Controller
{
    use HandlesImageUploads;

    public function index(): View
    {
        return view('admin.slides.index', ['slides' => Slide::orderBy('sort_order')->orderBy('id')->get()]);
    }

    public function create(): View
    {
        return view('admin.slides.form', ['slide' => new Slide(['is_active' => true, 'sort_order' => Slide::max('sort_order') + 1])]);
    }

    public function store(SlideRequest $request): RedirectResponse
    {
        Slide::create([
            ...$request->safe()->except('image'),
            'image' => $this->syncImage($request, 'image', 'slides'),
        ]);

        return redirect()->route('admin.slides.index')->with('status', 'Slide added.');
    }

    public function edit(Slide $slide): View
    {
        return view('admin.slides.form', ['slide' => $slide]);
    }

    public function update(SlideRequest $request, Slide $slide): RedirectResponse
    {
        $slide->update([
            ...$request->safe()->except('image'),
            'image' => $this->syncImage($request, 'image', 'slides', $slide->image),
        ]);

        return redirect()->route('admin.slides.index')->with('status', 'Slide updated.');
    }

    public function destroy(Slide $slide): RedirectResponse
    {
        $this->deleteImage($slide->image);
        $slide->delete();

        return redirect()->route('admin.slides.index')->with('status', 'Slide deleted.');
    }
}
