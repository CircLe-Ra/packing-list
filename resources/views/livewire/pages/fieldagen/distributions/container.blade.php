<?php

use function Livewire\Volt\{layout, title, state, computed, on, usesPagination, mount};
use App\Models\ShipmentDetail;
use App\Models\Shipment;
use App\Models\Container;
use App\Models\ShipmentItem;
use Masmerise\Toaster\Toaster;

layout('layouts.app');
title(__('Container'));

state(['shipment_id' => fn($id) => $id])->locked();
state(['showing' => 5, 'search' => null])->url();
state(['container_id' => '']);
state(['idData', 'dropdownCondition', 'modalDetailShipmentId']);
state(['item' => '', 'quantity' => '', 'loading' => false]);

usesPagination();

mount(function () {
    if (!Shipment::where('id', $this->shipment_id)->exists()) {
        abort(404);
    }
});
$shipment_details = computed(function () {
    return ShipmentDetail::where('shipment_id', $this->shipment_id)->paginate($this->showing, pageName: 'shipment-detail-page');
});

on(
    [
        'refresh' => function () {
            $this->shipment_details = ShipmentDetail::where('shipment_id', $this->shipment_id)->paginate($this->showing, pageName: 'shipment-detail-page');
            $this->dispatch('refresh-dropdown-search');
        },
        'close-modal-x' => function () {
            $this->reset('item', 'quantity', 'idData', 'container_id');
            $this->dispatch('refresh-dropdown-search');
            $this->resetValidation(['item', 'quantity', 'idData', 'container_id']);
            $this->modalDetailShipmentId = null;
        },
        'set-id' => fn ($id) => $this->idData = $id,
        'dropdown-toggle' => fn ($condition) => $this->dropdownCondition = $condition,
        'dropdown-selected' => fn ($key, $value) => $this->container_id = $key,
        'show-item-details' => function ($id) {
            $this->loading = true;
            $this->modalDetailShipmentId = $id;
        },
    ]
);

$saveItem = function ($action) {
    $this->validate([
        'item' => 'required',
        'quantity' => 'required',
    ]);
    try {
        ShipmentItem::create([
            'shipment_detail_id' => $this->idData,
            'item_name' => $this->item,
            'quantity' => $this->quantity
        ]);
        if ($action == 'save') {
            $this->reset(['item', 'quantity', 'idData']);
            $this->dispatch('close-modal', 'modal_container_item');
        } else {
            $this->reset(['item', 'quantity']);
        }
        $this->dispatch('refresh');
        unset($this->shipment_details);
        Toaster::success(__('Item has been added'));
    } catch (Exception $e) {
        $this->reset(['item', 'quantity', 'idData']);
        $this->dispatch('close-modal', 'modal_container_item');
        Toaster::error(__('Item could not be added'));
    }
};

$getShipmentItems = function ($shipmentDetailId) {
    $items = ShipmentItem::where('shipment_detail_id', $shipmentDetailId)->get();
    $this->loading = false;
    return $items;
};
$itemsCount = function ($shipmentDetailId){
    return ShipmentItem::where('shipment_detail_id', $shipmentDetailId)
        ->select('item_name')
        ->distinct()
        ->count();
};
$totalQuantity = function ($shipmentDetailId) {
    return ShipmentItem::where('shipment_detail_id', $shipmentDetailId)
        ->sum('quantity');
};

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
                        'text' => __('Container')
                    ]
                ]" class="items-start"
        />
    </div>

    <!-- Modal for Adding Container -->
    <x-form.modal id="modal_container_item" class="-mt-2 " :title="__('Verify Items')">
        <x-text-input-4 name="item" wire:model="item" labelClass="-mt-4 mb-3" title="{{ __('Item') }}" />
        <x-text-input-4 type="number" name="quantity" wire:model="quantity" labelClass="my-3" title="{{ __('Quantity') }}" />
        <div class="flex justify-end space-x-3">
            <x-button-info class="text-white" wire:click="saveItem('save')">{{ __('Save') }}</x-button-info>
            <x-button-success class="text-white"  wire:click="saveItem('save_add')">{{ __('Save & Add More') }}</x-button-success>
        </div>
    </x-form.modal>

    <!-- Modal for Item Details in Container -->
    <x-form.modal id="modal_item_details" class="-mt-2 " :title="__('Item Details')">
        <div>
            <div class="{{ $this->loading ? 'hidden' : '' }}">
                <div class="flex justify-center items-center">
                    <span class="loading loading-dots loading-lg"></span>
                </div>
            </div>
            <div class="{{ $this->loading ? '' : 'hidden' }}">
                <table class="table w-full">
                    <thead class="text-center">
                    <tr>
                        <th>{{ __('Item Name') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Item Damaged') }}</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($this->getShipmentItems($this->modalDetailShipmentId) as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->item_damaged }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-form.modal>

    <div>
        <h2 class="card-title">{{ __('Data Containers') }}</h2>
        <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
            <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']"  />
            <x-form.search wire:model.live="search" class="w-32" />
        </div>

        @if($this->shipment_details && $this->shipment_details->isNotEmpty())
            <div class="space-y-4">
                @foreach($this->shipment_details as $key => $shipment_detail)
                    <x-card class="overflow-x-auto shadow-lg bg-base-300">
                        <div class="flex flex-col md:flex-row md:justify-between space-y-4 md:space-y-0">
                            <div class="md:w-[10%]">
                                <h3 class="text-lg font-bold">{{ __('Container') }} {{ $loop->iteration }}</h3>
                            </div>
                            <div class="md:w-[30%] text-center">
                                <h3 class="text-lg font-bold">{{ $shipment_detail->container->number_container }}</h3>
                            </div>
                            <div class="md:w-1/5">
                                <h3 class="text-lg font-bold hover:underline cursor-pointer">
                                    <label for="modal_item_details" class="cursor-pointer" wire:click="$dispatch('show-item-details', { id: {{ $shipment_detail->id }} })">
                                        {{ __('Item') }}: {{ $this->itemsCount($shipment_detail->id) }} <svg class="inline -mt-[5px]" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M384 224v184a40 40 0 0 1-40 40H104a40 40 0 0 1-40-40V168a40 40 0 0 1 40-40h167.48M336 64h112v112M224 288L440 72"/></svg>
                                    </label>
                                </h3>
                            </div>
                            <div class="md:w-1/5">
                                <h3 class="text-lg font-bold">{{ __('Quantity') }} : {{ $this->totalQuantity($shipment_detail->id) }}</h3>
                            </div>

                            <div class=" md:w-1/5">
                                <x-button-link href="{{ route('distribution.verify', ['container' =>$this->shipment_id, 'verify' => $shipment_detail->id]) }}"
                                               class="btn btn-sm btn-neutral w-full md:w-1/2" wire:navigate>
                                    {{ __('Verify') }}
                                </x-button-link>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
            <div class="my-8">
                {{ $this->shipment_details->links('livewire.pagination') }}
            </div>
        @else
            <div class="m-auto text-center">
                {{ __('No Data') }}
            </div>
        @endif
    </div>

</div>
