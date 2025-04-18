@props(['value' => null, 'selected' => false])

<option value="{{ $value }}" {{ $selected ? 'selected' : '' }}>
    {{ $slot }}
</option>