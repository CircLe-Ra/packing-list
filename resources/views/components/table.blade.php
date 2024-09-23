@props(['thead', 'action' => false, 'theadCol' => null])
@php
    $thead = Str::of($thead)->explode(',');
@endphp
<table class="min-w-full overflow-auto divide-y divide-neutral-200 dark:devide-neutral-800">
    <thead>
        <tr class="text-neutral-500 dark:text-neutral-50">
            @foreach ($thead as $key => $th)
                <th class="px-5 py-3 text-xs font-medium text-center uppercase" colspan="{{ $theadCol ?? '' }}">
                    {{ $th }}</th>
            @endforeach
            @if ($action ?? false)
                <th class="px-5 py-3 text-xs font-medium text-center uppercase">Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-500">
        {{ $slot }}
    </tbody>
</table>
