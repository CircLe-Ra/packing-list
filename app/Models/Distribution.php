<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function shipment_item(){
        return $this->belongsTo(ShipmentItem::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

}
