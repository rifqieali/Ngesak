@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 text-[16px] font-semibold leading-5 text-graphite focus:outline-none transition'
            : 'inline-flex items-center px-1 pt-1 text-[16px] font-medium leading-5 text-graphite/80 hover:text-graphite focus:outline-none transition';
$dot = ($active ?? false)
            ? '<span class="ms-2 w-1.5 h-1.5 rounded-full bg-ember inline-block" aria-hidden="true"></span>'
            : '';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}{!! $dot !!}
</a>
