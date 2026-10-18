@props(['type' => 'contact', 'submitLabel' => 'Send Enquiry'])

@php($site = config('prolis'))

<form method="POST" action="{{ route('enquiries.store') }}" {{ $attributes->class('grid gap-5 sm:grid-cols-2') }} novalidate>
    @csrf
    <input type="hidden" name="type" value="{{ $type }}">

    <div class="sm:col-span-2">
        <x-status />
    </div>

    <div>
        <label for="{{ $type }}-name" class="form-label">Full name <span class="text-brand-600">*</span></label>
        <input id="{{ $type }}-name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name" class="form-input">
        @error('name') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="{{ $type }}-email" class="form-label">Email address <span class="text-brand-600">*</span></label>
        <input id="{{ $type }}-email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" class="form-input">
        @error('email') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="{{ $type }}-phone" class="form-label">Phone / WhatsApp @if ($type !== 'contact')<span class="text-brand-600">*</span>@endif</label>
        <input id="{{ $type }}-phone" name="phone" type="tel" value="{{ old('phone') }}" @required($type !== 'contact') autocomplete="tel" class="form-input">
        @error('phone') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    @if ($type === 'contact')
        <div>
            <label for="contact-subject" class="form-label">Subject</label>
            <select id="contact-subject" name="subject" class="form-input">
                @foreach (['Course enquiry', 'Registration assistance', 'Corporate training', 'Other information'] as $subject)
                    <option @selected(old('subject') === $subject)>{{ $subject }}</option>
                @endforeach
            </select>
            @error('subject') <p class="form-error">{{ $message }}</p> @enderror
        </div>
    @endif

    @if ($type === 'corporate')
        <div>
            <label for="corporate-organisation" class="form-label">Organisation <span class="text-brand-600">*</span></label>
            <input id="corporate-organisation" name="organisation" type="text" value="{{ old('organisation') }}" required autocomplete="organization" class="form-input">
            @error('organisation') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="corporate-course" class="form-label">Training area of interest</label>
            <select id="corporate-course" name="course" class="form-input">
                <option value="">Select a training area</option>
                @foreach ($site['corporate_areas'] as $area)
                    <option @selected(old('course') === $area)>{{ $area }}</option>
                @endforeach
            </select>
            @error('course') <p class="form-error">{{ $message }}</p> @enderror
        </div>
    @endif

    @if ($type === 'registration')
        @php($selectedCourse = old('course', request('course')))

        <div>
            <label for="registration-location" class="form-label">Preferred location</label>
            <select id="registration-location" name="location" class="form-input">
                @foreach (['Accra', 'Sunyani'] as $location)
                    <option @selected(old('location') === $location)>{{ $location }}</option>
                @endforeach
            </select>
            @error('location') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="registration-course" class="form-label">Preferred course <span class="text-brand-600">*</span></label>
            <select id="registration-course" name="course" required class="form-input">
                <option value="">Select a course</option>
                @foreach ($courseAreas as $area)
                    <optgroup label="{{ $area->title }}">
                        <option value="{{ $area->title }}" @selected($selectedCourse === $area->title)>{{ $area->title }} (any course)</option>
                        @foreach ($area->items as $course)
                            <option @selected($selectedCourse === $course)>{{ $course }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @error('course') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <fieldset>
            <legend class="form-label">Learning format</legend>
            <div class="flex gap-3">
                @foreach (['online' => 'Online', 'in-person' => 'In person'] as $value => $label)
                    <label class="flex flex-1 cursor-pointer items-center gap-2 rounded-xl border border-gray-300 px-4 py-3 font-semibold has-checked:border-brand-500 has-checked:bg-brand-50 has-checked:text-brand-700">
                        <input type="radio" name="learning_mode" value="{{ $value }}" @checked(old('learning_mode', 'online') === $value) class="accent-brand-600">
                        {{ $label }}
                    </label>
                @endforeach
            </div>
            @error('learning_mode') <p class="form-error">{{ $message }}</p> @enderror
        </fieldset>
    @endif

    <div class="sm:col-span-2">
        <label for="{{ $type }}-message" class="form-label">
            {{ $type === 'contact' ? 'Message' : 'Additional information' }} @if ($type === 'contact')<span class="text-brand-600">*</span>@endif
        </label>
        <textarea id="{{ $type }}-message" name="message" rows="5" @required($type === 'contact') class="form-input">{{ old('message') }}</textarea>
        @error('message') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <button type="submit" class="btn-primary w-full sm:w-auto">{{ $submitLabel }} <x-icon name="arrow" class="size-4" /></button>
    </div>
</form>
