<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $guarded = ['id'];

    public function shipment_details() {
        return $this->hasMany(ShipmentDetail::class);
    }

    public function deliveries() {
        return $this->hasMany(Delivery::class);
    }

}
