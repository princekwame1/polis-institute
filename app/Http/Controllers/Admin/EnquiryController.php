<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnquiryController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'type' => ['nullable', Rule::in(Enquiry::TYPES)],
            'status' => ['nullable', Rule::in(['new', 'handled'])],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $enquiries = Enquiry::query()
            ->when($filters['type'] ?? null, fn ($query, $type) => $query->where('type', $type))
            ->when(($filters['status'] ?? null) === 'new', fn ($query) => $query->whereNull('handled_at'))
            ->when(($filters['status'] ?? null) === 'handled', fn ($query) => $query->whereNotNull('handled_at'))
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    foreach (['name', 'email', 'phone', 'organisation', 'course', 'message'] as $column) {
                        $query->orWhere($column, 'like', "%{$search}%");
                    }
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.enquiries.index', [
            'enquiries' => $enquiries,
            'filters' => $filters,
        ]);
    }

    public function show(Enquiry $enquiry): View
    {
        return view('admin.enquiries.show', ['enquiry' => $enquiry]);
    }

    /**
     * Mark an enquiry as handled, or reopen it.
     */
    public function update(Request $request, Enquiry $enquiry): RedirectResponse
    {
        $handled = $request->validate(['handled' => ['required', 'boolean']])['handled'];

        $enquiry->update(['handled_at' => $handled ? now() : null]);

        return back()->with('status', $handled ? 'Enquiry marked as handled.' : 'Enquiry reopened.');
    }

    public function destroy(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')->with('status', 'Enquiry deleted.');
    }
}
