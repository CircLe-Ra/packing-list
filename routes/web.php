<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});


Route::view('profile', 'profile')
    ->name('profile');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, '__invoke'])->name('dashboard');
    Route::get('/api/get-shipment-date', function (){
        $getData = \App\Models\Shipment::all();
        $shipment = [];
        $unloading = [];
        foreach ($getData as $dataDate) {
            $shipment[] = [
                'title' => __('Tanggal Pengiriman ') . $dataDate->loader_ship,
                'start' => \Carbon\Carbon::parse($dataDate->ta_shipment)->setTime(0, 0, 1)->format('Y-m-d\TH:i:s'),
                'end' => \Carbon\Carbon::parse($dataDate->td_shipment)->setTime(23, 59, 0)->format('Y-m-d\TH:i:s'),
            ];
            $unloading[] = [
                'title' => __('Tanggal Bongkaran ') . $dataDate->loader_ship,
                'start' => \Carbon\Carbon::parse($dataDate->unloading_date)->setTime(0, 0, 1)->format('Y-m-d\TH:i:s'),
                'end' => \Carbon\Carbon::parse($dataDate->unloading_date)->setTime(23, 59, 0)->format('Y-m-d\TH:i:s')
            ];
        }
        $data = array_merge($shipment, $unloading);
        return response()->json($data);
    })->name('api.get-shipment-date');

    //leader
    Route::middleware(['role:leader'])->group(function () {
        Volt::route('/report', 'pages.leader.report')->name('report');
        Volt::route('/report/consumer', 'pages.leader.report-consumer')->name('report.consumer');
    });

    //admin
    Route::middleware(['role:admin'])->group(function () {
        Volt::route('consumer', 'pages.admin.consumer')->name('master-data.consumer');
        Volt::route('driver', 'pages.admin.driver')->name('master-data.driver');
        Volt::route('container', 'pages.admin.container')->name('master-data.container');
        Volt::route('item-type', 'pages.admin.item-type')->name('master-data.item-type');
        Volt::route('consumers', 'pages.admin.consumers')->name('consumers');
        Volt::route('items', 'pages.admin.items')->name('items');
        Volt::route('shipments', 'pages.admin.shipments')->name('shipments');
        Volt::route('shipments/data-container/{id}', 'pages.admin.shipments.container')->name('shipments.data-container');
        Volt::route('submissions/verify', 'pages.admin.submissions.verify')->name('submissions.admin.verify');
        Volt::route('submissions/verified', 'pages.admin.submissions.verified')->name('submissions.admin.verified');
        Volt::route('user', 'pages.admin.user')->name('master-data.user');
        Volt::route('role', 'pages.admin.role')->name('master-data.role');

    });

   //agentfield
    Route::middleware(['role:fieldagen'])->group(function () {
        Volt::route('distributions', 'pages.fieldagen.distribution')->name('distribution');
        Volt::route('distributions/items/container/{id}', 'pages.fieldagen.distributions.container')->name('distribution.container');
        Volt::route('distributions/items/container/{container}/verify/{verify}', 'pages.fieldagen.distributions.verify')->name('distribution.verify');
        Volt::route('submissions/delivery-order', 'pages.fieldagen.submissions.delivery-order')->name('submissions.delivery-order');
        Volt::route('submissions/delivery-order/{shipment}/truck', 'pages.fieldagen.submissions.delivery-order-truck')->name('submissions.delivery-order.truck');
    });

    //driver
    Route::middleware(['role:driver'])->group(function () {
        Volt::route('deliveries', 'pages.driver.deliveries')->name('driver.deliveries');
    });

    Route::get('/delivery/{id}/print', [\App\Http\Controllers\ReportController::class, 'delivery'])->name('delivery.print');
    Route::get('/shipment/item-damage/{id}/print', [\App\Http\Controllers\ReportController::class, 'itemDamaged'])->name('shipment.item-damage.print');
    Route::get('/submission/acceptance/{id}/print', [\App\Http\Controllers\ReportController::class, 'acceptance'])->name('submission.acceptance.print');
    Route::get('/submission/travel-document/{id}/print', [\App\Http\Controllers\ReportController::class, 'travelDocument'])->name('submission.travel-document.print');
    Route::get('/report/container/{id}/print', [\App\Http\Controllers\ReportController::class, 'container'])->name('report.container');
});

require __DIR__.'/auth.php';
