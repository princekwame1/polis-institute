<x-layouts.admin title="FAQs">
    <x-admin.header title="Frequently asked questions" description="Questions and answers shown on the FAQs page.">
        <a href="{{ route('admin.faqs.create') }}" class="btn-primary"><x-icon name="plus" class="size-4" /> Add question</a>
    </x-admin.header>

    @if ($faqs->isEmpty())
        <x-admin.empty icon="help" title="No questions yet" :action="route('admin.faqs.create')" action-label="Add question" />
    @else
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <ul class="divide-y divide-gray-100">
                @foreach ($faqs as $faq)
                    <li class="flex flex-wrap items-start gap-4 p-5">
                        <span class="mt-0.5 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-bold text-muted">#{{ $faq->sort_order }}</span>
                        <div class="min-w-0 flex-1">
                            <p class="font-bold">{{ $faq->question }}</p>
                            <p class="mt-1 line-clamp-2 text-sm text-muted">{{ \App\Support\RichText::plain($faq->answer) }}</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <x-admin.edit-link :href="route('admin.faqs.edit', $faq)" />
                            <x-admin.delete :action="route('admin.faqs.destroy', $faq)" confirm="Delete this question?" />
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</x-layouts.admin>
