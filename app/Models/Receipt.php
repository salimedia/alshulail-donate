<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'receipt_number',
        'donation_id',
        'user_id',
        'amount',
        'currency',
        'is_tax_receipt',
        'pdf_path',
        'issued_at',
        'emailed_at',
        'downloaded_at',
        'download_count',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_tax_receipt' => 'boolean',
        'issued_at' => 'datetime',
        'emailed_at' => 'datetime',
        'downloaded_at' => 'datetime',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
