<?php

use function Livewire\Volt\{state, layout, title, computed, on};
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Masmerise\Toaster\Toaster;

layout('layouts.app');
title(__('Role Management'));

state(['role_name' => '', 'idData']);
state(['showing' => 5])->url();
state(['search' => null])->url();

$roles = computed(function () {
    return Role::where('name', 'like', '%' . $this->search . '%')
        ->latest()->paginate($this->showing, pageName: 'role-page');
});

$store = function () {
    $this->validate([
        'role_name' => 'required|unique:roles,name',
    ]);

    try {
        if ($this->idData) {
            $role = Role::find($this->idData);
            $role->update(['name' => $this->role_name]);
            unset($this->roles);
            $this->reset(['role_name', 'idData']);
            $this->dispatch('refresh');
            Toaster::success(__('Role has been updated'));
        } else {
            $role = Role::create(['name' => $this->role_name]);
            unset($this->roles);
            $this->reset(['role_name', 'idData']);
            $this->dispatch('refresh');
            Toaster::success(__('Role has been created'));
        }
    } catch (\Throwable $th) {
        $this->dispatch('toast', message: __('Role could not be created'), data: ['position' => 'top-center', 'type' => 'error']);
        Toaster::error(__('Role could not be created'));
    }
};

$edit = function ($id) {
    $role = Role::find($id);
    $this->idData = $id;
    $this->role_name = $role->name;
};

$destroy = function ($id) {
    try {
        Role::destroy($id);
        unset($this->roles);
        $this->dispatch('refresh');
        Toaster::success(__('Role has been deleted'));
    } catch (\Throwable $th) {
        Toaster::error(__('Role could not be deleted'));
    }
};

?>

<div>
    <x-breadcrumb :crumbs="[
                ['text' => __('Dashboard'), 'href' => '/dashboard'],
                ['text' => __('Roles'), 'href' => route('master-data.role')]
            ]"
    />
    <div class="flex gap-4 justify-between">
        <div class="w-2/5">
            <x-card class="bg-base-200">
                <h2 class="card-title">{{ __('Role Input') }}</h2>
                <form wire:submit="store" class="px-10">
                    <input type="hidden" wire:model="idData">
                    <x-text-input-2 name="role_name" wire:model="role_name" labelClass="my-3" :placeholder="__('Role Name')" />
                    <div class="justify-end card-actions">
                        <x-button-neutural type="reset">{{ __('Cancel') }}</x-button-neutural>
                        <x-button-active>{{ __('Save') }}</x-button-active>
                    </div>
                </form>
            </x-card>
        </div>

        <x-card class="w-3/5 bg-base-200">
            <h2 class="card-title">{{ __('Role Data') }}</h2>
            <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
                <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
                <x-form.search wire:model.live="search" class="w-32" />
            </div>
            <x-divider name="Tabel Data" class="-mt-5"/>
            <x-table class="text-center" thead="No.,Role Name,Created At" :action="true">
                @if ($this->roles && $this->roles->isNotEmpty())
                    @foreach ($this->roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at->diffForHumans() }}</td>
                            <td class="space-y-1 space-x-1">
                                <x-button-info class="text-white btn-xs" wire:click="edit({{ $role->id }})">Edit</x-button-info>
                                <x-button-error class="text-white btn-xs" wire:click="destroy({{ $role->id }})" wire:confirm="{{ __('Are you sure you want to delete this data?') }}">
                                    {{ __('Delete') }}
                                </x-button-error>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">{{ __('No Data') }}</td>
                    </tr>
                @endif
            </x-table>
            {{ $this->roles->links('livewire.pagination') }}
        </x-card>
    </div>
</div>
