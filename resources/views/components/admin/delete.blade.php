@props(['action', 'confirm' => 'Delete this item? This cannot be undone.', 'label' => 'Delete'])

<form method="POST" action="{{ $action }}" onsubmit="return confirm(@js($confirm))" {{ $attributes->only('class') }}>
    @csrf
    @method('DELETE')
    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-bold text-red-600 hover:bg-red-50">
        <x-icon name="trash" class="size-4" /> {{ $label }}
    </button>
</form>
