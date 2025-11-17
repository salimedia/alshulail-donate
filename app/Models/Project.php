<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'slug',
        'target_amount',
        'raised_amount',
        'donors_count',
        'category_id',
        'status',
        'location_country',
        'location_region',
        'location_city',
        'expected_beneficiaries_count',
        'actual_beneficiaries_count',
        'expected_impact_ar',
        'expected_impact_en',
        'achieved_impact_ar',
        'achieved_impact_en',
        'start_date',
        'end_date',
        'is_featured',
        'is_urgent',
        'display_order',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'raised_amount' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_urgent' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function beneficiaries()
    {
        return $this->morphMany(Beneficiary::class, 'beneficiable');
    }

    public function statistics()
    {
        return $this->morphMany(Statistic::class, 'statisticable');
    }

    // Accessors
    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount == 0) {
            return 0;
        }
        return min(100, ($this->raised_amount / $this->target_amount) * 100);
    }

    public function getDaysLeftAttribute()
    {
        if (!$this->end_date) {
            return null;
        }
        return now()->diffInDays($this->end_date, false);
    }
}
