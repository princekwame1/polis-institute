@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-muted">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }}
        </p>

        <ul class="flex flex-wrap items-center gap-1">
            <li>
                @if ($paginator->onFirstPage())
                    <span class="grid size-10 place-items-center rounded-lg text-gray-300" aria-hidden="true"><x-icon name="arrow-left" class="size-4" /></span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="grid size-10 place-items-center rounded-lg text-brand-700 hover:bg-brand-50" aria-label="Previous page"><x-icon name="arrow-left" class="size-4" /></a>
                @endif
            </li>

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="grid size-10 place-items-center text-muted">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="grid size-10 place-items-center rounded-lg bg-brand-600 text-sm font-bold text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="grid size-10 place-items-center rounded-lg text-sm font-bold text-ink hover:bg-brand-50">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            <li>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="grid size-10 place-items-center rounded-lg text-brand-700 hover:bg-brand-50" aria-label="Next page"><x-icon name="arrow" class="size-4" /></a>
                @else
                    <span class="grid size-10 place-items-center rounded-lg text-gray-300" aria-hidden="true"><x-icon name="arrow" class="size-4" /></span>
                @endif
            </li>
        </ul>
    </nav>
@endif
