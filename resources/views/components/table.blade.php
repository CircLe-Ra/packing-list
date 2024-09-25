@props(['thead', 'action' => false, 'theadCol' => null])
@php
    $thead = Str::of($thead)->explode(',');
@endphp

<table {{ $attributes->merge(['class' => 'table table-zebra']) }}>
    <thead>
        <tr>
            @foreach ($thead as $key => $th)
            <th colspan="{{ $theadCol ?? '' }}">
                {{ __($th) }}</th>
            @endforeach
            @if ($action ?? false)
                <th>{{ __('Action') }}</th>
            @endif
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>
