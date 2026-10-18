<?php

namespace App\Http\Controllers;

use App\Models\CourseArea;
use App\Models\Facilitator;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Slide;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'slides' => Slide::published()->get(),
            'courseAreas' => CourseArea::ordered()->get(),
            'welcomeImage' => Setting::welcomeImage(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function courses(): View
    {
        return view('pages.courses', [
            'courseAreas' => CourseArea::ordered()->get(),
        ]);
    }

    public function facilitators(): View
    {
        return view('pages.facilitators', [
            'facilitators' => Facilitator::ordered()->get(),
        ]);
    }

    public function admissions(): View
    {
        return view('pages.admissions');
    }

    public function corporate(): View
    {
        return view('pages.corporate');
    }

    public function portal(): View
    {
        return view('pages.portal');
    }

    public function news(Request $request): View
    {
        $category = in_array($request->query('category'), Post::categories(), true) ? $request->query('category') : null;

        return view('pages.news', [
            'category' => $category,
            'posts' => Post::published()
                ->when($category, fn ($query) => $query->where('category', $category))
                ->paginate(9)
                ->withQueryString(),
        ]);
    }

    public function post(Post $post): View
    {
        abort_unless($post->isPublished(), 404);

        return view('pages.post', [
            'post' => $post,
            'related' => Post::published()->whereKeyNot($post->id)->limit(3)->get(),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function faq(): View
    {
        return view('pages.faq', [
            'faqs' => Faq::ordered()->get(),
        ]);
    }

    /**
     * Show one of the website policy pages.
     */
    public function policy(string $policy): View
    {
        return view("pages.policies.{$policy}");
    }
}
