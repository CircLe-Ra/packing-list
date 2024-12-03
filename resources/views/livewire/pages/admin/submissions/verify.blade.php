<?php

use function Livewire\Volt\{layout, title, state, computed, on, usesPagination, mount, updated, usesFileUploads};
use App\Models\Distribution;
use Masmerise\Toaster\Toaster;
use App\Models\Driver;
use App\Models\ItemDamage;
use App\Models\Consumer;
use App\Models\Delivery;

layout('layouts.app');
title(__('Verify Truck'));

state(['showing' => 6, 'search' => null])->url();
state(['idData', 'delivery_id', 'bapb_number', 'dosj_number']);
state(['loading' => false, 'drivers' => [], 'consumers' => [], 'deliveries' => [], 'openItem' => false]);

usesPagination();

mount(function () {
    $this->consumers = Consumer::all();
    $this->deliveries = Delivery::where('status', 'prefer')->get();
});

on(
    [
        'refresh' => fn() => $this->deliveries = Delivery::where('status', 'prefer')->get(),
        'close-modal-x' => function() {
            $this->idData = null;
        },
        'show-item-details' => function($data) {
            $this->loading = true;
            $this->idData = $data;
        },
        'set-data' => fn($data) => $this->delivery_id = $data,
    ]
);

$getDistributionItems = function ($data) {
    $distributions = Distribution::where('driver_id', $data)->get();
    $this->loading = false;
    return $distributions;
};

