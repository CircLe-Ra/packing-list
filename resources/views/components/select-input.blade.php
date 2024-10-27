@props([
    'id' => null,
    'name' => null,
    'getData' => 'manual',
    'data' => [],
    'value' => 'id',
    'display_name' => 'name',
    'disabled' => false,
    'withoutValidate' => false,
    'labelClass' => null,
    'title' => null,
])


<label class="w-full form-control {{ $labelClass }}">
    @if($title)
        <div class="label">
            <span class="label-text">{{ __($title) }}</span>
        </div>
    @endif
    <select  {{ $attributes->whereStartsWith('wire:model') }} id="{{ $id ?? '' }}" name="{{ $name ?? '' }}" @if ($disabled) disabled @endif {{  $attributes->merge(['class' => 'select select-bordered']) }} autofocus>
      @if ($getData == 'server')
        <option selected>Pilih?</option>
        @if (count($data))
            @foreach ($data as $dt)
                <option value="{{ $dt->$value }}">&nbsp;{{ $dt->$display_name }}</option>
            @endforeach
        @else
            <option value="" disabled>Tidak ada data</option>
        @endif
    @else
        {{ $slot }}
    @endif
    </select>
    @if (!$withoutValidate)
        @error($name)
            <div class="label">
                <span class="label-text-alt text-red-600">{{ $message }}</span>
            </div>
        @enderror
    @endif
  </label>

