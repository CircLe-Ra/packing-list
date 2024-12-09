<?php

use function Livewire\Volt\{state, layout, title, computed, on, usesPagination, mount};
use App\Models\Shipment;
use Masmerise\Toaster\Toaster;

layout('layouts.app');
title(__('Shipments'));

usesPagination();
state(['idData' => '', 'loader_ship' => '', 'ta_shipment' => '', 'td_shipment' => '', 'desc' => '', 'unloading_date' => '']);
state(['showing' => 5])->url();
state(['search' => null])->url();

$shipments = computed(function () {
    return Shipment::where('loader_ship', 'like', '%' . $this->search . '%')
        ->orWhere('ta_shipment', 'like', '%' . $this->search . '%')
        ->orWhere('td_shipment', 'like', '%' . $this->search . '%')
        ->latest()->paginate($this->showing, pageName: 'shipment-page');
});

on(['refresh' => fn() => $this->shipments = Shipment::where('loader_ship', 'like', '%' . $this->search . '%')
    ->orWhere('ta_shipment', 'like', '%' . $this->search . '%')
    ->orWhere('td_shipment', 'like', '%' . $this->search . '%')
    ->latest()->paginate($this->showing, pageName: 'shipment-page'),
    'close-modal-x' => fn() => $this->reset('loader_ship', 'ta_shipment', 'td_shipment', 'idData'),
]);



$save = function () {
    $this->validate([
        'loader_ship' => 'required',
        'ta_shipment' => 'required',
        'td_shipment' => 'required',
        'unloading_date' => 'nullable',
        'desc' => 'nullable',
    ]);

    try {
        if ($this->idData) {
            $shipment = Shipment::find($this->idData);
            $shipment->loader_ship = $this->loader_ship;
            $shipment->ta_shipment = $this->ta_shipment;
            $shipment->td_shipment = $this->td_shipment;
            $shipment->unloading_date = $this->unloading_date;
            $shipment->description = $this->desc;
            $shipment->save();
            $this->reset('loader_ship', 'ta_shipment', 'td_shipment', 'idData', 'desc', 'unloading_date');
            $this->dispatch('close-modal');
            $this->dispatch('refresh');
            unset($this->shipments);
            Toaster::success(__('Shipment has been updated'));
        } else {
            $shipment = new Shipment();
            $shipment->loader_ship = $this->loader_ship;
            $shipment->ta_shipment = $this->ta_shipment;
            $shipment->td_shipment = $this->td_shipment;
            $shipment->unloading_date = $this->unloading_date;
            $shipment->description = $this->desc;
            $shipment->save();
            unset($this->shipments);
            $this->reset('loader_ship', 'ta_shipment', 'td_shipment', 'idData', 'desc', 'unloading_date');
            $this->dispatch('close-modal');
            $this->dispatch('refresh');
            Toaster::success(__('Shipment has been created'));
        }
    } catch (Throwable $th) {
        $this->reset('loader_ship', 'ta_shipment', 'td_shipment', 'idData', 'desc', 'unloading_date');
        $this->dispatch('close-modal');
        Toaster::error(__('Shipment could not be saved'));
    }

};

$destroy = function ($id) {
    try {
        $shipment = Shipment::find($id);
        $shipment->delete();
        unset($this->shipments);
        $this->dispatch('refresh');
        Toaster::success(__('Shipment has been deleted'));
    } catch (Throwable $th) {
//        Toaster::error($th->getMessage());
        Toaster::error(__('Shipment could not be deleted'));
    }
};

$edit = function ($id) {
    $shipment = Shipment::find($id);
    $this->idData = $id;
    $this->loader_ship = $shipment->loader_ship;
    $this->ta_shipment = $shipment->ta_shipment;
    $this->td_shipment = $shipment->td_shipment;
    $this->unloading_date = $shipment->unloading_date;
    $this->desc = $shipment->description;

    $this->dispatch('open-modal', 'modal_shipment');
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
                    ]
                ]"
                      class="items-start"
        />

        <label for="modal_shipment" class="btn btn-sm btn-base-200 my-4">Tambah</label>
    </div>

    <x-form.modal id="modal_shipment" class="-mt-2" :title="__('Shipments')">
        <form wire:submit="save">
            <x-text-input-4 name="loader_ship" wire:model="loader_ship" labelClass="my-3" :title="__('Loader Ship')" />
            <x-text-input-4 type="date" name="ta_shipment" wire:model="ta_shipment" labelClass="my-3" :title="__('TA Ship')" />
            <x-text-input-4 type="date" name="td_shipment" wire:model="td_shipment" labelClass="my-3" :title="__('TD Ship')" />
            <x-text-input-4 type="date" name="unloading_date" wire:model="unloading_date" labelClass="my-3" :title="__('Unloading Date')" />
            <x-text-input-4 type="text" name="desc" wire:model="desc" labelClass="my-3" :title="__('Description')" />

            <div class="flex justify-end">
                <button class="btn btn-primary ">{{ __('Save') }}</button>
            </div>
        </form>
    </x-form.modal>


    <div>
        <h2 class="card-title">{{ __('Shipment Data') }}</h2>
        <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
            <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
            <x-form.search wire:model.live="search" class="w-32" />
        </div>
        <x-divider name="Tabel Data" class="-mt-5" />
        <x-table class="text-center " thead="No.,Loader Ship,TA Ship,TD Ship,Created At" :action="true">
            @if ($this->shipments && $this->shipments->isNotEmpty())
                @foreach ($this->shipments as $key => $shipment)
                    <tr @if ($key % 2 == 0) class="bg-base-300" @endif>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $shipment->loader_ship }}</td>
                        <td>{{ $shipment->ta_shipment }}</td>
                        <td>{{ $shipment->td_shipment }}</td>
                        <td>{{ $shipment->created_at->diffForHumans() }}</td>
                        <td class="space-y-1 space-x-1">
                            <x-button-link href="{{ route('shipments.data-container', $shipment->id) }}" class="text-white btn-xs btn-success" wire:navigate>{{ __('Data Containers') }}</x-button-link>
                            <x-button-info class="text-white btn-xs" wire:click="edit({{ $shipment->id }})">Edit</x-button-info>
                            <x-button-error class="{!! $shipment->shipment_details->count() > 0 ? 'btn-disabled text-white btn-xs' : 'text-white btn-xs' !!}"
                                            wire:click="destroy({{ $shipment->id }})"
                                            wire:confirm="{{ __('Are you sure you want to delete this data?')}}"
                            >{{ __('Delete') }}</x-button-error>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">{{ __('No Data') }}</td>
                </tr>
            @endif
        </x-table>
        {{ $this->shipments->links('livewire.pagination') }}
    </div>

</div>
