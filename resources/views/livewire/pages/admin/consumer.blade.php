<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Computed};
use App\Models\Consumer;

new #[Layout('layouts.app')]  class extends Component {
    public $consumers;

    #[Computed]
    public function consumers(){
        return Consumer::latest()->get();
    }


}; ?>

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
    <div class="flex justift-between gap-4">
        <x-card :classes="'w-1/2 bg-base-200'">
            <h2 class="card-title">Card title!</h2>
                <p>If a dog chews shoes whose shoes does he choose?</p>
                <div class="card-actions justify-end">
                    <button class="btn">Buy Now</button>
                </div>
        </x-card>
        <x-card :classes="'w-1/2 bg-base-200'">
            <h2 class="card-title">{{ __('Consumer Data') }}</h2>
            <x-table thead="No.,Nama,Alamat,No. Telepon" :action="true">
                @foreach ($consumers as $consumer)
                    <tr>{{ $loop->iteration }}</tr>
                    <tr>{{ $consumer->name }}</tr>
                    <tr>{{ $consumer->phone }}</tr>
                    <tr>{{ $consumer->address }}</tr>
                @endforeach
            </x-table>
        </x-card>
    </div>
</div>
