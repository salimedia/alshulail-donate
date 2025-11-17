<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'donation_id',
        'amount',
        'currency',
        'payment_method',
        'payment_gateway',
        'status',
        'gateway_transaction_id',
        'gateway_reference',
        'gateway_response',
        'fee_amount',
        'net_amount',
        'card_last_four',
        'card_brand',
        'failure_reason',
        'paid_at',
        'refunded_at',
        'refund_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
