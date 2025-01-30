<?php

use function Livewire\Volt\{state, layout, title, computed, on, usesPagination, mount};
use App\Models\Shipment;
use Masmerise\Toaster\Toaster;

layout('layouts.app');
title(__('Shipments'));

usesPagination();
state(['showing' => 5])->url();
state(['search' => null])->url();
state(['first_date', 'end_date']);

$shipments = computed(function () {
    return Shipment::with('deliveries')
        ->where('loader_ship', 'like', '%' . $this->search . '%')
        ->orWhere('ta_shipment', 'like', '%' . $this->search . '%')
        ->orWhere('td_shipment', 'like', '%' . $this->search . '%')
        ->latest()
        ->paginate($this->showing, pageName: 'shipment-page');
});

$find = function () {
    $this->validate([
        'first_date' => ['required', 'date', 'before_or_equal:end_date'],
        'end_date' => ['required', 'date'],
    ]);
    $this->shipments = Shipment::whereBetween('created_at', [$this->first_date, $this->end_date])
        ->latest()
        ->paginate($this->showing, pageName: 'shipment-page');
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
                'text' => __('Reports'),
                'href' => route('report'),
            ],
        ]" class="items-start" />
    </div>

    <div>
        <h2 class="card-title">{{ __('Laporan Pengiriman') }}</h2>
        <div class="grid grid-cols-2 gap-2 mt-5">
            <div class="grid grid-cols-1 items-center ">
                <x-form.filter class="w-24 text-xs select-sm mt-1 " wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
            </div>
            <div class="grid grid-cols-3 gap-3">
                <x-text-input-4 name="first_date" type="date" class="text-xs input-sm" wire:model="first_date"
                    labelClass="-mt-4 mb-3" title="{{ __('Tanggal Awal') }}" />
                <x-text-input-4 name="end_date" type="date" class="text-xs input-sm" wire:model="end_date"
                    labelClass="-mt-4 mb-3" title="{{ __('Tanggal Akhir') }}" />
                <x-button-success type="button" class="btn-sm mt-5" wire:click="find">Cari</x-button-success>
            </div>
        </div>
        <x-divider name="Tabel Data" class="-mt-5" />
        <x-table class="text-center " thead="No.,Loader Ship,TA Ship,TD Ship,Created At, Jumlah Truck"
            :action="true">
            @if ($this->shipments && $this->shipments->isNotEmpty())
                @foreach ($this->shipments as $key => $shipment)
                    <tr @if ($key % 2 == 0) class="bg-base-300" @endif>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $shipment->loader_ship }}</td>
                        <td>{{ $shipment->ta_shipment }}</td>
                        <td>{{ $shipment->td_shipment }}</td>
                        <td>{{ $shipment->created_at }}</td>
                        <td>{{ $shipment->deliveries->count() }}</td>
                        <td class="space-y-1 space-x-1">
                            <x-button-link href="{{ route('report.container', $shipment->id) }}"
                                class="text-white btn-xs btn-info"
                                target="_blank">{{ __('Print Data Containers') }}</x-button-link>
                            <x-button-link href="{{ route('report.consumer', $shipment->id) }}"
                                class="text-white btn-xs btn-success"
                                wire:navigate>{{ __('Data Pengiriman') }}</x-button-link>
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

