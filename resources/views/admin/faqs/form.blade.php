<x-layouts.admin :title="$faq->exists ? 'Edit question' : 'Add question'">
    <a href="{{ route('admin.faqs.index') }}" class="mb-4 inline-flex items-center gap-1.5 text-sm font-bold text-muted hover:text-ink"><x-icon name="arrow-left" class="size-4" /> FAQs</a>
    <x-admin.header :title="$faq->exists ? 'Edit question' : 'Add question'" />

    <form method="POST" action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}">
        @csrf
        @if ($faq->exists) @method('PUT') @endif

        <x-admin.panel class="grid gap-6">
            <x-admin.input name="question" label="Question" :value="$faq->question" required />
            <x-admin.textarea name="answer" label="Answer" :value="$faq->answer" rows="5" required />
            <x-admin.input name="sort_order" label="Position" type="number" min="0" :value="$faq->sort_order" required help="Lower numbers show first." class="max-w-xs" />
        </x-admin.panel>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn-primary">{{ $faq->exists ? 'Save changes' : 'Add question' }}</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
