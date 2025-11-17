<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'beneficiable_type',
        'beneficiable_id',
        'category_id',
        'count',
        'type',
        'location_country',
        'location_region',
        'location_city',
        'expected_impact_ar',
        'expected_impact_en',
        'achieved_impact_ar',
        'achieved_impact_en',
        'notes',
    ];

    public function beneficiable()
    {
        return $this->morphTo();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
