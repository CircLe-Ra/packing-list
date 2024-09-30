@props([
    'name' => null,
    'pdivider' => 'center',

])
<div {{ $attributes->merge(['class' => 'flex flex-col w-full']) }}>
    @if ($pdivider == 'center')
        <div class="divider">{{ __($name) }}</div>
    @elseif ($pdivider == 'start')
        <div class="divider divider-start">{{ __($name) }}</div>
    @elseif ($pdivider == 'end')
        <div class="divider divider-end">{{ __($name) }}</div>
    @endif
  </div>
