<?php

use function Livewire\Volt\{state, layout, title, computed, on, usesPagination};
use App\Models\Shipment;

layout('layouts.app');
title(__('Shipments'));

usesPagination();
state(['idData' => '','shipwreck' => '', 'tatd_shipment' => '']);
state(['showing' => 5])->url();
state(['search' => null])->url();

$shipments = computed(function(){
    return Shipment::where('shipwreck', 'like', '%' . $this->search . '%')
        ->orWhere('tatd_shipment', 'like', '%' . $this->search . '%')
        ->latest()->paginate($this->showing, pageName: 'shipment-page');
});

on(['refresh' => fn() => $this->shipments = Shipment::where('shipwreck', 'like', '%' . $this->search . '%')
    ->orWhere('tatd_shipment', 'like', '%' . $this->search . '%')
    ->latest()->paginate($this->showing, pageName: 'shipment-page')
]);


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

    <button class="btn btn-sm btn-base-200 my-4" onclick="modal_shipment.showModal()">Tambah</button>
    </div>

    <dialog id="modal_shipment" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Hello!</h3>
            <p class="py-4">Press ESC key or click the button below to close</p>
            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>

    <x-card :classes="'w-full bg-base-200'">
        <h2 class="card-title">{{ __('Shipment Data') }}</h2>
        <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
            <x-form.filter class="w-24 text-sm select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
            <x-form.search wire:model.live="search" class="w-32" />
        </div>
        <x-divider name="Tabel Data" class="-mt-5"/>
        <x-table class="text-center " thead="No.,Shipwreck,TA & TD,Created At" :action="true">
            @if ($this->shipments && $this->shipments->isNotEmpty())
                @foreach ($this->shipments as $shipment)
                    <tr >
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $shipment->shipwreck }}</td>
                        <td>{{ $shipment->tatd_shipment }}</td>
                        <td>
                            <x-button-info class="text-white btn-xs" wire:click="edit({{ $shipment->id }})">Edit</x-button-info>
                            <x-button-error class="text-white btn-xs" wire:click="destroy({{ $shipment->id }})">
                                {{ __('Delete') }}
                            </x-button-error>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">{{ __('No Data') }}</td>
                </tr>
            @endif
        </x-table>
        {{ $this->shipments->links('livewire.pagination') }}
    </x-card>

</div>
