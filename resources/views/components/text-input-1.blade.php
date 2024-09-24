@props(['disabled' => false, 'title' => 'title', 'placeholder' => null, 'type' => 'text', 'labelClass' => ''])


<label class="flex items-center gap-2 input input-bordered {{ $labelClass }}">
    {!! $title !!}
    @if($placeholder)
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'grow border-0 focus:outline-0 focus:ring-0']) !!} placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }} />
    @else
        <input type="{{ $type }}" {!! $attributes->merge(['class' => 'grow border-0 focus:outline-0 focus:ring-0']) !!} {{ $disabled ? 'disabled' : '' }} />
    @endif
</label>
