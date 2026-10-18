<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FacilitatorRequest;
use App\Models\Facilitator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FacilitatorController extends Controller
{
    use HandlesImageUploads;

    public function index(): View
    {
        return view('admin.facilitators.index', ['facilitators' => Facilitator::ordered()->get()]);
    }

    public function create(): View
    {
        return view('admin.facilitators.form', ['facilitator' => new Facilitator(['sort_order' => Facilitator::max('sort_order') + 1])]);
    }

    public function store(FacilitatorRequest $request): RedirectResponse
    {
        Facilitator::create([
            ...$request->safe()->except('photo'),
            'photo' => $this->syncImage($request, 'photo', 'facilitators'),
        ]);

        return redirect()->route('admin.facilitators.index')->with('status', 'Profile added.');
    }

    public function edit(Facilitator $facilitator): View
    {
        return view('admin.facilitators.form', ['facilitator' => $facilitator]);
    }

    public function update(FacilitatorRequest $request, Facilitator $facilitator): RedirectResponse
    {
        $facilitator->update([
            ...$request->safe()->except('photo'),
            'photo' => $this->syncImage($request, 'photo', 'facilitators', $facilitator->photo),
        ]);

        return redirect()->route('admin.facilitators.index')->with('status', 'Profile updated.');
    }

    public function destroy(Facilitator $facilitator): RedirectResponse
    {
        $this->deleteImage($facilitator->photo);
        $facilitator->delete();

        return redirect()->route('admin.facilitators.index')->with('status', 'Profile deleted.');
    }
}
