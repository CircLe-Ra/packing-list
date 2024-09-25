@props([
    'id' => null,
    'name' => null,
    'getData' => 'manual',
    'data' => [],
    'value' => 'id',
    'display_name' => 'name',
    'disabled' => false,
    'witoutValidate' => false,
])


<label class="w-full max-w-xs form-control">
    <select  {{ $attributes->whereStartsWith('wire:model') }} id="{{ $id ?? '' }}" name="{{ $name ?? '' }}" @if ($disabled) disabled @endif {{  $attributes->merge(['class' => 'select select-bordered']) }} autofocus>
      @if ($getData == 'server')
        <option disabled selected>Pilih?</option>
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
    @if (!$witoutValidate)
        <div class="label">
        <span class="label-text-alt">Alt label</span>
        </div>
    @endif
  </label>

