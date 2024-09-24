@props(['thead', 'action' => false, 'theadCol' => null])
@php
    $thead = Str::of($thead)->explode(',');
@endphp
<table class="min-w-full overflow-auto divide-y dark:devide-neutral-800">
    <thead>
        <tr class="">
            @foreach ($thead as $key => $th)
                <th class="px-5 py-3 text-xs font-medium text-center uppercase" colspan="{{ $theadCol ?? '' }}">
                    {{ $th }}</th>
            @endforeach
            @if ($action ?? false)
                <th class="px-5 py-3 text-xs font-medium text-center uppercase">Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody class="divide-y ">
        {{ $slot }}
    </tbody>
</table>
