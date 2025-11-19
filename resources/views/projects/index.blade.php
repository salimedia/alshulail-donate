@extends('layouts.app')

@section('title', __('messages.projects') . ' - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<section class="bg-light py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3 mb-0">{{ __('messages.projects') }}</h1>
                <p class="text-muted mb-0">{{ __('messages.browse_projects') }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <span class="text-muted">{{ $projects->total() }} {{ __('messages.projects') }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Filters & Search -->
<section class="py-4 border-bottom">
    <div class="container">
        <form method="GET" action="{{ route('projects.index') }}" class="row g-3">
            <!-- Search -->
            <div class="col-lg-5">
                <div class="input-group">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="{{ __('messages.search') }}..."
                        value="{{ request('search') }}"
                    >
                    <button class="btn btn-primary" type="submit">
                        <svg width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="col-lg-4">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">{{ __('messages.filter') }} - {{ app()->getLocale() == 'ar' ? 'جميع الفئات' : 'All Categories' }}</option>
                    @foreach($categories as $category)
                        <option
                            value="{{ $category->slug }}"
                            {{ request('category') == $category->slug ? 'selected' : '' }}
                        >
                            {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Clear Filters -->
            @if(request('search') || request('category'))
            <div class="col-lg-3">
                <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary w-100">
                    {{ app()->getLocale() == 'ar' ? 'مسح الفلاتر' : 'Clear Filters' }}
                </a>
            </div>
            @endif
        </form>

        <!-- Category Pills -->
        <div class="d-flex flex-wrap gap-2 mt-3">
            @foreach($categories->take(6) as $category)
            <a
                href="{{ route('projects.index', ['category' => $category->slug]) }}"
                class="badge {{ request('category') == $category->slug ? 'bg-primary' : 'bg-light text-dark' }} py-2 px-3 text-decoration-none"
                style="font-size: 0.875rem;"
            >
                {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-5">
    <div class="container">
        @if($projects->count() > 0)
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
                            {{ app()->getLocale() == 'ar' ? 'عاجل' : 'URGENT' }}
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
                                    {{ number_format($project->progress_percentage, 0) }}%
                                </span>
                            </div>
                            <div class="progress">
                                <div
                                    class="progress-bar"
                                    role="progressbar"
                                    style="width: {{ $project->progress_percentage }}%"
                                    aria-valuenow="{{ $project->progress_percentage }}"
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

                        @if($project->days_left !== null && $project->days_left > 0)
                        <div class="text-center mb-3">
                            <small class="text-muted">
                                {{ $project->days_left }} {{ app()->getLocale() == 'ar' ? 'يوم متبقي' : 'days left' }}
                            </small>
                        </div>
                        @endif

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

        <!-- Pagination -->
        <div class="mt-5">
            {{ $projects->links() }}
        </div>

        @else
        <div class="text-center py-5">
            <svg width="64" height="64" fill="currentColor" class="bi bi-inbox text-muted mb-3" viewBox="0 0 16 16">
                <path d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438L14.933 9zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374l3.7-4.625z"/>
            </svg>
            <h4 class="text-muted">{{ app()->getLocale() == 'ar' ? 'لا توجد مشاريع' : 'No Projects Found' }}</h4>
            <p class="text-muted">{{ app()->getLocale() == 'ar' ? 'جرب تغيير الفلاتر أو البحث' : 'Try adjusting your filters or search' }}</p>
            <a href="{{ route('projects.index') }}" class="btn btn-primary">
                {{ app()->getLocale() == 'ar' ? 'عرض جميع المشاريع' : 'View All Projects' }}
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
