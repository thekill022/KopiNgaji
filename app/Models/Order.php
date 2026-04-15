<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public static array $statuses = [
        'PENDING'   => 'Pending',
        'PAID'      => 'Paid',
        'CANCELLED' => 'Cancelled',
        'COMPLETED' => 'Completed',
        'REFUNDED'  => 'Refunded',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'subtotal_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'platform_fee_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shippingZone()
    {
        return $this->belongsTo(ShippingZone::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}
