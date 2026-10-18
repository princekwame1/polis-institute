@if (session('status'))
    <div role="status" class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
        <x-icon name="check-circle" class="mt-0.5 size-5 shrink-0" />
        <p class="font-semibold">{{ session('status') }}</p>
    </div>
@endif
