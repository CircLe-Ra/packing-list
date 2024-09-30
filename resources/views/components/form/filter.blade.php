@props([
    'class' => 'text-sm select-sm',
    'select' => [],
])

<x-select-input {{ $attributes->whereStartsWith('wire:model.live') }} class="{{ $class }}" :witoutValidate="true">
    <option value="" selected> {{ __('All') }}</option>
    @foreach ($select as $key => $value)
        <option value="{{ $value }}">{{ $value }}</option>
    @endforeach
</x-select-input>


