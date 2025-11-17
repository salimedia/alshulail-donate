@extends('layouts.app')

@section('title', (app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en) . ' - ' . config('app.name'))

@section('content')
<!-- Project Header -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">{{ __('messages.projects') }}</a></li>
                        <li class="breadcrumb-item active">{{ Str::limit(app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en, 50) }}</li>
                    </ol>
                </nav>

                <!-- Project Title -->
                <h1 class="h2 mb-3">{{ app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en }}</h1>

                <!-- Category & Location -->
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <span class="badge bg-primary py-2 px-3">
                        {{ app()->getLocale() == 'ar' ? $project->category->name_ar : $project->category->name_en }}
                    </span>
                    @if($project->is_urgent)
                    <span class="badge bg-danger py-2 px-3">
                        {{ app()->getLocale() == 'ar' ? 'عاجل' : 'URGENT' }}
                    </span>
                    @endif
                    <span class="badge bg-light text-dark py-2 px-3">
                        <svg width="14" height="14" fill="currentColor" class="bi bi-geo-alt me-1" viewBox="0 0 16 16">
                            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                        </svg>
                        {{ $project->location_country }}
                    </span>
                </div>

                <!-- Project Image -->
                <div class="mb-4">
                    <img
                        src="https://via.placeholder.com/800x400/006341/ffffff?text={{ urlencode(app()->getLocale() == 'ar' ? 'مشروع خيري' : 'Charity Project') }}"
                        alt="{{ app()->getLocale() == 'ar' ? $project->title_ar : $project->title_en }}"
                        class="img-fluid rounded shadow"
                    >
                </div>

                <!-- Progress Stats -->
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <div class="row g-3 text-center">
                        <div class="col-md-4">
                            <div class="stat-value">{{ number_format($project->raised_amount) }} SAR</div>
                            <div class="stat-label">{{ __('messages.raised_amount') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-value">{{ number_format($project->target_amount) }} SAR</div>
                            <div class="stat-label">{{ __('messages.target_amount') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-value">{{ number_format($project->donors_count) }}</div>
                            <div class="stat-label">{{ __('messages.donors_count') }}</div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">{{ __('messages.raised_amount') }}</span>
                            <span class="small fw-bold">{{ number_format($project->progress_percentage, 0) }}%</span>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div
                                class="progress-bar"
                                role="progressbar"
                                style="width: {{ $project->progress_percentage }}%"
                            ></div>
                        </div>
                    </div>

                    @if($project->days_left !== null && $project->days_left > 0)
                    <div class="text-center mt-3">
                        <span class="badge bg-warning text-dark py-2 px-3">
                            {{ $project->days_left }} {{ app()->getLocale() == 'ar' ? 'يوم متبقي' : 'days left' }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Project Description -->
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h3 class="h5 mb-3">{{ app()->getLocale() == 'ar' ? 'عن المشروع' : 'About This Project' }}</h3>
                    <p class="text-muted" style="white-space: pre-line;">{{ app()->getLocale() == 'ar' ? $project->description_ar : $project->description_en }}</p>
                </div>

                <!-- Expected Impact -->
                @if($project->expected_impact_ar || $project->expected_impact_en)
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h3 class="h5 mb-3">{{ app()->getLocale() == 'ar' ? 'الأثر المتوقع' : 'Expected Impact' }}</h3>
                    <div class="impact-badge p-3">
                        <p class="mb-0">{{ app()->getLocale() == 'ar' ? $project->expected_impact_ar : $project->expected_impact_en }}</p>
                    </div>
                    <div class="row g-3 mt-3">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="display-6 text-primary">{{ number_format($project->expected_beneficiaries_count) }}</div>
                                <div class="small text-muted">{{ __('messages.expected_impact') }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="display-6 text-success">{{ number_format($project->actual_beneficiaries_count) }}</div>
                                <div class="small text-muted">{{ app()->getLocale() == 'ar' ? 'الأثر الفعلي' : 'Actual Impact' }}</div>
                            </div>
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
                            <div class="card h-100">
                                <img
                                    src="https://via.placeholder.com/300x150/006341/ffffff?text={{ urlencode(app()->getLocale() == 'ar' ? 'مشروع' : 'Project') }}"
                                    class="card-img-top"
                                    alt="{{ app()->getLocale() == 'ar' ? $relatedProject->title_ar : $relatedProject->title_en }}"
                                >
                                <div class="card-body">
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

            <!-- Donation Form Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <div class="bg-white p-4 rounded shadow">
                        <h4 class="h5 mb-4">{{ __('messages.donate_now') }}</h4>

                        <form id="donationForm" method="POST" action="{{ route('donations.store') }}">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                            <!-- Donation Amount -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">{{ __('messages.donation_amount') }}</label>
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" onclick="selectAmount(100)">100 SAR</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" onclick="selectAmount(500)">500 SAR</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" onclick="selectAmount(1000)">1,000 SAR</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" onclick="selectAmount(5000)">5,000 SAR</button>
                                    </div>
                                </div>
                                <input
                                    type="number"
                                    name="amount"
                                    id="custom-amount"
                                    class="form-control"
                                    placeholder="{{ __('messages.custom_amount') }}"
                                    min="10"
                                    required
                                >
                                <small class="text-muted">{{ __('messages.minimum_amount', ['amount' => '10']) }}</small>
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
                            <div id="gift-donation-form" class="gift-form-section" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.gift_recipient_name') }}</label>
                                    <input type="text" name="gift_recipient_name" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ app()->getLocale() == 'ar' ? 'بريد المستلم الإلكتروني' : 'Recipient Email' }}</label>
                                    <input type="email" name="gift_recipient_email" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.gift_occasion') }}</label>
                                    <select name="gift_occasion" class="form-select">
                                        <option value="">{{ __('messages.select_occasion') }}</option>
                                        <option value="birthday">{{ __('messages.birthday') }}</option>
                                        <option value="wedding">{{ __('messages.wedding') }}</option>
                                        <option value="graduation">{{ __('messages.graduation') }}</option>
                                        <option value="ramadan">{{ __('messages.ramadan') }}</option>
                                        <option value="eid">{{ __('messages.eid') }}</option>
                                        <option value="other">{{ __('messages.other') }}</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.gift_message') }}</label>
                                    <textarea name="gift_message" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ __('messages.gift_delivery_date') }}</label>
                                    <input type="date" name="gift_delivery_date" class="form-control" min="{{ date('Y-m-d') }}">
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

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                {{ __('messages.proceed_to_payment') }}
                            </button>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <svg width="12" height="12" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                    </svg>
                                    {{ app()->getLocale() == 'ar' ? 'دفع آمن ومشفر' : 'Secure & Encrypted Payment' }}
                                </small>
                            </div>
                        </form>
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
            if (input.name !== 'gift_message' && input.name !== 'gift_delivery_date') {
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
