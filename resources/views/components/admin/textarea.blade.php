@props(['name', 'label', 'value' => null, 'rows' => 4, 'help' => null, 'required' => false, 'toolbar' => 'basic'])

<div {{ $attributes->only('class') }}>
    <label id="{{ $name }}-label" for="{{ $name }}" class="form-label">{{ $label }} @if ($required)<span class="text-brand-600">*</span>@endif</label>
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" data-rich-text="{{ $toolbar }}" @required($required) @if ($errors->has($name)) aria-invalid="true" @endif {{ $attributes->except('class') }} @class(['form-input', 'border-red-400' => $errors->has($name)])>{{ \App\Support\RichText::toHtml(old($name, $value)) }}</textarea>
    @if ($help)
        <p class="mt-1 text-sm text-muted">{{ $help }}</p>
    @endif
    @error($name) <p class="form-error">{{ $message }}</p> @enderror
</div>
