<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnquiryRequest;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;

class EnquiryController extends Controller
{
    /**
     * Store a contact, registration or corporate training enquiry.
     */
    public function store(StoreEnquiryRequest $request): RedirectResponse
    {
        Enquiry::create($request->validated());

        $message = match ($request->validated('type')) {
            'registration' => 'Thank you for registering your interest. Our team will contact you with the next steps.',
            'corporate' => 'Thank you for your corporate training request. Our team will be in touch shortly.',
            default => 'Thank you for your enquiry. Our team will get back to you shortly.',
        };

        return back()->with('status', $message);
    }
}
