@props(['disabled' => false, 'placeholder' => null, 'type' => 'text', 'labelClass' => '', 'name' => '', 'title' => 'title'])

  <label class="w-full form-control {{ $labelClass }}">
      <div class="label">
          <span class="label-text">{{ __($title) }}</span>
      </div>
    @if($placeholder)
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'input input-bordered w-full ']) !!} placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }} />
    @else
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'input input-bordered w-full ']) !!} {{ $disabled ? 'disabled' : '' }} />
    @endif
    @error($name)
        <div class="-mb-[11px] label">
            <span class="text-red-600 label-text-alt">{{ $message }}</span>
        </div>
    @enderror
  </label>
