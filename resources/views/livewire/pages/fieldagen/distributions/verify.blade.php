<?php

use function Livewire\Volt\{layout, title, state, computed, on, usesPagination, mount, updated, usesFileUploads};
use App\Models\ShipmentDetail;
use App\Models\Shipment;
use App\Models\Container;
use App\Models\ShipmentItem;
use App\Models\Distribution;
use Masmerise\Toaster\Toaster;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use App\Models\ItemDamage;

layout('layouts.app');
title(__('Container'));

state(['shipment_id' => fn($container) => $container, 'shipment_detail_id' => fn($verify) => $verify])->locked();
state(['showing' => 6, 'search' => null])->url();
state(['idData', 'driver_id', 'qtyInfo', 'itemDamaged', 'quantity', 'item', 'distributionIdToDelete','damagedQuantity']);
state(['loading' => false, 'openAddItem' => false, 'modalTitle' => '', 'damagedImages' => []]);

usesPagination();
usesFileUploads();


mount(function () {
    if (!Shipment::where('id', $this->shipment_id)->exists()) {
        abort(404);
    }
    if (!ShipmentDetail::where('id', $this->shipment_detail_id)->exists()) {
        abort(404);
    }
});

on([
    'refresh' => function () {
        $this->shipment_items = ShipmentItem::where('shipment_detail_id', $this->shipment_detail_id)->paginate($this->showing, pageName: 'distribution-verify-page');
    },
    'close-modal-x' => function () {
        $this->reset(['driver_id', 'openAddItem', 'qtyInfo', 'quantity', 'item', 'idData', 'modalTitle']);
    },
    'rename-title-and-value' => function ($data, $name) {
        $this->modalTitle = $name;
        $this->idData = $data; // Tambahkan ini
        $getData = ShipmentItem::select(
            DB::raw('ABS((shipment_items.quantity - IFNULL(distributions.quantity, 0) - IFNULL(shipment_items.item_damaged, 0))) AS leftover,
                IFNULL(shipment_items.item_damaged, 0) AS item_damaged
            ')
        )
            ->leftJoin(
                DB::raw('(SELECT shipment_item_id, SUM(quantity) AS quantity FROM distributions GROUP BY shipment_item_id) AS distributions'),
                'distributions.shipment_item_id',
                '=',
                'shipment_items.id'
            )
            ->where('shipment_items.id', $data)
            ->first();
        $this->qtyInfo = $getData->leftover;
        $this->itemDamaged = $getData->item_damaged;
    },
    'confirm-delete-distribution' => function ($data) {
        $this->distributionIdToDelete = $data;
    },
    'open-damaged-modal' => function ($data, $name) {
        $this->modalTitle = $name;
        $this->idData = $data;
        $this->damagedQuantity = null;
        $this->damagedImages = [];

        $shipmentItem = ShipmentItem::find($data);
        $this->qtyInfo = $shipmentItem->quantity - $shipmentItem->item_damaged;
        $this->itemDamaged = $shipmentItem->item_damaged;
    },
    'show-item-details' => function ($data) {
        $this->idData = $data;
    }
]);

updated([
    'driver_id' => function ($value) {
        $this->openAddItem = (bool) $value;
    },
]);

$shipment_items = computed(function () {
    return ShipmentItem::where('shipment_detail_id', $this->shipment_detail_id)->paginate($this->showing, pageName: 'distribution-verify-page');
});

$drivers = computed(function () {
    $shipment_id = $this->shipment_id;
    return DB::table('drivers')
        ->whereNotIn('drivers.id', function ($query) use ($shipment_id) {
            $query->select('driver_id')
                ->from('deliveries')
                ->where('shipment_id', '=', $shipment_id)  // Menyaring berdasarkan shipment_id
                ->whereIn('status', ['prefer', 'delivered']);  // Menyaring status 'prefer' atau 'delivered'
        })
        ->select('drivers.*')  // Mengambil semua kolom dari tabel drivers
        ->get();
});

$items = computed(function () {
    return ShipmentItem::where('shipment_detail_id', $this->shipment_detail_id)->get();
});

// Fungsi saveItem
$saveItem = function ($action) {
    $this->validate([
        'driver_id' => 'required|exists:drivers,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $shipment_item_id = $this->idData;
    $leftover = $this->qtyInfo;

    $existingDistribution = Distribution::where('shipment_item_id', $shipment_item_id)
        ->where('driver_id', $this->driver_id)
        ->first();

    $additionalQuantity = $this->quantity;

    if ($existingDistribution) {
        $newQuantity = $existingDistribution->quantity + $additionalQuantity;
    } else {
        $newQuantity = $additionalQuantity;
    }

    if ($newQuantity - ($existingDistribution->quantity ?? 0) > $leftover) {
        $this->addError('quantity', __('The quantity exceeds the available items.'));
        return;
    }

    try {
        if ($existingDistribution) {
            $existingDistribution->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            Distribution::create([
                'shipment_item_id' => $shipment_item_id,
                'driver_id' => $this->driver_id,
                'quantity' => $additionalQuantity,
                'status' => 'pending',
            ]);
        }

        $this->qtyInfo -= $additionalQuantity;

        if ($action == 'save') {
            $this->dispatch('close-modal-x');
            $this->dispatch('close-modal', 'modal_add_checklist');
            $this->dispatch('refresh');
        } else {
            $this->reset(['quantity', 'driver_id']);
        }
        Toaster::success(__('Data has been saved'));
    } catch (\Exception $e) {
        $this->dispatch('close-modal', 'modal_add_checklist');
        Toaster::error(__('Data could not be saved'));
    }
};

$deleteDistribution = function () {
    try {
        $distribution = Distribution::findOrFail($this->distributionIdToDelete);
        $distribution->delete();
        $this->qtyInfo += $distribution->quantity;
        $this->distributionIdToDelete = null;
        $this->dispatch('refresh');
        $this->dispatch('close-modal', 'modal_confirm_delete');
        Toaster::success(__('Distribution has been deleted'));
    } catch (\Exception $e) {
        $this->dispatch('close-modal', 'modal_confirm_delete');
        Toaster::error(__('Distribution could not be deleted'));
    }
};

$cancelDelete = function () {
    $this->distributionIdToDelete = null;
    $this->dispatch('close-modal', 'modal_confirm_delete');
};

$saveDamagedItem = function () {
    $this->validate([
        'damagedQuantity' => 'required|integer|min:1',
        'damagedImages' => 'required|array',
        'damagedImages.*' => 'image|max:5120',
    ]);

    $shipment_item = ShipmentItem::find($this->idData);

    if (!$shipment_item) {
        Toaster::error(__('Shipment item not found'));
        return;
    }

    $availableDamagedQty = $shipment_item->quantity - $shipment_item->item_damaged - $shipment_item->distributions->sum('quantity');

    if ($availableDamagedQty <= 0) {
        $this->addError('damagedQuantity', __('No available quantity to mark as damaged'));
        return;
    }

    if ($this->damagedQuantity > $availableDamagedQty) {
        $this->addError('damagedQuantity', __('The damaged quantity exceeds the available items.'));
        return;
    }

    if (count($this->damagedImages) != $this->damagedQuantity) {
        $this->addError('damagedImages', __('The number of images must match the damaged quantity.'));
        return;
    }

    try {
        $imagePaths = [];
        foreach ($this->damagedImages as $image) {
            $path = $image->store('damaged_items', 'public');
            $imagePaths[] = $path;
        }

        $shipment_item->item_damaged += $this->damagedQuantity;
        $shipment_item->save();

         foreach ($imagePaths as $path) {
             ItemDamage::create([
                 'shipment_item_id' => $this->idData,
                 'image' => $path,
             ]);
         }

        $this->reset(['damagedQuantity', 'damagedImages', 'modalTitle', 'idData']);
        $this->dispatch('close-modal', 'modal_add_damaged_item');
        $this->dispatch('refresh');

        Toaster::success(__('Damaged items have been recorded'));
    } catch (\Exception $e) {
        Toaster::error(__('Failed to record damaged items'));
    }
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
                        'text' => __('Container'),
                        'href' => route('distribution.container',$this->shipment_id),
                    ],
                    [
                        'text' => __('Verify Items'),
                    ]
                ]" class="items-start"
        />
    </div>

    <x-form.modal id="modal_confirm_delete" class="-mt-2 w-9/12 max-w-xl" :title="__('Confirm Deletion')">
        <p>{{ __('Are you sure you want to delete this distribution? This action cannot be undone.') }}</p>
        <div class="flex justify-end space-x-3 mt-4">
            <x-button-neutural class="text-white" wire:click="cancelDelete">{{ __('Cancel') }}</x-button-neutural>
            <x-button-error class="text-white" wire:click="deleteDistribution">{{ __('Delete') }}</x-button-error>
        </div>
    </x-form.modal>

    <x-form.modal id="modal_add_damaged_item" class="-mt-2 w-9/12 max-w-xl" :title="$this->modalTitle ? __('Damaged Items') . ' ' . $this->modalTitle : __('Damaged Items')">
        <div>
            <x-text-input-4 type="number" name="damagedQuantity" wire:model="damagedQuantity" labelClass="mb-3 -mt-4" title="{{ __('Damaged Item Quantity') }}" />
            <div>
                <label class="block mb-2 text-sm font-medium">{{ __('Upload Images') }}</label>
                <x-filepond wire:model="damagedImages" multiple/>
                @error('damagedImages')<span class="text-sm font-medium text-red-600">{{ $message }}</span>@enderror
            </div>

            <div class="flex justify-end space-x-3 mt-7">
                <x-button-info class="text-white" wire:click="saveDamagedItem">{{ __('Save') }}</x-button-info>
            </div>
        </div>
    </x-form.modal>


    <x-form.modal id="modal_add_checklist" class="-mt-2 w-9/12 max-w-xl" :title="$this->modalTitle ? __('Checklist Data') . ' ' . $this->modalTitle : __('Checklist Data')">
        <x-select-input name="driver_id" id="driver_id" display_name="vehicle_number,name" wire:model.live="driver_id" labelClass="-mt-4 mb-3" title="{{ __('Driver') }}" :data="$this->drivers" getData="server"/>
        <div x-data="{ open : $wire.openAddItem }">
            <div x-cloak
                 x-show="$wire.openAddItem"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="transform opacity-0"
                 x-transition:enter-end="transform opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave.start="transform opacity-100"
                 x-transition:leave-end="transform opacity-0">
                <div class="flex justify-between space-x-3">
                    <div class="w-1/2 flex space-x-3 justify-between">
                        <div>
                            <x-text-input-4 type="number" name="itemDamaged" wire:model="itemDamaged" labelClass="mb-3 " title="{{ __('Damaged Items') }}" :disabled="true" />
                        </div>
                        <div>
                            <x-text-input-4 type="number" name="qtyInfo" wire:model="qtyInfo" labelClass="mb-3 " title="{{ __('Unchecklist') }}" :disabled="true" />
                        </div>
                    </div>
                    <div class="w-1/2">
                        <x-text-input-4 type="number" name="quantity" wire:model="quantity" labelClass="mb-3 " title="{{ __('Item In Truck') }}" />
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <x-button-info class="text-white" wire:click="saveItem('save')">{{ __('Save') }}</x-button-info>
                    <x-button-success class="text-white" wire:click="saveItem('save_add')">{{ __('Save & Add More') }}</x-button-success>
                </div>
            </div>
        </div>
    </x-form.modal>

    <div>
        <h2 class="card-title">{{ __('Data Containers') }}</h2>
        <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
            <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']"  />
            <x-form.search wire:model.live="search" class="w-32" />
        </div>

        @if($this->shipment_items && $this->shipment_items->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                @foreach($this->shipment_items as $key => $shipment_item)
                    <div>
                        <x-card class="w-full max-w-1/5 md:w-full bg-base-300 border border-base-200 rounded-lg shadow sm:p-2 relative">
                            <div class="absolute top-2 right-2">
                                @if($shipment_item->distributions->count() > 0)
                                    <div class="tooltip" data-tip="{{ __('Verified') }}">
                                        <!-- Icon Verified -->
                                    </div>
                                @else
                                    <div class="tooltip" data-tip="{{ __('Pending') }}">
                                        <!-- Icon Pending -->
                                    </div>
                                @endif
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
                                        <h3 class="text-lg font-bold text-base-content inline-flex items-center hover:underline cursor-pointer" wire:click="$dispatch('show-item-details', { data: {{ $shipment_item->id }} })">
                                            {{ __('Damaged Items') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 30 30" class="pt-1">
                                                <rect width="30" height="30" fill="none" />
                                                <path fill="currentColor" d="M10.05 17.55c0 .3.09.55.26.73c.2.19.46.28.79.28c.3 0 .55-.09.73-.28l6.04-6.05v1.95q0 .45.3.75t.75.3c.29 0 .54-.1.74-.31s.3-.45.3-.75V9.7q0-.45-.3-.75c-.3-.3-.45-.3-.74-.3h-4.5c-.29 0-.54.1-.73.3s-.29.44-.29.75c0 .29.1.54.29.73s.44.29.73.29h1.95l-6.06 6.06c-.17.21-.26.47-.26.77" />
                                            </svg>
                                        </h3>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content">
                                            {{ $shipment_item->item_damaged . " " . __('Cardboard') }}
                                        </p>
                                    </div>
                                </li>
                                <li class="py-3 sm:py-4 flex flex-row items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-base-content">
                                            {{ __('Item In Truck') }}
                                        </h3>
                                    </div>
                                    <div>
                                        <p class="text-sm text-base-content">
                                            {{ $shipment_item->distributions->sum('quantity') . " " . __('Cardboard') }}
                                        </p>
                                    </div>
                                </li>
                                <li class="py-3 sm:py-4 items-center">
                                    <div x-data="{ open: false }" >
                                        <h3 @click="open = !open" class="flex flex-row items-center justify-between text-lg text-base-content font-bold
                                        {{ $shipment_item->distributions->count() > 0 ? 'cursor-pointer':'cursor-not-allowed tooltip tooltip-top' }} " data-tip="{{__('No Truck List')}}">{{ __('Truck List') }} ({{$shipment_item->distributions->count()}})
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="transition-transform duration-300"
                                                 :class="{{ $shipment_item->distributions->count() > 0 ? "{'rotate-90': open}":"{}" }}">
                                                <rect width="24" height="24" fill="none" />
                                                <path fill="currentColor" d="M8 6.82v10.36c0 .79.87 1.27 1.54.84l8.14-5.18a1 1 0 0 0 0-1.69L9.54 5.98A.998.998 0 0 0 8 6.82" />
                                            </svg>
                                        </h3>
                                        <div x-cloak
                                             x-show="open"
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 scale-90"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-300"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-90"
                                             class="">
                                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                                @foreach($shipment_item->distributions as $key => $distribution)
                                                    <li class="py-3 sm:py-4 flex flex-row items-center justify-between">
                                                        <div>
                                                            <p class="text-sm text-base-content">
                                                                {{ $distribution->driver->vehicle_number }} : {{ $distribution->driver->name }}
                                                            </p>
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            <p class="text-sm text-base-content">
                                                                {{ $distribution->quantity }} {{ __('Cardboard') }}
                                                            </p>
                                                            @if($distribution->driver->status == 'free')
                                                                <label for="modal_confirm_delete" class="btn btn-xs btn-error text-white" @click="$dispatch('confirm-delete-distribution', { data: '{{ $distribution->id }}'})">
                                                                    {{ __('Delete') }}
                                                                </label>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-3 sm:py-4 flex flex-row items-center justify-center gap-2">
                                    <label for="modal_add_checklist" class="btn btn-sm btn-success text-white" @click="$dispatch('rename-title-and-value', { data: '{{ $shipment_item->id }}', name: '{{ $shipment_item->item_name }}' })">{{ __('Checklist Items') }}</label>
                                    <label for="modal_add_damaged_item" class="btn btn-sm btn-error text-white" @click="$dispatch('open-damaged-modal', { data: '{{ $shipment_item->id }}', name: '{{ $shipment_item->item_name }}' })">{{ __('Damaged Items') }}</label>
                                </li>
                            </ul>
                        </x-card>
                    </div>
                @endforeach
            </div>
            <div class="my-8">
                {{ $this->shipment_items->links('livewire.pagination') }}
            </div>
        @else
            <div class="m-auto text-center">
                {{ __('No Data') }}
            </div>
        @endif
    </div>

</div>
