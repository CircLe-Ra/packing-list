@props(['disabled' => false, 'placeholder' => null, 'type' => 'text', 'labelClass' => '', 'name' => ''])

  <label class="w-full form-control {{ $labelClass }}">
    @if($placeholder)
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'w-full input input-bordered']) !!} placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }} />
    @else
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'w-full input input-bordered']) !!} {{ $disabled ? 'disabled' : '' }} />
    @endif
    @error($name)
        <div class="-mb-[11px] label">
            <span class="text-red-600 label-text-alt">{{ $message }}</span>
        </div>
    @enderror
  </label>
