@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-3 rounded-pill text-start text-base font-semibold text-graphite bg-fog focus:outline-none transition'
            : 'block w-full px-4 py-3 rounded-pill text-start text-base font-medium text-graphite/80 hover:text-graphite hover:bg-fog focus:outline-none transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
