@props(['disabled' => false, 'placeholder' => null, 'type' => 'text', 'labelClass' => '', 'pIcon' => 'l', 'name' => ''])

  <label class="input input-bordered flex items-center gap-2 {{ $labelClass }}">
    @if ($pIcon == 'l')
        {!! $icon !!}
    @endif
  @if($placeholder)
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'grow border-0 focus:outline-0 focus:ring-0']) !!} placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }} />
    @else
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'grow border-0 focus:outline-0 focus:ring-0']) !!} {{ $disabled ? 'disabled' : '' }} />
    @endif
  @if ($pIcon == 'r')
        {!! $icon !!}
    @endif
    @error($name)
    <div class="-mb-[11px] label">
        <span class="text-red-600 label-text-alt">{{ $message }}</span>
    </div>
    @enderror
</label>
