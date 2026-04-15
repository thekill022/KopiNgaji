<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZoneArea extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function shippingZone()
    {
        return $this->belongsTo(ShippingZone::class);
    }
}
