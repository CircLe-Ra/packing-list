<?php

use function Livewire\Volt\{state, layout, title, computed, on, usesPagination};
use App\Models\Container;

layout('layouts.app');
title(__('Container'));

usesPagination();

state(['name' => '', 'number_reg' => '']);
state(['idData'])->locked();
state(['showing' => 5])->url();
state(['search' => null])->url();

$containers = computed(function(){
    return Container::where('name', 'like', '%' . $this->search . '%')
        ->orWhere('number_reg', 'like', '%' . $this->search . '%')
        ->latest()->paginate($this->showing, pageName: 'container-page');
});


on(['refresh' => fn() => $this->containers = Container::where('name', 'like', '%' . $this->search . '%')
    ->orWhere('number_reg', 'like', '%' . $this->search . '%')
    ->latest()->paginate($this->showing, pageName: 'container-page')
]);

$store = function() {
    $this->validate([
        'name' => 'required',
        'number_reg' => 'required',
    ]);

    try {
        if ($this->idData) {
            Container::find($this->idData)->update([
                'name' => $this->name,
                'number_reg' => $this->number_reg,
            ]);
            unset($this->containers);
            $this->reset(['name', 'number_reg', 'idData']);
            $this->dispatch('refresh');
            $this->dispatch('toast', message: __('Container has been updated'), data: ['position' => 'top-center', 'type' => 'success']);
        }else {
            Container::create([
                'name' => $this->name,
                'number_reg' => $this->number_reg,
            ]);
            unset($this->containers);
            $this->reset(['name', 'number_reg', 'idData']);
            $this->dispatch('refresh');
            $this->dispatch('toast', message: __('Container has been created'), data: ['position' => 'top-center', 'type' => 'success']);
        }
    } catch (\Throwable $th) {
        $this->dispatch('toast', message: __('Container could not be created'), data: ['position' => 'top-center', 'type' => 'error']);
    }

};

$edit = function($id) {
    $container = Container::find($id);
    $this->idData = $id;
    $this->name = $container->name;
    $this->number_reg = $container->number_reg;
};

$destroy = function($id) {
    try {
        $container = Container::find($id);
        $container->delete();
        unset($this->containers);
        $this->dispatch('refresh');
        $this->dispatch('toast', message: __('Container has been deleted'), data: ['position' => 'top-center', 'type' => 'success']);
    } catch (\Throwable $th) {
        $this->dispatch('toast', message: __('Container could not be deleted'), data: ['position' => 'top-center', 'type' => 'error']);
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
                    'text' => __('Container'),
                    'href' => '/container',
                ]
            ]"
    />
    <div class="flex gap-4 justift-between">
        <div class="w-1/2">
            <x-card :classes="'bg-base-200'">
                <h2 class="card-title">{{ __('Container Input') }}</h2>
                <form wire:submit="store" class="px-10">
                    <input type="hidden" wire:model="idData">
                    <x-text-input-2 name="name" wire:model="name" labelClass="my-3" :placeholder="__('Name')" />
                    <x-text-input-2 type="number" name="number_reg" wire:model="number_reg" labelClass="my-3" :placeholder="__('Number Registration')" />
                    <div class="justify-end card-actions">
                        <x-button-neutural type="reset">Batal</x-button-neutural>
                        <x-button-active>{{ __('Simpan') }}</x-button-active>
                    </div>
                </form>
            </x-card>
        </div>
        <x-card :classes="'w-1/2 bg-base-200'">
            <h2 class="card-title">{{ __('Container Data') }}</h2>
            <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
                <x-form.filter class="w-24 text-sm select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
                <x-form.search wire:model.live="search" />
            </div>
            <x-divider name="Tabel Data" class="-mt-5"/>
            <x-table class="text-center " thead="No.,Name,Number Registration" :action="true">
                @if ($this->containers && $this->containers->isNotEmpty())
                    @foreach ($this->containers as $container)
                        <tr >
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $container->name }}</td>
                            <td>{{ $container->number_reg }}</td>
                            <td>
                                <x-button-info class="text-white btn-xs" wire:click="edit({{ $container->id }})">Edit</x-button-info>
                                <x-button-error class="text-white btn-xs" wire:click="destroy({{ $container->id }})">
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
            {{ $this->containers->links('livewire.pagination') }}
        </x-card>
    </div>
</div>
