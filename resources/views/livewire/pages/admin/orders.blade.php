<?php

use Livewire\Volt\Component;
use function Livewire\Volt\{layout, title, state, computed, usesPagination, on};
use App\Models\Order;

    layout('layouts.app');
    title(__('Order'));

usesPagination();

    state(['idData'])->locked();
    state(['order', 'ship']);
    state(['showing' => 5])->url();
    state(['search' => null])->url();

   $orders = computed(function(){
           return Order::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('ship', 'like', '%' . $this->search . '%')
                ->latest()->paginate($this->showing, pageName: 'order-page');
   });



   on(['refresh' => fn() => $this->orders = Order::where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('ship', 'like', '%' . $this->search . '%')
                                ->latest()->paginate($this->showing, pageName: 'order-page')
   ]);

    $tutup = function () {
        $this->dispatch('close-modal');
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
                    'href' => '/driver',
                ]
            ]"
        >
        <button class="btn" onclick="modal.showModal()">Tambah</button>

        </x-breadcrumb>

        <x-form.modal class="w-11/12 max-w-5xl">
            <form wire:submit="save">
                <x-text-input-1 name="name" wire:model="name" labelClass="my-3" :title="__('Name')" />
                <x-text-input-1 name="ship" wire:model="ship" labelClass="my-3" :title="__('Ship')" />
                <x-text-input-1 type="date" name="date" wire:model="date" labelClass="my-3" :title="__('Date')" />
                <div class="flex justify-end">
                    <button class="btn btn-primary ">{{ __('Save') }}</button>
                </div>
            </form>
        </x-form.modal>

        <h2 class="card-title">{{ __('Driver Data') }}</h2>
        <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
            <x-form.filter class="w-24 text-sm select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
            <x-form.search wire:model.live="search" />
        </div>

</div>
