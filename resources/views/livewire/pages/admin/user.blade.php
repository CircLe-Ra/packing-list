<?php

use function Livewire\Volt\{state, layout, title, computed, on, usesPagination};
use App\Models\User;
use Spatie\Permission\Models\Role;
use Masmerise\Toaster\Toaster;

layout('layouts.app');
title(__('User Management'));

usesPagination();

state(['name' => '', 'email' => '', 'password' => '', 'role_name' => '', 'idData']);
state(['showing' => 5])->url();
state(['search' => null])->url();

$users = computed(function () {
    return User::with('roles')->where('name', 'like', '%' . $this->search . '%')
        ->orWhere('email', 'like', '%' . $this->search . '%')
        ->latest()->paginate($this->showing, pageName: 'user-page');
});

$store = function () {
    $this->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email' . ($this->idData ? ',' . $this->idData : ''),
        'password' => 'required|min:6',
        'role_name' => 'required|exists:roles,name',
    ]);

    try {
        if ($this->idData) {
            $user = User::find($this->idData);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
            $user->assignRole($this->role_name);
            unset($this->users);
            $this->reset(['name', 'email', 'password', 'role_name', 'idData']);
            $this->dispatch('refresh');
            Toaster::success(__('User has been updated'));
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
            $user->syncRoles([$this->role_name]);
            unset($this->users);
            $this->reset(['name', 'email', 'password', 'role_name', 'idData']);
            $this->dispatch('refresh');
            Toaster::success(__('User has been created'));
        }
    } catch (\Throwable $th) {
        $this->dispatch('toast', message: __('User could not be created'), data: ['position' => 'top-center', 'type' => 'error']);
        Toaster::error(__('User could not be created'));
    }
};

$edit = function ($id) {
    $user = User::find($id);
    $this->idData = $id;
    $this->name = $user->name;
    $this->email = $user->email;
    $this->role_name = $user->roles->first()->name  ?? null;
};

$destroy = function ($id) {
    try {
        $user = User::find($id);
        $user->delete();
        unset($this->users);
        $this->dispatch('refresh');
        Toaster::success(__('User has been deleted'));
    } catch (\Throwable $th) {
        Toaster::error(__('User could not be deleted'));
    }
};

?>

<div>
    <x-breadcrumb :crumbs="[
                ['text' => __('Dashboard'), 'href' => '/dashboard'],
                ['text' => __('Users'), 'href' => route('master-data.user')]
            ]"
    />
    <div class="flex gap-4 justify-between">
        <div class="w-2/5">
            <x-card class="bg-base-200">
                <h2 class="card-title">{{ __('User Input') }}</h2>
                <form wire:submit="store" class="px-10">
                    <input type="hidden" wire:model="idData">
                    <x-text-input-2 name="name" wire:model="name" labelClass="my-3" :placeholder="__('Name')" />
                    <x-text-input-2 type="email" name="email" wire:model="email" labelClass="my-3" :placeholder="__('Email')" />
                    <x-text-input-2 type="password" name="password" wire:model="password" labelClass="my-3" :placeholder="__('Password')" />

                    <!-- Dropdown untuk memilih role -->
                    <div class="mt-3">
                        <x-select-input :label="__('Role')" wire:model="role_name" name="role_name" id="role_name">
                            <option value="">{{ __('Select Role') }}</option>
                            @foreach (Role::all() as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </x-select-input>
                    </div>

                    <div class="justify-end card-actions mt-5">
                        <x-button-neutural type="reset">{{ __('Cancel') }}</x-button-neutural>
                        <x-button-active>{{ __('Save') }}</x-button-active>
                    </div>
                </form>
            </x-card>
        </div>

        <x-card class="w-3/5 bg-base-200">
            <h2 class="card-title">{{ __('User Data') }}</h2>
            <div class="flex flex-wrap items-center justify-between py-4 space-y-4 flex-column sm:flex-row sm:space-y-0">
                <x-form.filter class="w-24 text-xs select-sm" wire:model.live="showing" :select="['5', '10', '20', '50', '100']" />
                <x-form.search wire:model.live="search" class="w-32" />
            </div>
            <x-divider name="Tabel Data" class="-mt-5"/>
            <x-table class="text-center" thead="No.,Name,Email,Role,Created At" :action="true">
                @if ($this->users && $this->users->isNotEmpty())
                    @foreach ($this->users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles->first()->name ?? __('No Role') }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                            <td class="space-y-1 space-x-1">
                                <x-button-info class="text-white btn-xs" wire:click="edit({{ $user->id }})">Edit</x-button-info>
                                <x-button-error class="text-white btn-xs" wire:click="destroy({{ $user->id }})" wire:confirm="{{ __('Are you sure you want to delete this data?') }}">
                                    {{ __('Delete') }}
                                </x-button-error>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">{{ __('No Data') }}</td>
                    </tr>
                @endif
            </x-table>
            {{ $this->users->links('livewire.pagination') }}
        </x-card>
    </div>
</div>
