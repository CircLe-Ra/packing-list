<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

}
