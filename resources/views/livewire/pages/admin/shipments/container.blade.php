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
state(['idData', 'idItem', 'dropdownCondition', 'modalDetailShipmentId']);
state(['item' => '', 'quantity' => '', 'loading' => false, 'edit' => false]);

usesPagination();

mount(function () {
    if (!Shipment::where('id', $this->shipment_id)->exists()) {
        abort(404);
    }
});
$shipment_details = computed(function () {
    return ShipmentDetail::where('shipment_id', $this->shipment_id)->paginate($this->showing, pageName: 'shipment-detail-page');
});

on([
    'refresh' => function () {
        $this->shipment_details = ShipmentDetail::where('shipment_id', $this->shipment_id)->paginate($this->showing, pageName: 'shipment-detail-page');
        $this->dispatch('refresh-dropdown-search');
    },
    'close-modal-x' => function () {
        $this->reset('item', 'quantity', 'idData', 'container_id');
        $this->dispatch('refresh-dropdown-search');
        $this->resetValidation(['item', 'quantity', 'idData', 'container_id']);
        $this->modalDetailShipmentId = null;
        $this->edit = false;
    },
    'set-id' => fn($id) => ($this->idData = $id),
    'set-id-edit' => function ($id) {
        $this->dispatch('close-modal', 'modal_item_details');
        $this->idItem = $id;
        $edit = ShipmentItem::find($id);
        $this->item = $edit->item_name;
        $this->quantity = $edit->quantity;
        $this->edit = true;
    },
    'dropdown-toggle' => fn($condition) => ($this->dropdownCondition = $condition),
    'dropdown-selected' => fn($key, $value) => ($this->container_id = $key),
    'show-item-details' => function ($id) {
        $this->loading = true;
        $this->idData = $id;
        $this->modalDetailShipmentId = $id;
    },
]);

$save = function ($action) {
    $this->validate([
        'container_id' => 'required',
    ]);

    try {
        ShipmentDetail::create([
            'shipment_id' => $this->shipment_id,
            'container_id' => $this->container_id,
        ]);
        $this->reset(['idItem', 'container_id']);
        if ($action == 'save') {
            $this->dispatch('close-modal', 'modal_shipment_container');
        }
        $this->dispatch('refresh');
        unset($this->shipment_details);
        Toaster::success(__('Container has been added'));
    } catch (Exception $e) {
        $this->reset(['idItem', 'container_id']);
        $this->dispatch('close-modal', 'modal_shipment_container');
        Toaster::error(__('Container could not be added'));
    }
};

$saveItem = function ($action) {
    $this->validate([
        'item' => 'required',
        'quantity' => 'required',
    ]);
    try {
        if ($this->idItem ?? false) {
            ShipmentItem::find($this->idItem)->update([
                'shipment_detail_id' => $this->idData,
                'item_name' => $this->item,
                'quantity' => $this->quantity,
            ]);
        } else {
            ShipmentItem::create([
                'shipment_detail_id' => $this->idData,
                'item_name' => $this->item,
                'quantity' => $this->quantity,
            ]);
        }
        if ($action == 'save') {
            $this->reset(['idItem', 'item', 'quantity', 'idData', 'edit']);
            $this->dispatch('close-modal', 'modal_container_item');
        } else {
            $this->reset(['idItem', 'item', 'quantity']);
        }
        $this->dispatch('refresh');
        unset($this->shipment_details);
        Toaster::success(__('Item has been added'));
    } catch (Exception $e) {
        $this->reset(['idItem', 'item', 'quantity', 'idData']);
        $this->dispatch('close-modal', 'modal_container_item');
        Toaster::error(__('Item could not be added'));
        dd($e->getMessage());
    }
};

$destroy = function ($id) {
    try {
        $shipment_detail = ShipmentDetail::find($id);
        $shipment_detail->delete();
        unset($this->shipment_details);
        $this->dispatch('refresh');
        Toaster::success(__('Container has been deleted'));
    } catch (Throwable $th) {
        Toaster::error(__('Container could not be deleted'));
    }
};

