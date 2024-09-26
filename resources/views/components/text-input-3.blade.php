@props(['disabled' => false, 'placeholder' => null, 'type' => 'text', 'labelClass' => '', 'pIcon' => 'left'])

  <label class="input input-bordered flex items-center gap-2 {{ $labelClass }}">
    @if ($pIcon == 'left')
        {!! $icon !!}
    @endif
  @if($placeholder)
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'grow']) !!} placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }} />
    @else
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'grow']) !!} {{ $disabled ? 'disabled' : '' }} />
    @endif
  @if ($pIcon == 'right')
        {!! $icon !!}
    @endif
</label>
