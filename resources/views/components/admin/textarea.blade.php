@props(['name', 'label', 'value' => null, 'rows' => 4, 'help' => null, 'required' => false])

<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="form-label">{{ $label }} @if ($required)<span class="text-brand-600">*</span>@endif</label>
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" @required($required) {{ $attributes->except('class') }} @class(['form-input', 'border-red-400' => $errors->has($name)])>{{ old($name, $value) }}</textarea>
    @if ($help)
        <p class="mt-1 text-sm text-muted">{{ $help }}</p>
    @endif
    @error($name) <p class="form-error">{{ $message }}</p> @enderror
</div>
