<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
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

    public function getDaysPassedAttribute()
    {
        if (!$this->start_date) {
            return null;
        }
        return now()->diffInDays($this->start_date, false);
    }

    public function getRemainingAmountAttribute()
    {
        return max(0, $this->target_amount - $this->raised_amount);
    }

    public function getIsCompletedAttribute()
    {
        return $this->raised_amount >= $this->target_amount;
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date && $this->end_date->isPast();
    }

    public function getAverageDonationAttribute()
    {
        return $this->donors_count > 0 ? $this->raised_amount / $this->donors_count : 0;
    }

    public function getDurationInDaysAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return null;
        }
        return $this->start_date->diffInDays($this->end_date);
    }

    public function getFormattedTargetAmountAttribute()
    {
        return number_format($this->target_amount, 2) . ' ' . config('app.currency', 'SAR');
    }

    public function getFormattedRaisedAmountAttribute()
    {
        return number_format($this->raised_amount, 2) . ' ' . config('app.currency', 'SAR');
    }

    public function getLocalizedTitleAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getLocalizedDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getLocalizedExpectedImpactAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->expected_impact_ar : $this->expected_impact_en;
    }

    public function getLocalizedAchievedImpactAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->achieved_impact_ar : $this->achieved_impact_en;
    }

    public function getFullLocationAttribute()
    {
        $location = array_filter([$this->location_city, $this->location_region, $this->location_country]);
        return implode(', ', $location);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'active' => ['text' => __('Active'), 'class' => 'bg-green-100 text-green-800'],
            'paused' => ['text' => __('Paused'), 'class' => 'bg-yellow-100 text-yellow-800'],
            'completed' => ['text' => __('Completed'), 'class' => 'bg-blue-100 text-blue-800'],
            'closed' => ['text' => __('Closed'), 'class' => 'bg-red-100 text-red-800'],
            default => ['text' => ucfirst($this->status), 'class' => 'bg-gray-100 text-gray-800']
        };
    }

    public function getUrgencyLevelAttribute()
    {
        if ($this->is_urgent) return 'urgent';
        if ($this->days_left !== null && $this->days_left <= 7) return 'critical';
        if ($this->days_left !== null && $this->days_left <= 30) return 'moderate';
        return 'normal';
    }

    // Mutators
    public function setTitleArAttribute($value)
    {
        $this->attributes['title_ar'] = trim($value);
        if (empty($this->attributes['slug'])) {
            $this->setSlugAttribute($value);
        }
    }

    public function setTitleEnAttribute($value)
    {
        $this->attributes['title_en'] = trim($value);
        if (empty($this->attributes['slug'])) {
            $this->setSlugAttribute($value);
        }
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = \Str::slug($value);
    }

    public function setTargetAmountAttribute($value)
    {
        $this->attributes['target_amount'] = max(0, (float) $value);
    }

    public function setRaisedAmountAttribute($value)
    {
        $this->attributes['raised_amount'] = max(0, (float) $value);
    }

    public function setDonorsCountAttribute($value)
    {
        $this->attributes['donors_count'] = max(0, (int) $value);
    }

    public function setDisplayOrderAttribute($value)
    {
        $this->attributes['display_order'] = (int) $value;
    }

    public function setExpectedBeneficiariesCountAttribute($value)
    {
        $this->attributes['expected_beneficiaries_count'] = max(0, (int) $value);
    }

    public function setActualBeneficiariesCountAttribute($value)
    {
        $this->attributes['actual_beneficiaries_count'] = max(0, (int) $value);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeCompleted($query)
    {
        return $query->whereRaw('raised_amount >= target_amount');
    }

    public function scopeNearDeadline($query, $days = 7)
    {
        return $query->where('end_date', '<=', now()->addDays($days))
                    ->where('end_date', '>', now());
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByLocation($query, $country = null, $region = null, $city = null)
    {
        if ($country) $query->where('location_country', $country);
        if ($region) $query->where('location_region', $region);
        if ($city) $query->where('location_city', $city);
        return $query;
    }

    public function scopeMinAmount($query, $amount)
    {
        return $query->where('target_amount', '>=', $amount);
    }

    public function scopeMaxAmount($query, $amount)
    {
        return $query->where('target_amount', '<=', $amount);
    }

    public function scopeOrderByProgress($query, $direction = 'desc')
    {
        return $query->orderByRaw("(raised_amount / target_amount) {$direction}");
    }

    public function scopeOrderByPopularity($query, $direction = 'desc')
    {
        return $query->orderBy('donors_count', $direction);
    }

    public function scopeOrderByUrgency($query)
    {
        return $query->orderBy('is_urgent', 'desc')
                    ->orderBy('end_date', 'asc')
                    ->orderBy('is_featured', 'desc');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title_ar', 'like', "%{$term}%")
              ->orWhere('title_en', 'like', "%{$term}%")
              ->orWhere('description_ar', 'like', "%{$term}%")
              ->orWhere('description_en', 'like', "%{$term}%");
        });
    }

    // Utility Methods
    public function addDonation($amount, $userId = null)
    {
        $this->increment('raised_amount', $amount);
        if ($userId) {
            $this->increment('donors_count');
        }

        // Auto-complete if target reached
        if ($this->raised_amount >= $this->target_amount && $this->status === 'active') {
            $this->update(['status' => 'completed']);
        }

        return $this;
    }

    public function canReceiveDonations()
    {
        return $this->status === 'active' && !$this->is_expired && !$this->is_completed;
    }

    public function markAsCompleted($achievedImpactAr = null, $achievedImpactEn = null)
    {
        $updateData = ['status' => 'completed'];

        if ($achievedImpactAr) $updateData['achieved_impact_ar'] = $achievedImpactAr;
        if ($achievedImpactEn) $updateData['achieved_impact_en'] = $achievedImpactEn;
        if (!$this->actual_beneficiaries_count) {
            $updateData['actual_beneficiaries_count'] = $this->expected_beneficiaries_count;
        }

        return $this->update($updateData);
    }

    public function pause($reason = null)
    {
        return $this->update(['status' => 'paused']);
    }

    public function resume()
    {
        if ($this->status === 'paused' && $this->canReceiveDonations()) {
            return $this->update(['status' => 'active']);
        }
        return false;
    }

    public function close($reason = null)
    {
        return $this->update(['status' => 'closed']);
    }

    public function toggleFeatured()
    {
        return $this->update(['is_featured' => !$this->is_featured]);
    }

    public function toggleUrgent()
    {
        return $this->update(['is_urgent' => !$this->is_urgent]);
    }

    public function getDonationStats()
    {
        return [
            'total_donations' => $this->donations->count(),
            'total_amount' => $this->raised_amount,
            'average_amount' => $this->average_donation,
            'unique_donors' => $this->donors_count,
            'recent_donations' => $this->donations()->latest()->limit(5)->get(),
            'monthly_stats' => $this->donations()
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(amount) as total')
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->get()
        ];
    }

    public function getImpactMetrics()
    {
        return [
            'progress_percentage' => $this->progress_percentage,
            'remaining_amount' => $this->remaining_amount,
            'days_left' => $this->days_left,
            'expected_beneficiaries' => $this->expected_beneficiaries_count,
            'actual_beneficiaries' => $this->actual_beneficiaries_count,
            'beneficiary_impact_ratio' => $this->expected_beneficiaries_count > 0
                ? ($this->actual_beneficiaries_count / $this->expected_beneficiaries_count) * 100
                : 0
        ];
    }

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/jpg']);
        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('documents')
            ->acceptsMimeTypes(['application/pdf', 'application/msword']);

        $this->addMediaCollection('featured_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function getFeaturedImage()
    {
        return $this->getFirstMedia('featured_image');
    }

    public function getGalleryImages()
    {
        return $this->getMedia('gallery');
    }

    // Additional Date/Time Accessors with Translations
    public function getFormattedStartDateAttribute()
    {
        if (!$this->start_date) return null;
        return app()->getLocale() === 'ar'
            ? $this->start_date->translatedFormat('d F Y')
            : $this->start_date->format('F d, Y');
    }

    public function getFormattedEndDateAttribute()
    {
        if (!$this->end_date) return null;
        return app()->getLocale() === 'ar'
            ? $this->end_date->translatedFormat('d F Y')
            : $this->end_date->format('F d, Y');
    }

    public function getLocalizedDaysLeftAttribute()
    {
        if ($this->days_left === null) return null;

        if (app()->getLocale() === 'ar') {
            if ($this->days_left == 0) return 'اليوم الأخير';
            if ($this->days_left == 1) return 'يوم واحد متبقي';
            if ($this->days_left == 2) return 'يومان متبقيان';
            if ($this->days_left <= 10) return $this->days_left . ' أيام متبقية';
            return $this->days_left . ' يوماً متبقياً';
        }

        if ($this->days_left == 0) return 'Last day';
        if ($this->days_left == 1) return '1 day left';
        return $this->days_left . ' days left';
    }

    public function getTimeStatusAttribute()
    {
        if ($this->is_expired) {
            return app()->getLocale() === 'ar' ? 'منتهي الصلاحية' : 'Expired';
        }

        if ($this->days_left === null) {
            return app()->getLocale() === 'ar' ? 'مفتوح' : 'Open-ended';
        }

        if ($this->days_left <= 0) {
            return app()->getLocale() === 'ar' ? 'منتهي' : 'Ended';
        }

        if ($this->days_left <= 3) {
            return app()->getLocale() === 'ar' ? 'عاجل جداً' : 'Very Urgent';
        }

        if ($this->days_left <= 7) {
            return app()->getLocale() === 'ar' ? 'عاجل' : 'Urgent';
        }

        return app()->getLocale() === 'ar' ? 'نشط' : 'Active';
    }

    // Advanced Financial Calculations
    public function getDailyAverageAttribute()
    {
        if (!$this->start_date || $this->days_passed <= 0) return 0;
        return $this->raised_amount / max(1, $this->days_passed);
    }

    public function getProjectedCompletionDateAttribute()
    {
        if ($this->is_completed || $this->daily_average <= 0) return null;

        $remainingDays = ceil($this->remaining_amount / $this->daily_average);
        return now()->addDays($remainingDays);
    }

    public function getFundingVelocityAttribute()
    {
        $recentDonations = $this->donations()
            ->where('created_at', '>=', now()->subDays(7))
            ->sum('amount');

        return $recentDonations / 7; // Daily average for last 7 days
    }

    public function getCompletionProbabilityAttribute()
    {
        if ($this->is_completed) return 100;
        if (!$this->end_date || $this->days_left <= 0) return 0;

        $requiredDailyRate = $this->remaining_amount / max(1, $this->days_left);
        $currentRate = $this->funding_velocity;

        if ($currentRate >= $requiredDailyRate) return 90;
        if ($currentRate >= $requiredDailyRate * 0.7) return 70;
        if ($currentRate >= $requiredDailyRate * 0.5) return 50;
        if ($currentRate >= $requiredDailyRate * 0.3) return 30;
        return 10;
    }

    public function getLocalizedCurrencyAmountAttribute()
    {
        $amount = $this->raised_amount;
        $currency = config('app.currency', 'SAR');

        if (app()->getLocale() === 'ar') {
            return number_format($amount, 2) . ' ' . $this->getArabicCurrency($currency);
        }

        return $currency . ' ' . number_format($amount, 2);
    }

    private function getArabicCurrency($currency)
    {
        return match($currency) {
            'SAR' => 'ريال سعودي',
            'USD' => 'دولار أمريكي',
            'EUR' => 'يورو',
            'AED' => 'درهم إماراتي',
            default => $currency
        };
    }

    // Validation and Business Rules
    public function canBeEdited()
    {
        return $this->status === 'active' && $this->raised_amount == 0;
    }

    public function canBeDeleted()
    {
        return $this->raised_amount == 0 && $this->donors_count == 0;
    }

    public function canBeFeatured()
    {
        return $this->status === 'active' && !$this->is_expired;
    }

    public function requiresApproval()
    {
        return $this->target_amount > config('donation.auto_approve_limit', 100000);
    }

    public function isEligibleForUrgentStatus()
    {
        return $this->days_left !== null &&
               $this->days_left <= 30 &&
               $this->progress_percentage < 70;
    }

    public function validateDonationAmount($amount)
    {
        $minAmount = config('donation.min_amount', 10);
        $maxAmount = min($this->remaining_amount, config('donation.max_amount', 100000));

        return $amount >= $minAmount && $amount <= $maxAmount;
    }

    // SEO and URL Generation Methods
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getMetaTitleAttribute()
    {
        $title = $this->localized_title;
        $siteNameAr = 'منصة التبرعات الخيرية';
        $siteNameEn = 'Charity Donations Platform';

        $siteName = app()->getLocale() === 'ar' ? $siteNameAr : $siteNameEn;

        return $title . ' - ' . $siteName;
    }

    public function getMetaDescriptionAttribute()
    {
        $description = $this->localized_description;
        $truncated = Str::limit(strip_tags($description), 155);

        if (app()->getLocale() === 'ar') {
            return $truncated . ' - ساهم في صنع الأثر وادعم المشاريع الخيرية';
        }

        return $truncated . ' - Make an impact and support charity projects';
    }

    public function getCanonicalUrlAttribute()
    {
        return route('projects.show', $this->slug);
    }

    public function getShareUrlAttribute()
    {
        return $this->canonical_url . '?utm_source=share&utm_medium=social';
    }

    public function getStructuredDataAttribute()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'DonateAction',
            'name' => $this->localized_title,
            'description' => $this->meta_description,
            'url' => $this->canonical_url,
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => route('donations.create', $this->slug)
            ],
            'object' => [
                '@type' => 'Project',
                'name' => $this->localized_title,
                'description' => $this->localized_description,
                'location' => $this->full_location,
                'targetAmount' => $this->target_amount,
                'raisedAmount' => $this->raised_amount
            ]
        ];
    }

    // Social Sharing Methods
    public function getShareTextAttribute()
    {
        if (app()->getLocale() === 'ar') {
            return "ساعدوني في دعم هذا المشروع الخيري: " . $this->localized_title .
                   "\nالهدف: " . $this->formatted_target_amount .
                   "\nتم جمع: " . $this->formatted_raised_amount .
                   "\n" . $this->share_url;
        }

        return "Help me support this charity project: " . $this->localized_title .
               "\nTarget: " . $this->formatted_target_amount .
               "\nRaised: " . $this->formatted_raised_amount .
               "\n" . $this->share_url;
    }

    public function getWhatsappShareUrlAttribute()
    {
        return 'https://wa.me/?text=' . urlencode($this->share_text);
    }

    public function getTwitterShareUrlAttribute()
    {
        $hashtags = app()->getLocale() === 'ar'
            ? 'تبرع,خير,مساعدة'
            : 'donation,charity,help';

        return 'https://twitter.com/intent/tweet?' . http_build_query([
            'text' => $this->share_text,
            'hashtags' => $hashtags,
            'url' => $this->share_url
        ]);
    }

    public function getFacebookShareUrlAttribute()
    {
        return 'https://www.facebook.com/sharer/sharer.php?' . http_build_query([
            'u' => $this->share_url,
            'quote' => $this->share_text
        ]);
    }

    // Advanced Mutators
    public function setLocationCountryAttribute($value)
    {
        $this->attributes['location_country'] = $value ? trim(ucfirst($value)) : null;
    }

    public function setLocationRegionAttribute($value)
    {
        $this->attributes['location_region'] = $value ? trim(ucfirst($value)) : null;
    }

    public function setLocationCityAttribute($value)
    {
        $this->attributes['location_city'] = $value ? trim(ucfirst($value)) : null;
    }

    public function setDescriptionArAttribute($value)
    {
        $this->attributes['description_ar'] = $value ? trim($value) : null;
    }

    public function setDescriptionEnAttribute($value)
    {
        $this->attributes['description_en'] = $value ? trim($value) : null;
    }

    public function setExpectedImpactArAttribute($value)
    {
        $this->attributes['expected_impact_ar'] = $value ? trim($value) : null;
    }

    public function setExpectedImpactEnAttribute($value)
    {
        $this->attributes['expected_impact_en'] = $value ? trim($value) : null;
    }

    // Advanced Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByProgressRange($query, $min = null, $max = null)
    {
        if ($min !== null) {
            $query->whereRaw('(raised_amount / target_amount * 100) >= ?', [$min]);
        }
        if ($max !== null) {
            $query->whereRaw('(raised_amount / target_amount * 100) <= ?', [$max]);
        }
        return $query;
    }

    public function scopeByDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate) $query->where('start_date', '>=', $startDate);
        if ($endDate) $query->where('end_date', '<=', $endDate);
        return $query;
    }

    public function scopeRecentlyCreated($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopePopular($query, $minDonors = 10)
    {
        return $query->where('donors_count', '>=', $minDonors);
    }

    public function scopeHighValue($query, $minAmount = 50000)
    {
        return $query->where('target_amount', '>=', $minAmount);
    }

    public function scopeNearingCompletion($query, $percentage = 80)
    {
        return $query->whereRaw('(raised_amount / target_amount * 100) >= ?', [$percentage])
                    ->whereRaw('raised_amount < target_amount');
    }

    public function scopeStalled($query, $days = 30)
    {
        return $query->whereDoesntHave('donations', function($q) use ($days) {
            $q->where('created_at', '>=', now()->subDays($days));
        })->where('status', 'active');
    }

    // Advanced Utility Methods
    public function createSlugFromTitle()
    {
        $title = $this->title_en ?: $this->title_ar;
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $this->slug = $slug;
        return $this;
    }

    public function calculateImpactScore()
    {
        $progressScore = $this->progress_percentage * 0.4;
        $donorScore = min(100, $this->donors_count * 2) * 0.3;
        $timeScore = ($this->days_left !== null ? max(0, 100 - $this->days_left) : 50) * 0.2;
        $beneficiaryScore = min(100, $this->expected_beneficiaries_count / 10) * 0.1;

        return round($progressScore + $donorScore + $timeScore + $beneficiaryScore, 2);
    }

    public function sendStatusChangeNotification($oldStatus, $newStatus)
    {
        // This would integrate with your notification system
        // Implementation depends on your notification setup
        return [
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'project' => $this->only(['id', 'title_ar', 'title_en', 'slug']),
            'timestamp' => now()->toISOString()
        ];
    }

    public function generateProgressReport()
    {
        return [
            'project_info' => [
                'title' => $this->localized_title,
                'description' => $this->localized_description,
                'location' => $this->full_location,
                'category' => $this->category?->localized_name
            ],
            'financial_metrics' => [
                'target_amount' => $this->target_amount,
                'raised_amount' => $this->raised_amount,
                'remaining_amount' => $this->remaining_amount,
                'progress_percentage' => $this->progress_percentage,
                'average_donation' => $this->average_donation,
                'daily_average' => $this->daily_average,
                'funding_velocity' => $this->funding_velocity
            ],
            'timeline_metrics' => [
                'start_date' => $this->start_date?->toDateString(),
                'end_date' => $this->end_date?->toDateString(),
                'days_passed' => $this->days_passed,
                'days_left' => $this->days_left,
                'duration_in_days' => $this->duration_in_days,
                'completion_probability' => $this->completion_probability
            ],
            'impact_metrics' => $this->getImpactMetrics(),
            'donation_stats' => $this->getDonationStats(),
            'generated_at' => now()->toISOString()
        ];
    }

    public function exportToArray()
    {
        return [
            'basic_info' => $this->only([
                'id', 'title_ar', 'title_en', 'description_ar', 'description_en',
                'slug', 'status', 'location_country', 'location_region', 'location_city'
            ]),
            'financial' => [
                'target_amount' => $this->target_amount,
                'raised_amount' => $this->raised_amount,
                'donors_count' => $this->donors_count,
                'progress_percentage' => $this->progress_percentage
            ],
            'dates' => [
                'start_date' => $this->start_date?->toDateString(),
                'end_date' => $this->end_date?->toDateString(),
                'created_at' => $this->created_at->toDateString(),
                'updated_at' => $this->updated_at->toDateString()
            ],
            'settings' => [
                'is_featured' => $this->is_featured,
                'is_urgent' => $this->is_urgent,
                'display_order' => $this->display_order
            ],
            'impact' => [
                'expected_beneficiaries_count' => $this->expected_beneficiaries_count,
                'actual_beneficiaries_count' => $this->actual_beneficiaries_count,
                'expected_impact_ar' => $this->expected_impact_ar,
                'expected_impact_en' => $this->expected_impact_en,
                'achieved_impact_ar' => $this->achieved_impact_ar,
                'achieved_impact_en' => $this->achieved_impact_en
            ]
        ];
    }
}
