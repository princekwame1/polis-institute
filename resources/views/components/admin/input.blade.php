@props(['name', 'label', 'value' => null, 'type' => 'text', 'help' => null, 'required' => false])

<div {{ $attributes->only('class') }}>
    <label for="{{ $name }}" class="form-label">{{ $label }} @if ($required)<span class="text-brand-600">*</span>@endif</label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}" @required($required) {{ $attributes->except('class') }} @class(['form-input', 'border-red-400' => $errors->has($name)])>
    @if ($help)
        <p class="mt-1 text-sm text-muted">{{ $help }}</p>
    @endif
    @error($name) <p class="form-error">{{ $message }}</p> @enderror
</div>
