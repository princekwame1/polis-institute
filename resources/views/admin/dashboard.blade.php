<x-layouts.admin title="Dashboard">
    <x-admin.header title="Welcome back, {{ auth()->user()->name }}" description="Here is what is happening on the website." />

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <a href="{{ $stat['route'] }}" class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-brand-200 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="icon-tile size-11 group-hover:bg-brand-600 group-hover:text-white"><x-icon :name="$stat['icon']" class="size-5" /></span>
                    <x-icon name="arrow" class="size-4 text-gray-300 transition group-hover:translate-x-1 group-hover:text-brand-600" />
                </div>
                <p class="mt-5 font-display text-3xl font-extrabold">{{ $stat['value'] }}</p>
                <p class="mt-1 text-sm font-semibold text-muted">{{ $stat['label'] }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-8 xl:grid-cols-3">
        <x-admin.panel class="xl:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-extrabold">Latest enquiries</h2>
                <a href="{{ route('admin.enquiries.index') }}" class="text-sm font-bold text-brand-600 hover:underline">View all</a>
            </div>

            @if ($latestEnquiries->isEmpty())
                <p class="mt-6 rounded-xl bg-gray-50 p-6 text-center text-muted">No enquiries yet. Submissions from the website forms will appear here.</p>
            @else
                <ul class="mt-4 divide-y divide-gray-100">
                    @foreach ($latestEnquiries as $enquiry)
                        <li>
                            <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="flex items-center gap-4 rounded-lg px-2 py-3 hover:bg-gray-50">
                                <span @class(['size-2.5 shrink-0 rounded-full', 'bg-brand-500' => ! $enquiry->isHandled(), 'bg-gray-200' => $enquiry->isHandled()])></span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate font-bold">{{ $enquiry->name }}</p>
                                    <p class="truncate text-sm text-muted">{{ $enquiry->typeLabel() }}@if ($enquiry->course) · {{ $enquiry->course }}@endif</p>
                                </div>
                                <span class="shrink-0 text-xs font-semibold text-muted">{{ $enquiry->created_at->diffForHumans() }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-admin.panel>

        <div class="grid content-start gap-8">
            <x-admin.panel>
                <h2 class="text-lg font-extrabold">Website content</h2>
                <ul class="mt-4 grid gap-2">
                    @foreach ($contentCounts as $label => [$count, $url])
                        <li>
                            <a href="{{ $url }}" class="flex items-center justify-between rounded-lg px-3 py-2.5 font-semibold hover:bg-gray-50">
                                {{ $label }} <span class="rounded-full bg-brand-50 px-2.5 py-0.5 text-sm font-bold text-brand-700">{{ $count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </x-admin.panel>

            <x-admin.panel>
                <h2 class="text-lg font-extrabold">Quick actions</h2>
                <div class="mt-4 grid gap-2">
                    <a href="{{ route('admin.posts.create') }}" class="btn-primary"><x-icon name="plus" class="size-4" /> Write an article</a>
                    <a href="{{ route('admin.slides.create') }}" class="btn-outline"><x-icon name="image" class="size-4" /> Add a slide</a>
                </div>
            </x-admin.panel>
        </div>
    </div>
</x-layouts.admin>
