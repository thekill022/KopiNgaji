<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    /** @use HasFactory<\Database\Factories\WithdrawalFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'amount'                  => 'decimal:2',
        'gross_amount'            => 'decimal:2',
        'platform_fee_deduction'  => 'decimal:2',
        'admin_fee_amount'        => 'decimal:2',
        'net_disbursed'           => 'decimal:2',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
