<?php

use function Livewire\Volt\{state, layout, title, computed, on, usesPagination};
use App\Models\Driver;

layout('layouts.app');
title(__('Driver'));

usesPagination();

state(['name' => '', 'phone' => '', 'vehicle_number' => '']);
state(['idData'])->locked();
state(['showing' => 5])->url();
state(['search' => null])->url();

$drivers = computed(function(){
    return Driver::where('name', 'like', '%' . $this->search . '%')
        ->orWhere('phone', 'like', '%' . $this->search . '%')
        ->orWhere('vehicle_number', 'like', '%' . $this->search . '%')
        ->latest()->paginate($this->showing, pageName: 'driver-page');
});


on(['refresh' => fn() => $this->drivers = Driver::where('name', 'like', '%' . $this->search . '%')
    ->orWhere('phone', 'like', '%' . $this->search . '%')
    ->orWhere('vehicle_number', 'like', '%' . $this->search . '%')
    ->latest()->paginate($this->showing, pageName: 'driver-page')
]);

$store = function() {
    $this->validate([
        'name' => 'required',
        'phone' => 'required',
        'vehicle_number' => 'required',
    ]);

    try {
        if ($this->idData) {
            Driver::find($this->idData)->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'vehicle_number' => $this->vehicle_number,
            ]);
            unset($this->drivers);
            $this->reset(['name', 'phone', 'vehicle_number', 'idData']);
            $this->dispatch('refresh');
            $this->dispatch('toast', message: __('Driver has been updated'), data: ['position' => 'top-center', 'type' => 'success']);
        }else {
            Driver::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'vehicle_number' => $this->vehicle_number,
            ]);
            unset($this->drivers);
            $this->reset(['name', 'phone', 'vehicle_number', 'idData']);
            $this->dispatch('refresh');
            $this->dispatch('toast', message: __('Driver has been created'), data: ['position' => 'top-center', 'type' => 'success']);
        }
    } catch (\Throwable $th) {
        $this->dispatch('toast', message: __('Driver could not be created'), data: ['position' => 'top-center', 'type' => 'error']);
    }

};

$edit = function($id) {
    $driver = Driver::find($id);
    $this->idData = $id;
    $this->name = $driver->name;
    $this->phone = $driver->phone;
    $this->vehicle_number = $driver->vehicle_number;
};

$destroy = function($id) {
    try {
        $driver = Driver::find($id);
        $driver->delete();
        unset($this->drivers);
        $this->dispatch('refresh');
        $this->dispatch('toast', message: __('Driver has been deleted'), data: ['position' => 'top-center', 'type' => 'success']);
    } catch (\Throwable $th) {
        $this->dispatch('toast', message: __('Driver could not be deleted'), data: ['position' => 'top-center', 'type' => 'error']);
    }
}

?>

<div>
    <x-breadcrumb :crumbs="[
                [
                    'text' => __('Dashboard'),
                    'href' => '/dashboard',
                ],
                [
                    'text' => __('Driver'),
                    'href' => route('master-data.driver'),
                ]
            ]"
    />
    <div class="flex gap-4 justify-between">
        <div class="w-2/5">
            <x-card class="bg-base-200">
                <h2 class="card-title">{{ __('Driver Input') }}</h2>
                <form wire:submit="store" class="px-10">
                    <input type="hidden" wire:model="idData">
                    <x-text-input-2 name="name" wire:model="name" labelClass="my-3" :placeholder="__('Name')" />
                    <x-text-input-2 type="number" name="phone" wire:model="phone" labelClass="my-3" :placeholder="__('Phone Number')" />
                    <x-text-input-2 name="vehicle_number" wire:model="vehicle_number" labelClass="my-3" :placeholder="__('Vehicle Number')" />
                    <div class="justify-end card-actions">
                        <x-button-neutural type="reset">{{ __('Cancel') }}</x-button-neutural>
                        <x-button-active>{{ __('Save') }}</x-button-active>
                    </div>
                </form>
            </x-card>
        </div>
    <x-card class="w-3/5 bg-base-200">
            <h2 class="card-title">{{ __('Driver Data') }}</h2>
            <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
                <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
                <x-form.search wire:model.live="search" class="w-32" />
            </div>
            <x-divider name="Tabel Data" class="-mt-5"/>
            <x-table class="text-center " thead="No.,Name,Phone Number,Vehicle Number,Created At" :action="true">
                @if ($this->drivers && $this->drivers->isNotEmpty())
                    @foreach ($this->drivers as $driver)
                        <tr >
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $driver->name }}</td>
                            <td>{{ $driver->phone }}</td>
                            <td>{{ $driver->vehicle_number }}</td>
                            <td>{{ $driver->created_at->diffForHumans() }}</td>
                            <td>
                                <x-button-info class="text-white btn-xs" wire:click="edit({{ $driver->id }})">Edit</x-button-info>
                                <x-button-error class="text-white btn-xs" wire:click="destroy({{ $driver->id }})" wire:confirm="{{ __('Are you sure you want to delete this data?')}}">
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
            {{ $this->drivers->links('livewire.pagination') }}
        </x-card>
    </div>
</div>
