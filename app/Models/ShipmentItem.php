<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   ShipmentItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['distributions','item_damages'];

    public function shipment_detail()
    {
        return $this->belongsTo(ShipmentDetail::class);
    }

    public function distributions(){
        return $this->hasMany(Distribution::class);
    }

    public function item_damages()
    {
        return $this->hasMany(ItemDamage::class);
    }
}
