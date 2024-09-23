@props([
    'classes' => '',
])

<div class="card {{ $classes }}">
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