$getShipmentItems = function ($shipmentDetailId) {
    $items = ShipmentItem::where('shipment_detail_id', $shipmentDetailId)->get();
    $this->loading = false;
    return $items;
};

// Menghitung jumlah jenis barang berdasarkan nama item yang unik
$itemsCount = function ($shipmentDetailId) {
    return ShipmentItem::where('shipment_detail_id', $shipmentDetailId)->select('item_name')->distinct()->count();
};

// Menghitung total kuantitas barang dalam kontainer
$totalQuantity = function ($shipmentDetailId) {
    return ShipmentItem::where('shipment_detail_id', $shipmentDetailId)->sum('quantity');
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
                'text' => __('Shipment'),
                'href' => route('shipments'),
            ],
            [
                'text' => __('Container'),
            ],
        ]" class="items-start" />

        <label for="modal_shipment_container" class="btn btn-sm btn-base-200 my-4">{{ __('Add') }}</label>
    </div>

    <x-form.modal id="modal_shipment_container"
        class="-mt-2 w-10/12 max-w-5xl transition-all duration-500 {{ $this->dropdownCondition ? 'h-2/5' : 'h-auto' }}"
        :title="__('Shipments')">
        <x-input-label :value="__('Container')" class="-mt-3 mb-8" />
        <livewire:dropdown-search model="Container" displayName="number_container" />
        @error('container_id')
            <div class="label -mt-7">
                <span class="label-text-alt text-red-600">{{ $message }}</span>
            </div>
        @enderror

        <div class="flex justify-end space-x-3">
            <x-button-info class="text-white" wire:click="save('save')">{{ __('Save') }}</x-button-info>
            <x-button-success class="text-white"
                wire:click="save('save_add')">{{ __('Save & Add More') }}</x-button-success>
        </div>
    </x-form.modal>

    <!-- Modal for Adding Container -->
    <x-form.modal id="modal_container_item" class="-mt-2" :title="__('Item Data')">
        <div x-data="{
            init() {
                document.addEventListener('keydown', (event) => {
                    if (event.ctrlKey && event.key == 'z') {
                        event.preventDefault();
                        this.$refs.shortcutButtonSave.click();
                    } else if (event.ctrlKey && event.key == 'a') {
                        event.preventDefault();
                        this.$refs.shortcutButtonSaveAdd.click();
                        this.$refs.itemInput.focus();
                    }
                });
            }
        }">
            <div x-data="{
                items: JSON.parse(localStorage.getItem('items')) || [], // Ambil histori inputan dari localStorage
                filteredItems: [],
                item: '',
                filterItems() {
                    const searchTerm = this.item.toLowerCase();
                    this.filteredItems = this.items.filter(item => item.toLowerCase().startsWith(searchTerm)); // Filter berdasarkan inputan
                },
                addItem() {
                    if (this.item && !this.items.includes(this.item)) {
                        this.items.push(this.item); // Menambahkan item ke histori
                        localStorage.setItem('items', JSON.stringify(this.items)); // Menyimpan ke localStorage
                    }
                },
                closeDropdown() {
                    this.filteredItems = []; // Menutup dropdown
                }
            }" x-init="filterItems" class="relative">

                <x-text-input-4 x-ref="itemInput" name="item" wire:model="item" labelClass="-mt-4 mb-3"
                    title="{{ __('Item') }}" x-model="item" @input="filterItems" @focus="filterItems"
                    @blur="setTimeout(() => { filteredItems = [] }, 200)" />

                <!-- Saran/Autocomplete Dropdown -->
                <ul x-show="filteredItems.length > 0 && item !== ''" x-cloak
                    class="absolute bg-white shadow-md w-10/12 z-50 max-h-60 overflow-y-auto"
                    style="border: 1px solid #ddd; border-radius: 4px; max-height: 200px;">
                    <template x-for="suggestion in filteredItems" :key="suggestion">
                        <li @click="item = suggestion; filteredItems = []" class="cursor-pointer p-2 hover:bg-gray-200">
                            <span x-text="suggestion"></span>
                        </li>
                    </template>
                </ul>
            </div>

            <x-text-input-4 type="number" name="quantity" wire:model="quantity" labelClass="my-3"
                title="{{ __('Quantity') }}" />
            <div class="flex justify-end space-x-3">
                <div>
                    <x-button-info x-ref="shortcutButtonSave" class="text-white"
                        wire:click="saveItem('save')">{{ __('Save') }}</x-button-info>
                    <small class="block text-xs mt-1 text-gray-600">{{ __('Ctrl + z, Save') }}</small>
                </div>
                <div>
                    <x-button-success x-ref="shortcutButtonSaveAdd" :disabled="$this->edit" class="text-white"
                        wire:click="saveItem('save_add')">{{ __('Save & Add More') }}</x-button-success>
                    <small class="block text-xs mt-1 text-gray-600">{{ __('Ctrl + a, Save & Add More') }}</small>
                </div>
            </div>
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
                    <thead>
                        <tr>
                            <th>{{ __('Item Name') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->getShipmentItems($this->modalDetailShipmentId) as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    <div class="flex space-x-2">
                                        <label for="modal_container_item"
                                            class="btn btn-xs btn-base-200 w-full md:w-1/2"
                                            @click="$dispatch('set-id-edit', { id: {{ $item->id }} })">
                                            {{ __('Edit') }}
                                        </label>
                                    </div>
                                </td>
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
            <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
            <x-form.search wire:model.live="search" class="w-32" />
        </div>

        @if ($this->shipment_details && $this->shipment_details->isNotEmpty())
            <div class="space-y-4">
                @foreach ($this->shipment_details as $key => $shipment_detail)
                    <x-card class="overflow-x-auto shadow-lg bg-base-300">
                        <div class="flex flex-col md:flex-row md:justify-between space-y-4 md:space-y-0">
                            <div class="md:w-[10%] md:text-center">
                                <h3 class="text-lg font-bold">{{ __('Container') }} {{ $loop->iteration }}</h3>
                            </div>
                            <div class="md:w-[30%] text-center">
                                <h3 class="text-lg font-bold">{{ $shipment_detail->container->number_container }}</h3>
                            </div>
                            <div class="md:w-1/5">
                                <h3 class="text-lg font-bold hover:underline cursor-pointer">
                                    <label for="modal_item_details" class="cursor-pointer"
                                        wire:click="$dispatch('show-item-details', { id: {{ $shipment_detail->id }} })">
                                        {{ __('Item') }}: {{ $this->itemsCount($shipment_detail->id) }}

                                        <svg class="inline -mt-[5px]" xmlns="http://www.w3.org/2000/svg" width="1em"
                                            height="1em" viewBox="0 0 512 512">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="32"
                                                d="M384 224v184a40 40 0 0 1-40 40H104a40 40 0 0 1-40-40V168a40 40 0 0 1 40-40h167.48M336 64h112v112M224 288L440 72" />
                                        </svg>
                                    </label>
                                </h3>
                            </div>
                            <div class="md:w-1/5">
                                <h3 class="text-lg font-bold">{{ __('Quantity') }} :
                                    {{ $this->totalQuantity($shipment_detail->id) }}</h3>
                            </div>

                            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                                <label for="modal_container_item" class="btn btn-sm btn-base-200 w-full md:w-1/2"
                                    @click="$dispatch('set-id', { id: {{ $shipment_detail->id }} })">
                                    {{ __('Add Item') }}
                                </label>
                                <x-button-error class="btn-sm text-white w-full md:w-1/2"
                                    wire:click="destroy({{ $shipment_detail->id }})"
                                    wire:confirm="{{ __('Are you sure you want to delete this data?') }}">
                                    {{ __('Delete') }}
                                </x-button-error>
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

