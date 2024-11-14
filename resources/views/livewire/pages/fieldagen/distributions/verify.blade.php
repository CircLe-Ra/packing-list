<?php

use function Livewire\Volt\{layout, title, state, computed, on, usesPagination, mount};
use App\Models\ShipmentDetail;
use App\Models\Shipment;
use App\Models\Container;
use App\Models\ShipmentItem;
use Masmerise\Toaster\Toaster;
use App\Models\Driver;

layout('layouts.app');
title(__('Container'));

state(['shipment_id' => fn($container) => $container, 'shipment_detail_id' => fn($verify) => $verify])->locked();
state(['showing' => 5, 'search' => null])->url();
state(['idData']);
state(['loading' => false]);

usesPagination();

mount(function () {
    if (!Shipment::where('id', $this->shipment_id)->exists()) {
        abort(404);
    }
    if(!ShipmentDetail::where('id', $this->shipment_detail_id)->exists()) {
        abort(404);
    }
});

$shipemt_items = computed(function () {
    return ShipmentItem::where('shipment_detail_id', $this->shipment_detail_id)->paginate($this->showing, pageName: 'distribution-verify-page');
});

$drivers = computed(function () {
    return Driver::whereNotIn('id', function ($query) {
        $query->select('driver_id')->from('distributions');
    })->get();
});

?>

<div>
    <div class="flex justify-between">
        <x-breadcrumb :crumbs="[
                    [
                        'text' => __('Dashboard'),
                        'href' => '/dashboard',
                    ],
                    [
                        'text' => __('Distribution'),
                        'href' => route('distribution'),
                    ],
                    [
                        'text' => __('Container'),
                        'href' => route('distribution.container',$this->shipment_id),
                    ],
                    [
                        'text' => __('Verify Items'),
                    ]
                ]" class="items-start"
        />
    </div>

    <x-form.modal id="modal_add_checklist" class="-mt-2 " :title="__('Checklist Data')">
        <x-select-input name="driver_id" id="driver_id" display_name="vehicle_number,name" wire:model="driver_id" labelClass="-mt-4 mb-3" title="{{ __('Driver') }}" :data="$this->drivers" getData="server"/>

    </x-form.modal>

    <div>
        <h2 class="card-title">{{ __('Data Containers') }}</h2>
        <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
            <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']"  />
            <x-form.search wire:model.live="search" class="w-32" />
        </div>

        @if($this->shipemt_items && $this->shipemt_items->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
                @foreach($this->shipemt_items as $key => $shipment_item)
                        <x-card class="w-full max-w-1/5 md:w-full bg-base-300 border border-base-200 rounded-lg shadow sm:p-2 relative">
                            <div class="absolute top-2 right-2">
                                <div class="tooltip" data-tip="{{ __('Verified') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                        <rect width="24" height="24" fill="none" />
                                        <path fill="#2e74ff" d="m23 12l-2.44-2.79l.34-3.69l-3.61-.82l-1.89-3.2L12 2.96L8.6 1.5L6.71 4.69L3.1 5.5l.34 3.7L1 12l2.44 2.79l-.34 3.7l3.61.82L8.6 22.5l3.4-1.47l3.4 1.46l1.89-3.19l3.61-.82l-.34-3.69zm-12.91 4.72l-3.8-3.81l1.48-1.48l2.32 2.33l5.85-5.87l1.48 1.48z" />
                                    </svg>
                                </div>
                                <div class="tooltip" data-tip="{{ __('Pending') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                        <rect width="24" height="24" fill="none" />
                                        <path fill="#878787" d="m19.03 7.39l1.42-1.42c-.45-.51-.9-.97-1.41-1.41L17.62 6c-1.55-1.26-3.5-2-5.62-2a9 9 0 0 0 0 18c5 0 9-4.03 9-9c0-2.12-.74-4.07-1.97-5.61M13 14h-2V7h2zm2-13H9v2h6z" />
                                    </svg>
                                </div>
                            </div>
                        <div class="flex flex-col text-center mb-4">
                            <h5 class="text-xl font-bold text-base-content leading-5">
                                <span class="block mb-2">{{ __('Container') }}</span>
                                <span>{{ $shipment_item->shipment_detail->container->number_container }}</span>
                            </h5>
                        </div>
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <li class="py-3 sm:py-4 flex flex-row items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-base-content ">
                                        {{ $shipment_item->item_name }}
                                    </h3>
                                </div>
                                <div>
                                    <p class="text-sm text-base-content">
                                        {{ $shipment_item->quantity . " " . __('Cardboard') }}
                                    </p>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4 flex flex-row items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-base-content">
                                        Barang Rusak
                                    </h3>
                                </div>
                                <div>
                                    <p class="text-sm text-base-content">
                                        {{ "0 " . __('Cardboard') }}
                                    </p>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4 flex flex-row items-center justify-center gap-2">
                                    <label for="modal_add_checklist" class="btn btn-sm btn-success text-white">{{ __('Checklist Items') }}</label>
                                    <label for="modal_add_damaged_item" class="btn btn-sm btn-error text-white">{{ __('Damaged Items') }}</label>
                            </li>
                        </ul>
                    </x-card>
                @endforeach
            </div>
            <div class="my-8">
                {{ $this->shipemt_items->links('livewire.pagination') }}
            </div>
        @else
            <div class="m-auto text-center">
                {{ __('No Data') }}
            </div>
        @endif
    </div>

</div>
