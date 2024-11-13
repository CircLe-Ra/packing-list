<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function container(){
        return $this->belongsTo(Container::class);
    }

    public function shipment_items(){
        return $this->hasMany(ShipmentItem::class);
    }
}
