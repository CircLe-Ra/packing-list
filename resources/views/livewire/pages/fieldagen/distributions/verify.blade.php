<?php

use function Livewire\Volt\{layout, title, state, computed, on, usesPagination, mount};
use App\Models\ShipmentDetail;
use App\Models\Shipment;
use App\Models\Container;
use App\Models\ShipmentItem;
use Masmerise\Toaster\Toaster;

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

    <div>
        <h2 class="card-title">{{ __('Data Containers') }}</h2>
        <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
            <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']"  />
            <x-form.search wire:model.live="search" class="w-32" />
        </div>

        @if($this->shipemt_items && $this->shipemt_items->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
                @foreach($this->shipemt_items as $key => $shipment_item)
                        <x-card class="w-full max-w-1/5 md:w-full bg-base-300 border border-base-200 rounded-lg shadow sm:p-2">
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
                                <x-button-success class="text-white btn-sm" wire:click="verifyItem({{$shipment_item->id}})">{{ __('Verify') }}</x-button-success>
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
