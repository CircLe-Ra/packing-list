<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\Container;
use App\Models\Driver;
use App\Models\Shipment;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalConsumers = Consumer::count();
        $totalContainers = Container::count();
        $totalDrivers = Driver::count();
        $totalShipments = Shipment::count();

        $driverWorks = Driver::whereHas('deliveries', function ($query){
            $query->where('status', 'delivered');
        })->get();

        return view('dashboard', compact('totalConsumers', 'totalDrivers', 'totalShipments', 'totalContainers', 'driverWorks'));
    }

}