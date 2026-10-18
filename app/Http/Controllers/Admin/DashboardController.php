<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseArea;
use App\Models\Enquiry;
use App\Models\Post;
use App\Models\Slide;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                ['label' => 'New enquiries', 'value' => Enquiry::whereNull('handled_at')->count(), 'icon' => 'bell', 'route' => route('admin.enquiries.index', ['status' => 'new'])],
                ['label' => 'Registrations this month', 'value' => Enquiry::where('type', 'registration')->where('created_at', '>=', now()->startOfMonth())->count(), 'icon' => 'graduation', 'route' => route('admin.enquiries.index', ['type' => 'registration'])],
                ['label' => 'Corporate requests', 'value' => Enquiry::where('type', 'corporate')->count(), 'icon' => 'building', 'route' => route('admin.enquiries.index', ['type' => 'corporate'])],
                ['label' => 'Published articles', 'value' => Post::published()->count(), 'icon' => 'news', 'route' => route('admin.posts.index')],
            ],
            'latestEnquiries' => Enquiry::latest()->limit(8)->get(),
            'contentCounts' => [
                'Slides' => [Slide::count(), route('admin.slides.index')],
                'Course areas' => [CourseArea::count(), route('admin.course-areas.index')],
                'Articles' => [Post::count(), route('admin.posts.index')],
            ],
        ]);
    }
}
