<?php

use function Livewire\Volt\{state, layout, title, computed};
use App\Models\Consumer;

layout('layouts.app');
title(__('Consumer'));

$consumers = computed(function() {
    return Consumer::latest()->get();
});

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
                <form action="">
                    <x-text-input-1 name="Name" :title="__('Name')" reqired labelClass="my-5" />
                    <x-text-input-1 name="Name" :title="__('Phone Number')" reqired labelClass="my-5" />
                    <x-text-input-1 name="Name" :title="__('Address')" reqired labelClass="my-5" />
                </form>
                <div class="justify-end card-actions">
                    <button class="btn btn-neutral">Batal</button>
                    <button class="btn btn-active">Simpan</button>
                </div>
        </x-card>
        <x-card :classes="'w-1/2 bg-base-200'">
            <h2 class="card-title">{{ __('Consumer Data') }}</h2>
            <x-table thead="No.,Nama,Alamat,No. Telepon" :action="true">
                @if ($this->consumers)
                    @foreach ($this->consumers as $consumer)
                    <tr>{{ $loop->iteration }}</tr>
                    <tr>{{ $consumer->name }}</tr>
                    <tr>{{ $consumer->phone }}</tr>
                    <tr>{{ $consumer->address }}</tr>
                    @endforeach
                @else
                    <tr rowspan="5">Tidak ada data</tr>
                @endif
            </x-table>
        </x-card>
    </div>
</div>
