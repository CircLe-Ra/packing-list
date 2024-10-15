@props([
    'crumbs' => [],
])

{{-- <x-ui.marketing.breadcrumbs :crumbs="[
    [
        'href' => '/blog',
        'text' => 'Blog'
    ],
    [
        'text' => 'Title Of Post'
    ]
]" /> --}}

<div {{ $attributes->merge(['class' => 'breadcrumbs text-sm my-4']) }}>
    <ul>
      @foreach($crumbs as $crumb)
            @if(isset($crumb['href']))
                <li><a href="{{ $crumb['href'] }}" wire:navigate>{{ $crumb['text'] }}</a></li>
            @else
                <li>{{ $crumb['text'] }}</li>
            @endif
        @endforeach
    </ul>
  </div>
