<x-layouts.admin title="Enquiries">
    <x-admin.header title="Enquiries" description="Messages, course registrations and corporate training requests sent from the website." />

    <form method="GET" class="mb-6 flex flex-wrap items-end gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="min-w-56 flex-1">
            <label for="search" class="sr-only">Search</label>
            <div class="relative">
                <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-gray-400" />
                <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search name, email, phone or course" class="form-input py-2.5 pl-10">
            </div>
        </div>
        <div>
            <label for="type" class="sr-only">Type</label>
            <select id="type" name="type" class="form-input py-2.5">
                <option value="">All types</option>
                @foreach (\App\Models\Enquiry::TYPE_LABELS as $value => $label)
                    <option value="{{ $value }}" @selected(($filters['type'] ?? null) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status" class="sr-only">Status</label>
            <select id="status" name="status" class="form-input py-2.5">
                <option value="">Any status</option>
                <option value="new" @selected(($filters['status'] ?? null) === 'new')>New</option>
                <option value="handled" @selected(($filters['status'] ?? null) === 'handled')>Handled</option>
            </select>
        </div>
        <button type="submit" class="btn-primary py-2.5">Filter</button>
        @if (array_filter($filters))
            <a href="{{ route('admin.enquiries.index') }}" class="py-2.5 text-sm font-bold text-muted hover:text-ink">Clear</a>
        @endif
    </form>

    @if ($enquiries->isEmpty())
        <x-admin.empty title="No enquiries found">
            {{ array_filter($filters) ? 'Try a different search or filter.' : 'Submissions from the website forms will appear here.' }}
        </x-admin.empty>
    @else
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs font-extrabold uppercase tracking-wider text-muted">
                        <tr>
                            <th class="px-5 py-3">Name</th>
                            <th class="px-5 py-3">Type</th>
                            <th class="hidden px-5 py-3 md:table-cell">Course or subject</th>
                            <th class="px-5 py-3">Received</th>
                            <th class="px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($enquiries as $enquiry)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-4">
                                    <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="font-bold text-ink hover:text-brand-600">{{ $enquiry->name }}</a>
                                    <p class="text-muted">{{ $enquiry->email }}</p>
                                </td>
                                <td class="px-5 py-4 font-semibold">{{ $enquiry->typeLabel() }}</td>
                                <td class="hidden px-5 py-4 text-muted md:table-cell">{{ $enquiry->course ?? $enquiry->subject ?? '' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-muted">{{ $enquiry->created_at->format('j M Y, g:i a') }}</td>
                                <td class="px-5 py-4">
                                    @if ($enquiry->isHandled())
                                        <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-600">Handled</span>
                                    @else
                                        <span class="rounded-full bg-brand-100 px-2.5 py-1 text-xs font-bold text-brand-700">New</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">{{ $enquiries->links() }}</div>
    @endif
</x-layouts.admin>
