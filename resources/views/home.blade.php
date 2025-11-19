@extends('layouts.app')

@section('title', __('messages.hero_title') . ' - ' . __('messages.site_name_' . app()->getLocale()))

@section('content')
<!-- Hero Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold text-primary mb-3 fade-in-up">
                    {{ __('messages.hero_title') }}
                </h1>
                <p class="lead text-muted mb-4 fade-in-up" style="animation-delay: 0.2s">
                    {{ __('messages.hero_subtitle') }}
                </p>
                <div class="d-flex gap-3 fade-in-up" style="animation-delay: 0.4s">
                    <a href="{{ route('projects.index') }}" class="btn btn-primary btn-lg">
                        {{ __('messages.browse_projects') }}
                    </a>
                    <a href="#how-it-works" class="btn btn-outline-secondary btn-lg">
                        {{ __('messages.how_it_works') }}
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="donation-stats bg-white p-4 rounded shadow-sm">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format(1850) }}</div>
                                <div class="stat-label">{{ __('messages.total_donations') }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format(25000) }}+</div>
                                <div class="stat-label">{{ __('messages.total_beneficiaries') }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format(2450000) }} SAR</div>
                                <div class="stat-label">{{ __('messages.raised_amount') }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format(12) }}</div>
                                <div class="stat-label">{{ __('messages.countries_served') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0">{{ __('messages.projects') }}</h2>
            <a href="{{ route('projects.index') }}" class="btn btn-outline-primary">
                {{ __('messages.browse_projects') }}
            </a>
        </div>

        <div class="row g-4">
            @foreach($projects as $project)
            <div class="col-lg-4 col-md-6">
                <div class="project-card">
                    <!-- Project Image -->
                    <div class="position-relative">
                        @if(count($project->projectImages) > 0)
                            <img
                                src="{{ $project->projectImages->first()->getUrl() }}"
                                alt="{{ app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en }}"
                                class="project-card-image"
                            >
                        @else
                            <img
                                src="https://via.placeholder.com/400x200/006341/ffffff?text={{ urlencode(app()->getLocale() == 'ar' ? 'مشروع خيري' : 'Charity Project') }}"
                                alt="{{ app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en }}"
                                class="project-card-image"
                            >
                        @endif
                        <div class="project-card-badge">
                            {{ app()->getLocale() == 'ar' ? $project->category->name_ar : $project->category->name_en }}
                        </div>
                        @if($project->is_urgent)
                        <span class="badge bg-danger position-absolute top-0 {{ app()->getLocale() == 'ar' ? 'start-0 ms-3' : 'end-0 me-3' }} mt-3">
                            عاجل
                        </span>
                        @endif
                    </div>

                    <!-- Project Content -->
                    <div class="card-body p-4">
                        <h5 class="card-title mb-2">
                            {{ app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en }}
                        </h5>
                        <p class="card-text text-muted small mb-3">
                            {{ Str::limit(app()->getLocale() == 'ar' ? $project->description_ar : $project->description_en, 100) }}
                        </p>

                        <!-- Location -->
                        <div class="d-flex align-items-center gap-2 mb-3 text-muted small">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                            <span>{{ $project->location_country }}</span>
                        </div>

                        <!-- Progress -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted">{{ __('messages.raised_amount') }}</span>
                                <span class="small fw-bold">
                                    {{ number_format(($project->raised_amount / $project->target_amount) * 100, 0) }}%
                                </span>
                            </div>
                            <div class="progress">
                                <div
                                    class="progress-bar"
                                    role="progressbar"
                                    style="width: {{ ($project->raised_amount / $project->target_amount) * 100 }}%"
                                    aria-valuenow="{{ ($project->raised_amount / $project->target_amount) * 100 }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                ></div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="fw-bold text-primary">{{ number_format($project->raised_amount) }} SAR</div>
                                <div class="small text-muted">{{ __('messages.raised_amount') }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ number_format($project->donors_count) }}</div>
                                <div class="small text-muted">{{ __('messages.donors_count') }}</div>
                            </div>
                        </div>

                        <!-- Beneficiaries -->
                        <div class="impact-badge mb-3">
                            <small class="d-block text-center">
                                {{ __('messages.beneficiaries') }}: {{ number_format($project->expected_beneficiaries_count) }}
                            </small>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-primary">
                                {{ __('messages.donate_now') }}
                            </a>
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-outline-secondary btn-sm">
                                {{ __('messages.learn_more') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- How It Works -->
<section id="how-it-works" class="py-5 bg-light">
    <div class="container">
        <h2 class="h3 text-center mb-5">{{ __('messages.how_it_works') }}</h2>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded shadow-sm h-100">
                    <div class="display-4 text-primary mb-3">1</div>
                    <h5>{{ app()->getLocale() == 'ar' ? 'اختر المشروع' : 'Choose Project' }}</h5>
                    <p class="text-muted small">
                        {{ app()->getLocale() == 'ar' ? 'تصفح المشاريع واختر ما يناسبك' : 'Browse projects and choose what suits you' }}
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded shadow-sm h-100">
                    <div class="display-4 text-primary mb-3">2</div>
                    <h5>{{ app()->getLocale() == 'ar' ? 'حدد المبلغ' : 'Set Amount' }}</h5>
                    <p class="text-muted small">
                        {{ app()->getLocale() == 'ar' ? 'اختر مبلغ التبرع المناسب لك' : 'Choose your donation amount' }}
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded shadow-sm h-100">
                    <div class="display-4 text-primary mb-3">3</div>
                    <h5>{{ app()->getLocale() == 'ar' ? 'ادفع بأمان' : 'Pay Securely' }}</h5>
                    <p class="text-muted small">
                        {{ app()->getLocale() == 'ar' ? 'ادفع بأمان عبر بوابات الدفع المعتمدة' : 'Pay securely through certified gateways' }}
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded shadow-sm h-100">
                    <div class="display-4 text-primary mb-3">4</div>
                    <h5>{{ app()->getLocale() == 'ar' ? 'احصل على الإيصال' : 'Get Receipt' }}</h5>
                    <p class="text-muted small">
                        {{ app()->getLocale() == 'ar' ? 'احصل على إيصال فوري بالبريد الإلكتروني' : 'Receive instant receipt by email' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
