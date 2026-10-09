@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-graphite']) }}>
    {{ $value ?? $slot }}
</label>
