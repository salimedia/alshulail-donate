<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Donation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'donation_number',
        'user_id',
        'project_id',
        'category_id',
        'amount',
        'currency',
        'status',
        'is_anonymous',
        'is_recurring',
        'recurring_frequency',
        'next_recurring_date',
        'is_gift',
        'gift_recipient_name',
        'gift_recipient_email',
        'gift_message',
        'gift_occasion',
        'gift_delivery_date',
        'gift_sent',
        'gift_sent_at',
        'donor_name',
        'donor_email',
        'donor_phone',
        'notes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'is_recurring' => 'boolean',
        'is_gift' => 'boolean',
        'gift_sent' => 'boolean',
        'next_recurring_date' => 'date',
        'gift_delivery_date' => 'date',
        'gift_sent_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }

    // Boot method to generate donation number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($donation) {
            if (empty($donation->donation_number)) {
                $donation->donation_number = 'DON-' . strtoupper(Str::random(10));
            }
        });
    }
}