$verify = function () {
   $validated = $this->validate([
        'bapb_number' => 'required'
        'dosj_number' => 'required'
    ]);
    $validated['status'] = 'verified';
    try {
       Delivery::where('id', $this->delivery_id)->update($validated);
        $this->reset(['bapb_number', 'delivery_id', 'dosj_number']);
        $this->dispatch('refresh');
        $this->dispatch('close-modal', 'modal_verify');
        Toaster::success('Truck has been verified');
    }catch (Exception $e) {
        $this->reset(['bapb_number', 'delivery_id', 'dosj_number']);
        $this->dispatch('refresh');
        $this->dispatch('close-modal', 'modal_verify');
        Toaster::error('Truck could not be verified');
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
                        'text' => __('Verification'),
                        'href' => route('submissions.admin.verify'),
                    ],
                    [
                        'text' => __('Verify Truck'),
                    ]
                ]" class="items-start"
        />
        <x-button-link wire:navigate href="{{ route('submissions.admin.verified') }}" class="text-white btn-sm mt-5 text-sm btn btn-success">{{ __('Verified Truck') }}
            <svg xmlns="http://www.w3.org/2000/svg" width="1.78em" height="1em" viewBox="0 0 16 9"><path fill="currentColor" d="M12.5 5h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5"/><path fill="currentColor" d="M10 8.5a.47.47 0 0 1-.35-.15c-.2-.2-.2-.51 0-.71l3.15-3.15l-3.15-3.15c-.2-.2-.2-.51 0-.71s.51-.2.71 0l3.5 3.5c.2.2.2.51 0 .71l-3.5 3.5c-.1.1-.23.15-.35.15Z"/></svg>
        </x-button-link>
    </div>

    <x-form.modal id="modal_verify" class="-mt-2 w-9/12 max-w-xl" :title="__('Verify Truck')">
        <x-text-input-4 type="text" name="bapb_number" wire:model="bapb_number" labelClass="mb-3 -mt-4" title="{{ __('BAPB Number') }}" />
        <x-text-input-4 type="text" name="dosj_number" wire:model="dosj_number" labelClass="mb-3 -mt-4" title="{{ __('DO/SJ Number') }}" />
        <div class="flex justify-end mt-4">
            <button class="text-white btn btn-info" wire:click="verify">{{ __('Verify') }}</button>
        </div>
    </x-form.modal>

    <x-form.modal id="modal_item_details" class="-mt-2 w-9/12 max-w-xl" :title="__('Item Details')">
        <div>
            @if(!$this->loading)
                <div>
                    <div class="flex justify-center items-center">
                        <span class="loading loading-dots loading-lg"></span>
                    </div>
                </div>
            @else
                <table class="min-w-full divide-y divide-base-100">
                    <thead class="bg-neutral ">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-content uppercase tracking-wider">
                            {{ __('Item Name') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-content uppercase tracking-wider">
                            {{ __('Container Info') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-content uppercase tracking-wider">
                            {{ __('Quantity') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class=" divide-y divide-base-100">
                    @foreach($this->getDistributionItems($this->idData) as $key => $distribution)
                        <tr class="{{ $key % 2 == 0 ? 'bg-base-200' : 'bg-base-300' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-base-content">
                                {{ $distribution->shipment_item->item_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-base-content">
                                {{ $distribution->shipment_item->shipment_detail->container->number_container }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-base-content">
                                {{ $distribution->quantity }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            <div class="flex justify-end mt-4">
                <label for="modal_item_details" class="text-white btn btn-error" @click="$dispatch('close-modal-x')">{{ __('Close') }}</label>
            </div>
        </div>
    </x-form.modal>

    <div>
        <h2 class="card-title">{{ __('Data Delivery Order') }}</h2>
        <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
            <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']"  />
            <x-form.search wire:model.live="search" class="w-32" />
        </div>

        @if($this->deliveries && $this->deliveries->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 mb-10">
                @foreach($this->deliveries as $key => $delivery)
                    <x-card class="w-full max-w-1/5 md:w-full bg-base-300 border border-base-200 rounded-lg shadow sm:p-2 relative">
                        <div class="flex flex-col text-center mb-2">
                            <h5 class="text-xl font-bold text-base-content leading-5">
                                <span class="block mb-2">{{ __('Truck') }}</span>
                                <span>{{ $delivery->driver->vehicle_number }}</span>
                            </h5>
                        </div>
                        <ul role="list" class="divide-y divide-neutral-600">
                            <li class="py-3 sm:py-4 flex flex-row items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-base-content ">
                                        {{ __('Driver Name') }}
                                    </h3>
                                </div>
                                <div>
                                    <p class="text-sm text-base-content">
                                        {{ $delivery->driver->name }}
                                    </p>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4 flex flex-row items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-base-content ">
                                        {{ __('Driver Phone') }}
                                    </h3>
                                </div>
                                <div>
                                    <p class="text-sm text-base-content">
                                        {{ $delivery->driver->phone }}
                                    </p>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4 flex flex-row items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-base-content ">
                                        {{ __('Consumer') }}
                                    </h3>
                                </div>
                                <div>
                                    <p class="text-sm text-base-content">
                                        {{ $delivery->consumer->name }}
                                    </p>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4 flex flex-row items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-base-content ">
                                        {{ __('Destination') }}
                                    </h3>
                                </div>
                                <div>
                                    <p class="text-sm text-base-content">
                                        {{ $delivery->consumer->address }}
                                    </p>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4 flex flex-row items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-base-content">
                                        <label for="modal_item_details" class="inline-flex items-center hover:underline cursor-pointer" wire:click="$dispatch('show-item-details', { data: {{ $delivery->driver->id }} })">
                                            {{ __('Item In Truck') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 30 30" class="pt-1">
                                                <rect width="30" height="30" fill="none" />
                                                <path fill="currentColor" d="M10.05 17.55c0 .3.09.55.26.73c.2.19.46.28.79.28c.3 0 .55-.09.73-.28l6.04-6.05v1.95q0 .45.3.75t.75.3c.29 0 .54-.1.74-.31s.3-.45.3-.75V9.7q0-.45-.3-.75c-.3-.3-.45-.3-.74-.3h-4.5c-.29 0-.54.1-.73.3s-.29.44-.29.75c0 .29.1.54.29.73s.44.29.73.29h1.95l-6.06 6.06c-.17.21-.26.47-.26.77" />
                                            </svg>
                                        </label>
                                    </h3>
                                </div>
                                <div>
                                    <p class="text-sm text-base-content">
                                        {{ __('Details of items') }}
                                    </p>
                                </div>
                            </li>
                                <li class="pt-3 sm:pt-4 flex flex-row items-center justify-end gap-2">
                                    <label for="modal_verify" class="btn btn-sm btn-success text-white" @click="$dispatch('set-data', { data: '{{ $delivery->id }}' })">{{ __('Verify') }}</label>
                                </li>
                        </ul>
                    </x-card>
                @endforeach
            </div>
        @else
            <div class="m-auto text-center">
                {{ __('No Data') }}
            </div>
        @endif
    </div>
</div>
