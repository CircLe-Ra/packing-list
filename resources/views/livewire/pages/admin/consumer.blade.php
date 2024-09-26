<?php

use function Livewire\Volt\{state, layout, title, mount, on};
use App\Models\Consumer;

layout('layouts.app');
title(__('Consumer'));

state(['consumers' => [], 'name' => '', 'phone' => '', 'address' => '']);
state(['idData'])->locked();
state(['showing' => 5])->url();
state(['search' => null])->url();

mount(function() {
    $this->consumers = Consumer::latest()->get();
});

on(['refresh' => fn() => $this->consumers = Consumer::latest()->get()]);

$store = function() {
    $this->validate([
        'name' => 'required',
        'phone' => 'required',
        'address' => 'required',
    ]);

    try {
        if ($this->idData) {
            Consumer::find($this->idData)->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);
            $this->reset(['name', 'phone', 'address']);
            $this->dispatch('refresh');
            $this->dispatch('toast', message: __('Consumer has been updated'), data: ['position' => 'top-center', 'type' => 'success']);
        }else {
            Consumer::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);
            $this->reset(['name', 'phone', 'address']);
            $this->dispatch('refresh');
            $this->dispatch('toast', message: __('Consumer has been created'), data: ['position' => 'top-center', 'type' => 'success']);
        }
    } catch (\Throwable $th) {
        $this->dispatch('toast', message: __('Consumer could not be created'), data: ['position' => 'top-center', 'type' => 'error']);
    }

};

$edit = function($id) {
    $consumer = Consumer::find($id);
    $this->idData = $id;
    $this->name = $consumer->name;
    $this->phone = $consumer->phone;
    $this->address = $consumer->address;
};

$destroy = function($id) {
    try {
        $consumer = Consumer::find($id);
        $consumer->delete();
        $this->dispatch('refresh');
        $this->dispatch('toast', message: __('Consumer has been deleted'), data: ['position' => 'top-center', 'type' => 'success']);
    } catch (\Throwable $th) {
        $this->dispatch('toast', message: __('Consumer could not be deleted'), data: ['position' => 'top-center', 'type' => 'error']);
        //throw $th;
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
                    'text' => __('Consumer'),
                    'href' => '/consumer',
                ]
            ]"
    />
    <div class="flex gap-4 justift-between">
        <x-card :classes="'w-1/2 bg-base-200'">
            <h2 class="card-title">{{ __('Consumer Input') }}</h2>
                <form wire:submit="store" class="px-10">
                    <input type="hidden" wire:model="idData">
                    <x-text-input-2 name="name" wire:model="name" labelClass="my-3" :placeholder="__('Name')" />
                    <x-text-input-2 type="number" name="phone" wire:model="phone" labelClass="my-3" :placeholder="__('Phone Number')" />
                    <x-text-input-2 name="address" wire:model="address" labelClass="my-3" :placeholder="__('Address')" />
                    <div class="justify-end card-actions">
                        <x-button-neutural type="reset">Batal</x-button-neutural>
                        <x-button-active>{{ __('Simpan') }}</x-button-active>
                    </div>
                </form>
        </x-card>
        <x-card :classes="'w-1/2 bg-base-200'">
            <h2 class="card-title">{{ __('Consumer Data') }}</h2>
            <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
                <x-form.filter wire:model.live="showing" />
            </div>
                <x-divider name="Data Tabel "/>
            <x-table class="text-center " thead="No.,Name,Phone Number,Address" :action="true">
                @if (count($consumers))
                    @foreach ($consumers as $consumer)
                        <tr >
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $consumer->name }}</td>
                            <td>{{ $consumer->address }}</td>
                            <td>{{ $consumer->phone }}</td>
                            <td>
                                <x-button-info class="text-white btn-xs" wire:click="edit({{ $consumer->id }})">Edit</x-button-info>
                                <x-button-error class="text-white btn-xs" wire:click="destroy({{ $consumer->id }})">
                                    {{ __('Delete') }}
                                </x-button-error>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="5" rowspan="{{ count($consumers) }}" class="text-center">{{ __('No Data') }}</td>
                </tr>
                @endif
            </x-table>
        </x-card>
    </div>
</div>
