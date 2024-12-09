<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function distributions(){
        return $this->hasMany(Distribution::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function getStatusAttribute()
    {
        $hasWorkStatus = $this->deliveries()
            ->whereIn('status', ['prefer', 'delivered'])
            ->exists();
        return $hasWorkStatus ? 'bussy' : 'free';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
