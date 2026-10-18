@props(['name', 'label', 'url' => null, 'help' => 'JPG, PNG or WebP, up to 5 MB.', 'rounded' => false])

<div {{ $attributes }}>
    <span class="form-label">{{ $label }}</span>
    <div class="flex flex-wrap items-start gap-5">
        <div @class(['grid shrink-0 place-items-center overflow-hidden border border-gray-200 bg-gray-50 text-gray-300', 'size-28 rounded-full' => $rounded, 'h-28 w-44 rounded-xl' => ! $rounded])>
            @if ($url)
                <img src="{{ $url }}" alt="" data-image-preview="{{ $name }}" class="size-full object-cover">
            @else
                <img src="" alt="" data-image-preview="{{ $name }}" class="hidden size-full object-cover">
                <x-icon name="image" class="size-8" data-image-placeholder="{{ $name }}" />
            @endif
        </div>
        <div class="grid gap-3">
            <input id="{{ $name }}" name="{{ $name }}" type="file" accept="image/*" data-image-input="{{ $name }}" class="block text-sm text-muted file:mr-3 file:rounded-full file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-sm file:font-bold file:text-brand-700 hover:file:bg-brand-100">
            <p class="text-sm text-muted">{{ $help }}</p>
            @if ($url)
                <label class="flex items-center gap-2 text-sm font-semibold text-red-600">
                    <input type="checkbox" name="remove_{{ $name }}" value="1" class="accent-red-600"> Remove current image
                </label>
            @endif
            @error($name) <p class="form-error">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
