<?php

use function Livewire\Volt\{state, layout, title, computed, on, usesPagination};
use App\Models\Container;
use Masmerise\Toaster\Toaster;

layout('layouts.app');
title(__('Container'));

usesPagination();

state(['number_container' => '']);
state(['idData']);
state(['showing' => 5])->url();
state(['search' => null])->url();

$containers = computed(function () {
    return Container::where('number_container', 'like', '%' . $this->search . '%')
        ->latest()
        ->paginate($this->showing, pageName: 'container-page');
});

on([
    'refresh' => fn() => ($this->containers = Container::where('number_container', 'like', '%' . $this->search . '%')
        ->latest()
        ->paginate($this->showing, pageName: 'container-page')),
]);

$store = function () {
    $this->validate([
        'number_container' => 'required',
    ]);

    try {
        if ($this->idData) {
            Container::find($this->idData)->update([
                'number_container' => $this->number_container,
            ]);
            unset($this->containers);
            $this->reset(['number_container', 'idData']);
            $this->dispatch('refresh');
            Toaster::success(__('Container has been updated'));
        } else {
            Container::create([
                'number_container' => $this->number_container,
            ]);
            unset($this->containers);
            $this->reset(['number_container', 'idData']);
            $this->dispatch('refresh');
            Toaster::success(__('Container has been created'));
        }
    } catch (Throwable $th) {
        Toaster::error(__('Container could not be created'));
    }
};

$edit = function ($id) {
    $container = Container::find($id);
    $this->idData = $id;
    $this->number_container = $container->number_container;
};

$destroy = function ($id) {
    try {
        $container = Container::find($id);
        $container->delete();
        unset($this->containers);
        $this->dispatch('refresh');
        Toaster::success(__('Container has been deleted'));
    } catch (Throwable $th) {
        Toaster::error(__('Container could not be deleted'));
    }
};

?>

<div>
    <x-breadcrumb :crumbs="[
        [
            'text' => __('Dashboard'),
            'href' => '/dashboard',
        ],
        [
            'text' => __('Container'),
            'href' => route('master-data.container'),
        ],
    ]" />
    <div class="flex justify-between gap-4">
        <div class="w-2/5">
            <x-card class="bg-base-200 rounded-2xl">
                <h2 class="card-title">{{ __('Container Input') }}</h2>
                <form wire:submit="store" class="">
                    <input type="hidden" wire:model="idData">
                    <x-text-input-2 type="text" name="number_container" wire:model="number_container" labelClass="my-3"
                        :placeholder="__('Number Container')" />
                    <div class="justify-end card-actions">
                        <x-button-neutural type="reset">{{ __('Cancel') }}</x-button-neutural>
                        <x-button-active>{{ __('Save') }}</x-button-active>
                    </div>
                </form>
            </x-card>
        </div>
        <x-card class="w-3/5 bg-base-200">
            <h2 class="card-title">{{ __('Container Data') }}</h2>
            <div
                class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
                <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
                <x-form.search wire:model.live="search" class="w-32" />
            </div>
            <x-divider name="Table Data" class="-mt-5" />
            <x-table class="text-center " thead="No.,Number Container,Created At" :action="true">
                @if ($this->containers && $this->containers->isNotEmpty())
                    @foreach ($this->containers as $container)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $container->number_container }}</td>
                            <td>{{ $container->created_at }}</td>
                            <td class="space-y-1 space-x-1">
                                <x-button-info class="text-white btn-xs"
                                    wire:click="edit({{ $container->id }})">Edit</x-button-info>
                                <x-button-error class="text-white btn-xs" wire:click="destroy({{ $container->id }})"
                                    wire:confirm="{{ __('Are you sure you want to delete this data?') }}">
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

