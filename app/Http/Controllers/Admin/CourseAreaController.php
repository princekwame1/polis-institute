<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseAreaRequest;
use App\Models\CourseArea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CourseAreaController extends Controller
{
    public function index(): View
    {
        return view('admin.course-areas.index', ['courseAreas' => CourseArea::ordered()->get()]);
    }

    public function create(): View
    {
        return view('admin.course-areas.form', ['courseArea' => new CourseArea(['show_on_home' => true, 'icon' => 'book', 'items' => [], 'sort_order' => CourseArea::max('sort_order') + 1])]);
    }

    public function store(CourseAreaRequest $request): RedirectResponse
    {
        CourseArea::create($request->courseAreaData());

        return redirect()->route('admin.course-areas.index')->with('status', 'Course area added.');
    }

    public function edit(CourseArea $courseArea): View
    {
        return view('admin.course-areas.form', ['courseArea' => $courseArea]);
    }

    public function update(CourseAreaRequest $request, CourseArea $courseArea): RedirectResponse
    {
        $courseArea->update($request->courseAreaData());

        return redirect()->route('admin.course-areas.index')->with('status', 'Course area updated.');
    }

    public function destroy(CourseArea $courseArea): RedirectResponse
    {
        $courseArea->delete();

        return redirect()->route('admin.course-areas.index')->with('status', 'Course area deleted.');
    }
}
