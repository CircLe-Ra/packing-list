<?php

use function Livewire\Volt\{state, layout, title, computed, usesPagination};
use App\Models\Shipment;
use Masmerise\Toaster\Toaster;

layout('layouts.app');
title(__('Shipments'));

usesPagination();
state(['showing' => 5])->url();
state(['search' => null])->url();

$shipments = computed(function () {
    return Shipment::where('loader_ship', 'like', '%' . $this->search . '%')
        ->orWhere('ta_shipment', 'like', '%' . $this->search . '%')
        ->orWhere('td_shipment', 'like', '%' . $this->search . '%')
        ->latest()->paginate($this->showing, pageName: 'shipment-page');
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
                        'text' => __('Submissions')
                    ],
                    [
                        'text' => __('Delivery Order'),
                        'href' => route('submissions.delivery-order'),
                    ]
                ]"
                      class="items-start"
        />
    </div>

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
                            <x-button-link href="{{ route('submissions.delivery-order.truck', $shipment->id) }}" class="text-white btn-xs btn-success" wire:navigate>{{ __('Verify Truck') }}</x-button-link>
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
