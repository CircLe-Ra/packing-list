<div>
    <div class=" flex items-center justify-center -mt-4 mb-6 ">
        <div class="relative w-full " wire:click.away="$set('isOpen', false)">
            <button wire:click="toggleDropdown" class=" inline-flex w-full px-4 py-3 text-sm font-medium text-gray-700 bg-base-200 border border-base-100 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-base-100 focus:ring-base-100 justify-between">
                <span class="mr-2 text-sm text-base-content">{{ $selectedItem ?? __('Select?') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            @if($isOpen)
                <div class="absolute mt-2 rounded-md shadow-lg bg-base-300 ring-1 ring-black ring-opacity-5 p-1 space-y-1 z-10 overflow-y-scroll">
                    <!-- Search input -->
                    <input wire:model.live="searchTerm" type="text" placeholder="{{ __('Search') }}" class="block w-full px-4 py-2 text-base-content border-0 rounded-md outline-none ring-0 bg-base-100" autocomplete="off" autofocus>

                    <!-- Filtered items -->
                    @foreach($this->filteredItems as $item)
                        <x-button-link class="text-base-content bg-base-100 border-0 align-middle hover:bg-base-200 active:bg-blue-100 cursor-pointer rounded-md" @click="$dispatch('dropdown-selected', { key : {{ $item['key'] }}, value : '{{ $item['value'] }}' })">
                            {{ $item['value'] }}
                        </x-button-link>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
