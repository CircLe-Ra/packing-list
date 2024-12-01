@props(['active'])

@php
$classes = ($active ?? false)
            ? 'font-bold bg-neutral text-neutral-content'
            : '';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
