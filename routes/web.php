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
});

require __DIR__.'/auth.php';