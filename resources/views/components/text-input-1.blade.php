@props(['disabled' => false, 'title' => 'title', 'placeholder' => null, 'type' => 'text', 'labelClass' => '', 'name' => ''])


<label class="flex items-center gap-2 input input-bordered {{ $labelClass }}">
    {!! $title !!}
    @if($placeholder)
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'grow border-0 focus:outline-0 focus:ring-0']) !!} placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }} />
    @else
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'grow border-0 focus:outline-0 focus:ring-0']) !!} {{ $disabled ? 'disabled' : '' }} />
    @endif
    @error($name)
    <div class="-mb-[11px] label">
        <span class="text-red-600 label-text-alt">{{ $message }}</span>
    </div>
    @enderror
</label>
