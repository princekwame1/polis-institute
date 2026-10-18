<?php

namespace App\Providers;

use App\Models\CourseArea;
use App\Models\Enquiry;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('components.pagination');

        View::composer(
            ['components.layouts.app', 'components.policy', 'components.enquiry-form', 'pages.*'],
            fn ($view) => $view->with('contact', Setting::contact()),
        );

        View::composer('components.enquiry-form', fn ($view) => $view->with('courseAreas', CourseArea::ordered()->get()));

        View::composer('components.layouts.admin', fn ($view) => $view->with('newEnquiries', Enquiry::whereNull('handled_at')->count()));
    }
}
