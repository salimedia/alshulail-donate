@extends('layouts.app')

@section('title', (app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en) . ' - ' . config('app.name'))

@section('description', Str::limit(strip_tags(app()->getLocale() == 'ar' ? $project->description_ar : $project->description_en), 155))

@push('styles')
<!-- SEO Meta Tags -->
<meta name="keywords" content="{{ app()->getLocale() == 'ar' ? 'تبرع, صدقة, مشاريع خيرية' : 'donation, charity, projects' }}">
<meta name="author" content="{{ config('app.name') }}">
<link rel="canonical" href="{{ route('projects.show', $project->slug) }}">

<!-- Open Graph Meta Tags -->
<meta property="og:type" content="website">
<meta property="og:title" content="{{ app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en }}">
<meta property="og:description" content="{{ Str::limit(strip_tags(app()->getLocale() == 'ar' ? $project->description_ar : $project->description_en), 155) }}">
<meta property="og:url" content="{{ route('projects.show', $project->slug) }}">
<meta property="og:site_name" content="{{ config('app.name') }}">
@if($project->projectImages && count($project->projectImages) > 0)
<meta property="og:image" content="{{ $project->projectImages->first()->getUrl() }}">
@endif
@endpush

@section('content')
<!-- Hero Section with Project Image -->
<section class="hero-section position-relative" style="min-height: 60vh; background: linear-gradient(135deg, rgba(0,99,65,0.8), rgba(0,99,65,0.6));">
    @if($project->projectImages && count($project->projectImages) > 0)
        <div class="position-absolute w-100 h-100" style="top:0;left:0;z-index:-1;">
            <img
                src="{{ $project->projectImages->first()->getUrl() }}"
                alt="{{ app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en }}"
                class="w-100 h-100 object-fit-cover"
                style="object-fit: cover;"
            >
        </div>
    @endif
    
    <div class="container h-100 d-flex align-items-center">
        <div class="row w-100">
            <div class="col-lg-8 offset-lg-2 text-center text-white">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb justify-content-center bg-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-white-50">{{ __('messages.projects') }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit(app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en, 50) }}</li>
                    </ol>
                </nav>

                <!-- Project Title -->
                <h1 class="display-4 fw-bold mb-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                    {{ app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en }}
                </h1>
                
                <!-- Subtitle -->
                <p class="lead mb-4" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                    {{ Str::limit(app()->getLocale() == 'ar' ? $project->description_ar : $project->description_en, 150) }}
                </p>

                <!-- Key Info Bar -->
                <div class="row g-3 justify-content-center text-center mb-4">
                    <div class="col-auto">
                        <div class="d-flex align-items-center gap-2 px-3 py-2 bg-white bg-opacity-25 rounded">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zM2.5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5V3z"/>
                            </svg>
                            <span class="small">{{ app()->getLocale() == 'ar' ? $project->category->name_ar : $project->category->name_en }}</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center gap-2 px-3 py-2 bg-white bg-opacity-25 rounded">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            </svg>
                            <span class="small">{{ app()->getLocale() == 'ar' ? 'مدة التنفيذ:' : 'Duration:' }} {{ app()->getLocale() == 'ar' ? '18 شهر' : '18 months' }}</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center gap-2 px-3 py-2 bg-white bg-opacity-25 rounded">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                            <span class="small">{{ $project->location_country }} - {{ app()->getLocale() == 'ar' ? 'محافظة تعز' : 'Taiz Province' }}</span>
                        </div>
                    </div>
                    @if($project->is_urgent)
                    <div class="col-auto">
                        <span class="badge bg-danger py-2 px-3">
                            {{ app()->getLocale() == 'ar' ? 'عاجل' : 'URGENT' }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Left Column - Project Details -->
            <div class="col-lg-8">
                <!-- Progress Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="display-6 fw-bold text-success mb-1">{{ number_format($project->raised_amount) }}</div>
                                    <div class="small text-muted">{{ app()->getLocale() == 'ar' ? 'ريال' : 'SAR' }}</div>
                                    <div class="small text-muted mt-2">{{ app()->getLocale() == 'ar' ? 'من' : 'of' }} {{ number_format($project->target_amount) }} {{ app()->getLocale() == 'ar' ? 'ريال' : 'SAR' }}</div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">{{ __('messages.raised_amount') }}</span>
                                        <span class="fw-bold text-success">{{ number_format($project->progress_percentage, 0) }}% {{ app()->getLocale() == 'ar' ? 'مكتمل' : 'completed' }}</span>
                                    </div>
                                    <div class="progress" style="height: 15px;">
                                        <div
                                            class="progress-bar bg-success"
                                            role="progressbar"
                                            style="width: {{ $project->progress_percentage }}%"
                                            aria-valuenow="{{ $project->progress_percentage }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                        ></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between text-center">
                                    <div>
                                        <div class="fw-bold">{{ number_format($project->expected_beneficiaries_count) }}</div>
                                        <div class="small text-muted">{{ app()->getLocale() == 'ar' ? 'مستفيد' : 'beneficiaries' }}</div>
                                    </div>
                                    @if($project->days_left !== null && $project->days_left > 0)
                                    <div>
                                        <div class="fw-bold text-warning">{{ $project->days_left }}</div>
                                        <div class="small text-muted">{{ app()->getLocale() == 'ar' ? 'يوم متبقي' : 'days left' }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Details Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-4">{{ app()->getLocale() == 'ar' ? 'تفاصيل المشروع' : 'Project Details' }}</h2>
                        <p class="text-muted lh-lg" style="white-space: pre-line;">{{ app()->getLocale() == 'ar' ? $project->description_ar : $project->description_en }}</p>
                        
                        <!-- Key Info Grid -->
                        <div class="row g-4 mt-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="p-2 bg-primary bg-opacity-10 rounded">
                                        <svg width="20" height="20" fill="currentColor" class="bi bi-building text-primary" viewBox="0 0 16 16">
                                            <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ app()->getLocale() == 'ar' ? 'الجهة المنفذة' : 'Implementing Organization' }}</h6>
                                        <p class="mb-0 text-muted">{{ app()->getLocale() == 'ar' ? 'مؤسسة التعليم للجميع' : 'Education for All Foundation' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="p-2 bg-success bg-opacity-10 rounded">
                                        <svg width="20" height="20" fill="currentColor" class="bi bi-geo-alt text-success" viewBox="0 0 16 16">
                                            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ app()->getLocale() == 'ar' ? 'الموقع' : 'Location' }}</h6>
                                        <p class="mb-0 text-muted">{{ app()->getLocale() == 'ar' ? 'اليمن - محافظة تعز' : 'Yemen - Taiz Province' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="p-2 bg-warning bg-opacity-10 rounded">
                                        <svg width="20" height="20" fill="currentColor" class="bi bi-people text-warning" viewBox="0 0 16 16">
                                            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ app()->getLocale() == 'ar' ? 'عدد المستفيدين' : 'Number of Beneficiaries' }}</h6>
                                        <p class="mb-0 text-muted">{{ number_format($project->expected_beneficiaries_count) }} {{ app()->getLocale() == 'ar' ? 'شخص' : 'people' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="p-2 bg-info bg-opacity-10 rounded">
                                        <svg width="20" height="20" fill="currentColor" class="bi bi-clock text-info" viewBox="0 0 16 16">
                                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ app()->getLocale() == 'ar' ? 'مدة التنفيذ' : 'Implementation Duration' }}</h6>
                                        <p class="mb-0 text-muted">{{ app()->getLocale() == 'ar' ? '18 شهر' : '18 months' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expected Impact -->
                @if($project->expected_impact_ar || $project->expected_impact_en)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h3 class="h5 mb-3">{{ app()->getLocale() == 'ar' ? 'الأثر المتوقع' : 'Expected Impact' }}</h3>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">{{ app()->getLocale() == 'ar' ? $project->expected_impact_ar : $project->expected_impact_en }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Related Projects -->
                @if($relatedProjects->count() > 0)
                <div class="mt-5">
                    <h3 class="h5 mb-4">{{ app()->getLocale() == 'ar' ? 'مشاريع مشابهة' : 'Related Projects' }}</h3>
                    <div class="row g-3">
                        @foreach($relatedProjects as $relatedProject)
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm">
                                @if($relatedProject->projectImages && count($relatedProject->projectImages) > 0)
                                    <img
                                        src="{{ $relatedProject->projectImages->first()->getUrl() }}"
                                        class="card-img-top"
                                        alt="{{ app()->getLocale() == 'ar' ? $relatedProject->title_ar : $relatedProject->title_en }}"
                                    >
                                @else
                                    <img
                                        src="https://via.placeholder.com/300x150/006341/ffffff?text={{ urlencode(app()->getLocale() == 'ar' ? 'مشروع' : 'Project') }}"
                                        class="card-img-top"
                                        alt="{{ app()->getLocale() == 'ar' ? $relatedProject->title_ar : $relatedProject->title_en }}"
                                    >
                                @endif
                                <div class="card-body p-3">
                                    <h6 class="card-title">{{ Str::limit(app()->getLocale() == 'ar' ? $relatedProject->title_ar : $relatedProject->title_en, 50) }}</h6>
                                    <div class="progress mb-2" style="height: 6px;">
                                        <div class="progress-bar" style="width: {{ $relatedProject->progress_percentage }}%"></div>
                                    </div>
                                    <div class="small text-muted">{{ number_format($relatedProject->progress_percentage, 0) }}% {{ __('messages.raised_amount') }}</div>
                                    <a href="{{ route('projects.show', $relatedProject->slug) }}" class="btn btn-sm btn-outline-primary w-100 mt-2">
                                        {{ __('messages.learn_more') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Donation Form -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <!-- Donation Card -->
                    <div class="card shadow border-0 mb-4">
                        <div class="card-body p-4">
                            <h4 class="h5 mb-4 text-center">{{ app()->getLocale() == 'ar' ? 'اختر مبلغ التبرع' : 'Choose Donation Amount' }}</h4>

                            <form id="donationForm" method="POST" action="{{ route('donations.store') }}">
                                @csrf
                                <input type="hidden" name="project_id" value="{{ $project->id }}">

                                <!-- Quick Amount Buttons -->
                                <div class="row g-2 mb-4">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" onclick="selectAmount(100)">
                                            {{ app()->getLocale() == 'ar' ? '100 ريال' : '100 SAR' }}
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" onclick="selectAmount(500)">
                                            {{ app()->getLocale() == 'ar' ? '500 ريال' : '500 SAR' }}
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" onclick="selectAmount(1000)">
                                            {{ app()->getLocale() == 'ar' ? '1000 ريال' : '1000 SAR' }}
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" onclick="selectAmount(250)">
                                            {{ app()->getLocale() == 'ar' ? '250 ريال' : '250 SAR' }}
                                        </button>
                                    </div>
                                </div>

                                <!-- Custom Amount Input -->
                                <div class="mb-4">
                                    <div class="input-group">
                                        <input
                                            type="number"
                                            name="amount"
                                            id="custom-amount"
                                            class="form-control form-control-lg text-center"
                                            placeholder="{{ app()->getLocale() == 'ar' ? 'مبلغ مخصص' : 'Custom amount' }}"
                                            min="10"
                                            required
                                        >
                                        <span class="input-group-text">{{ app()->getLocale() == 'ar' ? 'ريال' : 'SAR' }}</span>
                                    </div>
                                    <small class="text-muted d-block text-center mt-2">{{ app()->getLocale() == 'ar' ? 'الحد الأدنى 10 ريال' : 'Minimum 10 SAR' }}</small>
                                </div>

                                <!-- Gift Donation -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="gift-donation-checkbox"
                                            name="is_gift"
                                            value="1"
                                            onchange="toggleGiftForm()"
                                        >
                                        <label class="form-check-label" for="gift-donation-checkbox">
                                            {{ app()->getLocale() == 'ar' ? 'تبرع كهدية 🎁' : 'Donate as a Gift 🎁' }}
                                        </label>
                                    </div>
                                </div>

                                <!-- Gift Form (Hidden by default) -->
                                <div id="gift-donation-form" class="mb-4" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('messages.gift_recipient_name') }}</label>
                                        <input type="text" name="gift_recipient_name" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'بريد المستلم الإلكتروني' : 'Recipient Email' }}</label>
                                        <input type="email" name="gift_recipient_email" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('messages.gift_message') }}</label>
                                        <textarea name="gift_message" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">{{ __('messages.select_payment_method') }}</label>
                                    <div class="d-grid gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method" id="mada" value="mada" checked>
                                            <label class="form-check-label" for="mada">
                                                {{ __('messages.mada') }}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method" id="visa" value="visa">
                                            <label class="form-check-label" for="visa">
                                                {{ __('messages.visa') }}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method" id="mastercard" value="mastercard">
                                            <label class="form-check-label" for="mastercard">
                                                {{ __('messages.mastercard') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Donate Button -->
                                <button type="submit" class="btn btn-success btn-lg w-100 mb-3">
                                    <svg width="20" height="20" fill="currentColor" class="bi bi-heart me-2" viewBox="0 0 16 16">
                                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                    </svg>
                                    {{ app()->getLocale() == 'ar' ? 'تبرع الآن' : 'Donate Now' }}
                                </button>

                                <div class="text-center">
                                    <small class="text-muted">
                                        <svg width="12" height="12" fill="currentColor" class="bi bi-shield-lock me-1" viewBox="0 0 16 16">
                                            <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                                            <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415z"/>
                                        </svg>
                                        {{ app()->getLocale() == 'ar' ? 'دفع آمن ومشفر' : 'Secure Payment' }}
                                    </small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Amount selection
window.selectAmount = function(amount) {
    const customInput = document.getElementById('custom-amount');
    const amountButtons = document.querySelectorAll('.amount-btn');

    amountButtons.forEach(btn => {
        btn.classList.remove('active');
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline-primary');
    });

    event.target.classList.add('active');
    event.target.classList.remove('btn-outline-primary');
    event.target.classList.add('btn-primary');

    customInput.value = amount;
};

// Gift form toggle
window.toggleGiftForm = function() {
    const giftForm = document.getElementById('gift-donation-form');
    const isGift = document.getElementById('gift-donation-checkbox').checked;

    if (isGift) {
        giftForm.style.display = 'block';
        // Make gift fields required
        giftForm.querySelectorAll('input, select, textarea').forEach(input => {
            if (input.name !== 'gift_message') {
                input.required = true;
            }
        });
    } else {
        giftForm.style.display = 'none';
        // Make gift fields optional
        giftForm.querySelectorAll('input, select, textarea').forEach(input => {
            input.required = false;
        });
    }
};
</script>
@endpush
