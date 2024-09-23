@props(['active'])

@php
$classes = ($active ?? false)
            ? 'font-bold'
            : '';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
