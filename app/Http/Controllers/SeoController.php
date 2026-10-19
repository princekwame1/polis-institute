<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * The public pages listed in the sitemap, by route name.
     *
     * @var list<string>
     */
    private const PAGES = ['home', 'about', 'courses', 'facilitators', 'admissions', 'corporate', 'news', 'contact', 'faq', 'portal'];

    /**
     * @var list<string>
     */
    private const POLICIES = ['privacy-policy', 'terms-and-conditions', 'registration-and-refund-policy'];

    public function sitemap(): Response
    {
        return response()
            ->view('sitemap', [
                'pages' => array_map(fn (string $name): string => route($name), self::PAGES),
                'policies' => array_map(fn (string $policy): string => route('policy', $policy), self::POLICIES),
                'posts' => Post::published()->get(['slug', 'updated_at']),
            ])
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode(PHP_EOL, $lines).PHP_EOL)->header('Content-Type', 'text/plain');
    }
}
