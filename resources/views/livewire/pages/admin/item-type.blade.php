<?php

use function Livewire\Volt\{state, layout, title, computed, on, usesPagination};
use App\Models\ItemType;
use Masmerise\Toaster\Toaster;

layout('layouts.app');
title(__('Units'));

usesPagination();

state(['name' => '']);
state(['idData'])->locked();
state(['showing' => 5])->url();
state(['search' => null])->url();

$itemTypes = computed(function(){
    return ItemType::where('name', 'like', '%' . $this->search . '%')
        ->latest()->paginate($this->showing, pageName: 'item-type-page');
});

on(['refresh' => fn() => $this->itemTypes = ItemType::where('name', 'like', '%' . $this->search . '%')
    ->latest()->paginate($this->showing, pageName: 'item-type-page')
]);

$store = function() {
    $this->validate([
        'name' => 'required',
    ]);

    try {
        if ($this->idData) {
            ItemType::find($this->idData)->update([
                'name' => $this->name,
            ]);
            unset($this->itemTypes);
            $this->reset(['name', 'idData']);
            $this->dispatch('refresh');
            Toaster::success(__('Item type has been updated'));

        } else {
            ItemType::create([
                'name' => $this->name,
            ]);
            unset($this->itemTypes);
            $this->reset(['name', 'idData']);
            $this->dispatch('refresh');
            $this->dispatch('toast', message: __('Item type has been created'), data: ['position' => 'top-center', 'type' => 'success']);
        }
    } catch (\Throwable $th) {
        $this->dispatch('toast', message: __('Item type could not be created'), data: ['position' => 'top-center', 'type' => 'error']);
    }
};

$edit = function($id) {
    $itemType = ItemType::find($id);
    $this->idData = $id;
    $this->name = $itemType->name;
};

$destroy = function($id) {
    try {
        $itemType = ItemType::find($id);
        $itemType->delete();
        unset($this->itemTypes);
        $this->dispatch('refresh');
        $this->dispatch('toast', message: __('Item type has been deleted'), data: ['position' => 'top-center', 'type' => 'success']);
    } catch (\Throwable $th) {
        $this->dispatch('toast', message: __('Item type could not be deleted'), data: ['position' => 'top-center', 'type' => 'error']);
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
                    'text' => __('Units'),
                    'href' => route('master-data.item-type'),
                ]
            ]"
    />
    <div class="flex gap-4 justify-between">
        <div class="w-2/5">
            <x-card class="bg-base-200">
                <h2 class="card-title">{{ __('Unit Input') }}</h2>
                <form wire:submit="store" >
                    <input type="hidden" wire:model="idData">
                    <x-text-input-2 name="name" wire:model="name" labelClass="my-3" :placeholder="__('Name')" />
                    <div class="justify-end card-actions">
                        <x-button-neutural type="reset">{{ __('Cancel') }}</x-button-neutural>
                        <x-button-active>{{ __('Save') }}</x-button-active>
                    </div>
                </form>
            </x-card>
        </div>
        <x-card class="w-3/5 bg-base-200">
            <h2 class="card-title">{{ __('Unit Data') }}</h2>
            <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
                <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
                <x-form.search wire:model.live="search" class="w-32" />
            </div>
            <x-divider :name="__('Table Data')" class="-mt-5"/>
            <x-table class="text-center " thead="No.,Name,Created At" :action="true">
                @if ($this->itemTypes && $this->itemTypes->isNotEmpty())
                    @foreach ($this->itemTypes as $itemType)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $itemType->name }}</td>
                            <td>{{ $itemType->created_at->diffForHumans() }}</td>
                            <td>
                                <x-button-info class="text-white btn-xs" wire:click="edit({{ $itemType->id }})">Edit</x-button-info>
                                <x-button-error class="text-white btn-xs" wire:click="destroy({{ $itemType->id }})" wire:confirm="{{ __('Are you sure you want to delete this data?')}}">
                                    {{ __('Delete') }}
                                </x-button-error>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">{{ __('No Data') }}</td>
                    </tr>
                @endif
            </x-table>
            {{ $this->itemTypes->links('livewire.pagination') }}
        </x-card>
    </div>
</div>
