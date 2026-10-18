@props(['title'])

@php
    $navigation = [
        ['Overview', [
            ['Dashboard', 'admin.dashboard', 'admin.dashboard', 'dashboard'],
            ['Enquiries', 'admin.enquiries.index', 'admin.enquiries.*', 'inbox'],
        ]],
        ['Website content', [
            ['Home slider', 'admin.slides.index', 'admin.slides.*', 'image'],
            ['Courses', 'admin.course-areas.index', 'admin.course-areas.*', 'book'],
            ['News articles', 'admin.posts.index', 'admin.posts.*', 'news'],
            ['Facilitators', 'admin.facilitators.index', 'admin.facilitators.*', 'users'],
            ['FAQs', 'admin.faqs.index', 'admin.faqs.*', 'help'],
        ]],
        ['Settings', [
            ['Site settings', 'admin.settings.edit', 'admin.settings.*', 'settings'],
            ['My account', 'admin.account.edit', 'admin.account.*', 'user'],
        ]],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} | PROLIS Admin</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside data-admin-sidebar class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col bg-brand-950 text-brand-100 transition-transform lg:static lg:translate-x-0">
            <div class="flex items-center gap-3 border-b border-white/10 px-6 py-5">
                <img src="{{ asset('images/preloader-logo.png') }}" alt="" class="size-11 rounded-full">
                <div>
                    <p class="font-display font-extrabold text-white">PROLIS Institute</p>
                    <p class="text-xs font-semibold text-brand-300">Admin dashboard</p>
                </div>
            </div>

            <nav aria-label="Admin" class="flex-1 overflow-y-auto px-4 py-6">
                @foreach ($navigation as [$group, $items])
                    <p class="mb-2 mt-6 px-3 text-[11px] font-extrabold uppercase tracking-widest text-brand-400 first:mt-0">{{ $group }}</p>
                    <ul class="grid gap-1">
                        @foreach ($items as [$label, $route, $pattern, $icon])
                            @php($isActive = request()->routeIs($pattern))
                            <li>
                                <a href="{{ route($route) }}" @if ($isActive) aria-current="page" @endif @class([
                                    'flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition',
                                    'bg-white/10 text-white' => $isActive,
                                    'hover:bg-white/5 hover:text-white' => ! $isActive,
                                ])>
                                    <x-icon :name="$icon" class="size-5 shrink-0" />
                                    <span class="flex-1">{{ $label }}</span>
                                    @if ($route === 'admin.enquiries.index' && $newEnquiries > 0)
                                        <span class="rounded-full bg-brand-500 px-2 py-0.5 text-xs text-white">{{ $newEnquiries }}</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </nav>

            <div class="border-t border-white/10 p-4">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold hover:bg-white/5 hover:text-white">
                    <x-icon name="external" class="size-5" /> View website
                </a>
            </div>
        </aside>

        <div data-admin-overlay class="fixed inset-0 z-30 hidden bg-black/40 lg:hidden"></div>

        <div class="flex min-w-0 flex-1 flex-col">
            {{-- Top bar --}}
            <header class="sticky top-0 z-20 flex items-center gap-4 border-b border-gray-200 bg-white px-4 py-3 sm:px-8">
                <button type="button" data-admin-sidebar-toggle class="grid size-10 place-items-center rounded-lg border border-gray-200 text-brand-700 lg:hidden" aria-label="Open menu">
                    <x-icon name="menu" class="size-5" />
                </button>
                <p class="flex-1 truncate font-display text-lg font-extrabold">{{ $title }}</p>
                <div class="flex items-center gap-3">
                    <span class="hidden text-sm font-semibold text-muted sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-bold text-muted hover:bg-gray-100 hover:text-ink">
                            <x-icon name="logout" class="size-4" /> <span class="hidden sm:inline">Sign out</span>
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 px-4 py-8 sm:px-8">
                <div class="mx-auto max-w-6xl">
                    @if (session('status'))
                        <div role="status" class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
                            <x-icon name="check-circle" class="mt-0.5 size-5 shrink-0" />
                            <p class="font-semibold">{{ session('status') }}</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
                            <p class="font-bold">Please fix the highlighted fields and try again.</p>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>
