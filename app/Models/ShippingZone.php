<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'cost' => 'decimal:2',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function areas()
    {
        return $this->hasMany(ShippingZoneArea::class);
    }
}
