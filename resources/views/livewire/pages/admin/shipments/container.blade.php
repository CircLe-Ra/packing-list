<?php

use function Livewire\Volt\{layout, title, state, computed, on, usesPagination};
use App\Models\ShipmentDetail;
use App\Models\Container;
use App\Models\ShipmentItem;
use Masmerise\Toaster\Toaster;

layout('layouts.app');
title(__('Container'));

state(['shipment_id' => fn($id) => $id])->locked();
state(['showing' => 5, 'search' => null])->url();
state(['container_id' => '']);
state(['idData', 'dropdownCondition']);
state(['item'=> '', 'quantity' => '', ]);

usesPagination();
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
        },
        'set-id' => fn ($id) => $this->idData = $id,
        'dropdown-toggle' => fn ($condition) => $this->dropdownCondition = $condition,
        'dropdown-selected' => fn ($key, $value) => $this->container_id = $key,
    ]
);


$save = function ($action) {
    $this->validate([
        'container_id' => 'required',
    ]);
        try {
            ShipmentDetail::create([
                'shipment_id' => $this->shipment_id,
                'container_id' => $this->container_id
            ]);
            $this->reset(['container_id']);
            if ($action == 'save') {
                $this->dispatch('close-modal', 'modal_shipment_container');
            }
            $this->dispatch('refresh');
            unset($this->shipment_details);
            Toaster::success(__('Container has been added'));
        }catch (Exception $e) {
            $this->reset(['container_id']);
            $this->dispatch('close-modal', 'modal_shipment_container');
            Toaster::error(__('Container could not be added'));
        }
};

$saveItem = function ($action) {
    $this->validate([
        'item' => 'required',
        'quantity' => 'required',
    ]);
            ShipmentItem::create([
                'shipment_detail_id' => $this->idData,
                'item_name' => $this->item,
                'quantity' => $this->quantity
            ]);
        try {
            if ($action == 'save') {
                $this->reset(['item', 'quantity', 'idData']);
                $this->dispatch('close-modal', 'modal_container_item');
            }else{
                $this->reset(['item', 'quantity']);
            }
            $this->dispatch('refresh');
            unset($this->shipment_details);
            Toaster::success(__('Item has been added'));
        }catch (Exception $e) {
            $this->reset(['item', 'quantity', 'idData']);
            $this->dispatch('close-modal', 'modal_container_item');
            Toaster::error(__('Item could not be added'));
        }
};


$destroy = function($id) {
    try {
        $shipment_detail = ShipmentDetail::find($id);
        $shipment_detail->delete();
        unset($this->shipment_details);
        $this->dispatch('refresh');
        Toaster::success(__('Container has been deleted'));
    } catch (Throwable $th) {
        Toaster::error(__('Container could not be deleted'));
    }
}

?>


<div>
    <div class="flex justify-between">
        <x-breadcrumb :crumbs="[
                    [
                        'text' => __('Dashboard'),
                        'href' => '/dashboard',
                    ],
                    [
                        'text' => __('Shipment'),
                        'href' => route('shipments'),
                    ],
                    [
                        'text' => __('Container')
                    ]
                ]" class="items-start"
        />

        <label for="modal_shipment_container" class="btn btn-sm btn-base-200 my-4">{{ __('Add') }}</label>
    </div>

    <x-form.modal id="modal_shipment_container" class="-mt-2 w-10/12 max-w-5xl transition-all duration-500 {{ $this->dropdownCondition ? 'h-2/5' : 'h-auto' }}" :title="__('Shipments')">
        <x-input-label :value="__('Container')" class="-mt-3 mb-8" />
        <livewire:dropdown-search model="Container" displayName="number_container" />
        @error('container_id')
            <div class="label -mt-7">
                <span class="label-text-alt text-red-600">{{ $message }}</span>
            </div>
        @enderror

        <div class="flex justify-end space-x-3">
            <x-button-info class="text-white" wire:click="save('save')">{{ __('Save') }}</x-button-info>
            <x-button-success class="text-white"  wire:click="save('save_add')">{{ __('Save & Add More') }}</x-button-success>
        </div>
    </x-form.modal>

    <x-form.modal id="modal_container_item" class="-mt-2" :title="__('Item Data')">
        <x-text-input-4 name="item" wire:model="item" labelClass="-mt-4 mb-3" title="{{ __('Item') }}" />
        <x-text-input-4 type="number" name="quantity" wire:model="quantity" labelClass="my-3" title="{{ __('Quantity') }}" />
        <div class="flex justify-end space-x-3">
            <x-button-info class="text-white" wire:click="saveItem('save')">{{ __('Save') }}</x-button-info>
            <x-button-success class="text-white"  wire:click="saveItem('save_add')">{{ __('Save & Add More') }}</x-button-success>
        </div>
    </x-form.modal>

    <x-form.modal id="modal_item_details" class="-mt-2" :title="__('Item Data')">

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
                        <x-card class="overflow-x-auto border">
                            <div class="flex justify-between">
                                <div class="w-[10%]">
                                    <h3 class="text-lg font-bold">{{ __('Container') }} {{ $loop->iteration }}</h3>
                                </div>
                                <div class="w-[30%] text-center">
                                    <h3 class="text-lg font-bold">{{ $shipment_detail->container->number_container }}</h3>
                                </div>
                                <div class="w-1/5">
                                    <h3 class="text-lg font-bold hover:underline cursor-pointer">
                                        <label for="modal_item_details" class="cursor-pointer">{{ __('Item') }} : 10
                                            <svg class="inline -mt-1 font-bold text-gray-400"  xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 512 512"><path fill="currentColor" d="M432 320h-32a16 16 0 0 0-16 16v112H64V128h144a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16H48a48 48 0 0 0-48 48v352a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48V336a16 16 0 0 0-16-16M488 0H360c-21.37 0-32.05 25.91-17 41l35.73 35.73L135 320.37a24 24 0 0 0 0 34L157.67 377a24 24 0 0 0 34 0l243.61-243.68L471 169c15 15 41 4.5 41-17V24a24 24 0 0 0-24-24"/></svg>
                                        </label>
                                    </h3>
                                </div>
                                <div class="w-1/5">
                                    <h3 class="text-lg font-bold">{{ __('Quantity') }} : 10</h3>
                                </div>
                                <div class="w-1/5 space-x-2">
                                    <label for="modal_container_item" class="btn btn-sm btn-base-200" @click="$dispatch('set-id', { id: {{ $shipment_detail->id }} })">{{  __('Add Item')}}</label>
                                    <x-button-error class="btn btn-sm text-white" wire:click="destroy({{ $shipment_detail->id }})" wire:confirm="{{ __('Are you sure you want to delete this data?')}}">{{ __('Delete') }}</x-button-error>
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
