<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Volt::route('consumer', 'pages.admin.consumer')->name('master-data.consumer');
    Volt::route('driver', 'pages.admin.driver')->name('master-data.driver');
    Volt::route('container', 'pages.admin.container')->name('master-data.container');
    Volt::route('item-type', 'pages.admin.item-type')->name('master-data.item-type');
    Volt::route('consumers', 'pages.admin.consumers')->name('consumers');
    Volt::route('items', 'pages.admin.items')->name('items');
    Volt::route('orders', 'pages.admin.orders')->name('orders');
    Volt::route('shipments', 'pages.admin.shipments')->name('shipments');
    Volt::route('shipments/data-container/{id}', 'pages.admin.shipments.container')->name('shipments.data-container');
});

require __DIR__.'/auth.php';
