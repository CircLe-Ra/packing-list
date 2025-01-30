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

state(['id' => fn($id) => $id]);
state(['showing' => 6, 'search' => null])->url();
state(['idData', 'delivery_id', 'bapb_number']);
state(['loading' => false, 'drivers' => [], 'consumers' => [], 'openItem' => false]);

usesPagination();

mount(function () {
    $this->consumers = Consumer::all();
});

$deliveries = computed(function () {
    return Delivery::whereHas('driver', function ($query) {
        $query->where('name', 'like', '%' . $this->search . '%');
        $query->orWhere('vehicle_number', 'like', '%' . $this->search . '%');
    })
        ->whereHas('shipment', function ($query) {
            $query->where('id', $this->id);
        })
        ->whereIn('status', ['delivered', 'verified', 'success'])
        ->latest()
        ->get();
});

on([
    'refresh' => fn() => ($this->deliveries = Delivery::whereIn('status', ['delivered', 'verified', 'success'])
        ->latest()
        ->get()),
    'close-modal-x' => function () {
        $this->idData = null;
    },
    'show-item-details' => function ($data) {
        $this->loading = true;
        $this->idData = $data;
    },
]);

$getDistributionItems = function ($data) {
    $distributions = Distribution::where('driver_id', $data)->get();
    $this->loading = false;
    return $distributions;
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
                'text' => __('Report'),
                'href' => route('report'),
            ],
            [
                'text' => __('Print'),
            ],
        ]" class="items-start" />
    </div>

    <x-form.modal id="modal_item_details" class="-mt-2 w-9/12 max-w-xl" :title="__('Item Details')">
        <div>
            @if (!$this->loading)
                <div>
                    <div class="flex justify-center items-center">
                        <span class="loading loading-dots loading-lg"></span>
                    </div>
                </div>
            @else
                <table class="min-w-full divide-y divide-base-100">
                    <thead class="bg-neutral ">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-content uppercase tracking-wider">
                                {{ __('Item Name') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-content uppercase tracking-wider">
                                {{ __('Container Info') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-content uppercase tracking-wider">
                                {{ __('Quantity') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class=" divide-y divide-base-100">
                        @foreach ($this->getDistributionItems($this->idData) as $key => $distribution)
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
                <label for="modal_item_details" class="text-white btn btn-error"
                    @click="$dispatch('close-modal-x')">{{ __('Close') }}</label>
            </div>
        </div>
    </x-form.modal>

    <div>
        <h2 class="card-title">{{ __('Data Deliveries') }}</h2>
        <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
            <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
            <x-form.search wire:model.live="search" class="w-32" />
        </div>

        @if ($this->deliveries && $this->deliveries->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 mb-10">
                @foreach ($this->deliveries as $key => $delivery)
                    <x-card
                        class="w-full max-w-1/5 md:w-full bg-base-300 border border-base-200 rounded-lg shadow sm:p-2 relative">
                        <div class="absolute top-2 right-2">
                            @if ($delivery->status == 'verified')
                                <div class="tooltip" data-tip="{{ __('Verified') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewBox="0 0 24 24">
                                        <path fill="#4d88ff"
                                            d="m8.6 22.5l-1.9-3.2l-3.6-.8l.35-3.7L1 12l2.45-2.8l-.35-3.7l3.6-.8l1.9-3.2L12 2.95l3.4-1.45l1.9-3.2l3.6.8l-.35 3.7L23 12l-2.45 2.8l.35 3.7l-3.6.8l-1.9 3.2l-3.4-1.45zm2.35-6.95L16.6 9.9l-1.4-1.45l-4.25 4.25l-2.15-2.1L7.4 12z" />
                                    </svg>
                                </div>
                            @elseif($delivery->status == 'prefer')
                                <div class="tooltip" data-tip="{{ __('Preferred') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewBox="0 0 16 16">
                                        <path fill="#ffe252" fill-rule="evenodd"
                                            d="M12 6.5a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3M12 8a3 3 0 1 0-2.905-3.75H1.75a.75.75 0 0 0 0 1.5h7.345A3 3 0 0 0 12 8m-6.5 3a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0m1.405.75A3.001 3.001 0 0 1 1 11a3 3 0 0 1 5.905-.75h7.345a.75.75 0 0 1 0 1.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @elseif($delivery->status == 'delivered')
                                <div class="tooltip" data-tip="{{ __('Delivery') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M7.5 2h14v9.5h-2V4h-2v5.618l-3-1.5l-3 1.5V4h-2v5.5h-2zm6 2v2.382l1-.5l1 .5V4zm-5.065 9.25a1.25 1.25 0 0 0-.885.364l-2.05 2.05V19.5h5.627l5.803-1.45l3.532-1.508a.555.555 0 0 0-.416-1.022l-.02.005L13.614 17H10v-2h3.125a.875.875 0 1 0 0-1.75zm7.552 1.152l3.552-.817a2.56 2.56 0 0 1 3.211 2.47a2.56 2.56 0 0 1-1.414 2.287l-.027.014l-3.74 1.595l-6.196 1.549H0v-7.25h4.086l2.052-2.052a3.25 3.25 0 0 1 2.3-.948h.002h-.002h4.687a2.875 2.875 0 0 1 2.862 3.152M3.5 16.25H2v3.25h1.5z" />
                                    </svg>
                                </div>
                            @elseif($delivery->status == 'success')
                                <div class="tooltip" data-tip="{{ __('Success') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewBox="0 0 16 16">
                                        <path fill="#00c72d"
                                            d="M11.4 6.85a.5.5 0 0 0-.707-.707l-3.65 3.65l-1.65-1.65a.5.5 0 0 0-.707.707l2 2a.5.5 0 0 0 .707 0l4-4z" />
                                        <path fill="#00c72d" fill-rule="evenodd"
                                            d="M8 0C3.58 0 0 3.58 0 8s3.58 8 8 8s8-3.58 8-8s-3.58-8-8-8M1 8c0-3.87 3.13-7 7-7s7 3.13 7 7s-3.13 7-7 7s-7-3.13-7-7"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @else
                                <div class="tooltip" data-tip="{{ __('Pending') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewBox="0 0 24 24">
                                        <path fill="#858585" fill-rule="evenodd"
                                            d="M8 1a1 1 0 0 0-.716.302l-6 6.156A1 1 0 0 0 1 8.156V16a1 1 0 0 0 .293.707l6 6A1 1 0 0 0 8 23h8a1 1 0 0 0 .707-.293l6-6A1 1 0 0 0 23 16V8.156a1 1 0 0 0-.284-.698l-6-6.156A1 1 0 0 0 16 1zm0 10a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>

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
                                        <label for="modal_item_details"
                                            class="inline-flex items-center hover:underline cursor-pointer"
                                            wire:click="$dispatch('show-item-details', { data: {{ $delivery->driver->id }} })">
                                            {{ __('Item In Truck') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                viewBox="0 0 30 30" class="pt-1">
                                                <rect width="30" height="30" fill="none" />
                                                <path fill="currentColor"
                                                    d="M10.05 17.55c0 .3.09.55.26.73c.2.19.46.28.79.28c.3 0 .55-.09.73-.28l6.04-6.05v1.95q0 .45.3.75t.75.3c.29 0 .54-.1.74-.31s.3-.45.3-.75V9.7q0-.45-.3-.75c-.3-.3-.45-.3-.74-.3h-4.5c-.29 0-.54.1-.73.3s-.29.44-.29.75c0 .29.1.54.29.73s.44.29.73.29h1.95l-6.06 6.06c-.17.21-.26.47-.26.77" />
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
                            <li class="pt-3 sm:pt-4 flex flex-col items-center justify-end gap-2">
                                <a target="_blank" href="{{ route('submission.acceptance.print', $delivery->id) }}"
                                    class="btn btn-sm btn-info text-white">
                                    {{ __('Print Goods Receipt Minutes') }}
                                </a>
                                <a target="_blank"
                                    href="{{ route('submission.travel-document.print', $delivery->id) }}"
                                    class="btn btn-sm btn-info text-white">
                                    {{ __('Print Travel Document') }}
                                </a>
                                <a target="_blank" href="{{ route('delivery.print', $delivery->id) }}"
                                    class="btn btn-sm btn-info text-white">
                                    {{ __('Print Driver Report') }}
                                </a>
                                <a href="{{ route('shipment.item-damage.print', $delivery->shipment_id) }}"
                                    target="_blank"
                                    class="text-white btn btn-error btn-sm     ">{{ __('Print Damaged Items Report') }}</a>
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

