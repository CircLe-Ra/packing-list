<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function driver(){
        return $this->belongsTo(Driver::class);
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }

    public function delivery_images(){
        return $this->hasMany(DeliveryImage::class);
    }

}
