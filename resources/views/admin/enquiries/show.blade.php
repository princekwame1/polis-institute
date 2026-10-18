<x-layouts.admin title="Enquiry from {{ $enquiry->name }}">
    <a href="{{ route('admin.enquiries.index') }}" class="mb-4 inline-flex items-center gap-1.5 text-sm font-bold text-muted hover:text-ink"><x-icon name="arrow-left" class="size-4" /> All enquiries</a>

    <x-admin.header :title="$enquiry->name" :description="$enquiry->typeLabel().' received '.$enquiry->created_at->format('j F Y \a\t g:i a')">
        <form method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}">
            @csrf
            @method('PATCH')
            @if ($enquiry->isHandled())
                <input type="hidden" name="handled" value="0">
                <button type="submit" class="btn-outline"><x-icon name="undo" class="size-4" /> Reopen</button>
            @else
                <input type="hidden" name="handled" value="1">
                <button type="submit" class="btn-primary"><x-icon name="check" class="size-4" /> Mark as handled</button>
            @endif
        </form>
    </x-admin.header>

    <div class="grid gap-8 lg:grid-cols-3">
        <x-admin.panel class="lg:col-span-2">
            <dl class="grid gap-6 sm:grid-cols-2">
                @foreach ([
                    'Email' => $enquiry->email,
                    'Phone' => $enquiry->phone,
                    'Organisation' => $enquiry->organisation,
                    'Course' => $enquiry->course,
                    'Learning format' => $enquiry->learning_mode ? ucfirst(str_replace('-', ' ', $enquiry->learning_mode)) : null,
                    'Preferred location' => $enquiry->location,
                    'Subject' => $enquiry->subject,
                ] as $label => $value)
                    @if ($value)
                        <div>
                            <dt class="text-xs font-extrabold uppercase tracking-wider text-muted">{{ $label }}</dt>
                            <dd class="mt-1 font-semibold">{{ $value }}</dd>
                        </div>
                    @endif
                @endforeach
            </dl>

            @if ($enquiry->message)
                <div class="mt-8 border-t border-gray-100 pt-6">
                    <p class="text-xs font-extrabold uppercase tracking-wider text-muted">Message</p>
                    <p class="mt-2 whitespace-pre-line leading-relaxed">{{ $enquiry->message }}</p>
                </div>
            @endif
        </x-admin.panel>

        <div class="grid content-start gap-6">
            <x-admin.panel>
                <h2 class="font-extrabold">Reply</h2>
                <div class="mt-4 grid gap-2">
                    <a href="mailto:{{ $enquiry->email }}" class="btn-primary"><x-icon name="mail" class="size-4" /> Send email</a>
                    @if ($enquiry->phone)
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $enquiry->phone) }}" class="btn-outline"><x-icon name="phone" class="size-4" /> Call</a>
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $enquiry->phone) }}" target="_blank" rel="noopener" class="btn-outline"><x-icon name="whatsapp" class="size-4" /> WhatsApp</a>
                    @endif
                </div>
            </x-admin.panel>

            <x-admin.panel>
                <p class="text-sm text-muted">
                    Status:
                    <strong class="text-ink">{{ $enquiry->isHandled() ? 'Handled on '.$enquiry->handled_at->format('j M Y') : 'New' }}</strong>
                </p>
                <x-admin.delete :action="route('admin.enquiries.destroy', $enquiry)" confirm="Delete this enquiry? This cannot be undone." label="Delete enquiry" class="-ml-3 mt-4" />
            </x-admin.panel>
        </div>
    </div>
</x-layouts.admin>
