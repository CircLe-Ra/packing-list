<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-active']) }}>
    {{ $slot }}
</button>
