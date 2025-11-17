@extends('layouts.app')

@section('title', (app()->getLocale() == 'ar' ? 'تم التبرع بنجاح' : 'Donation Successful') . ' - ' . config('app.name'))

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Success Icon -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success rounded-circle p-4 mb-3" style="width: 120px; height: 120px;">
                        <svg width="64" height="64" fill="white" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                        </svg>
                    </div>
                    <h1 class="h3 text-success mb-2">
                        {{ app()->getLocale() == 'ar' ? 'شكراً لتبرعك!' : 'Thank You for Your Donation!' }}
                    </h1>
                    <p class="text-muted">
                        {{ app()->getLocale() == 'ar' ? 'تم استلام تبرعك بنجاح' : 'Your donation has been received successfully' }}
                    </p>
                </div>

                @if($donation)
                <!-- Donation Details Card -->
                <div class="receipt-container mb-4">
                    <div class="receipt-header">
                        <h2 class="h5 mb-3">{{ __('messages.receipt') }}</h2>
                        @if($donation->receipt)
                        <p class="text-muted mb-0">{{ __('messages.receipt_number') }}: <strong>{{ $donation->receipt->receipt_number }}</strong></p>
                        @endif
                        <p class="text-muted small">{{ __('messages.donation_date') }}: {{ $donation->created_at->format('Y-m-d H:i') }}</p>
                    </div>

                    <div class="py-4">
                        <!-- Donation Number -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <strong>{{ app()->getLocale() == 'ar' ? 'رقم التبرع' : 'Donation Number' }}:</strong>
                            </div>
                            <div class="col-6 text-end">
                                {{ $donation->donation_number }}
                            </div>
                        </div>

                        <!-- Project -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <strong>{{ __('messages.projects') }}:</strong>
                            </div>
                            <div class="col-6 text-end">
                                {{ app()->getLocale() == 'ar' ? $donation->project->title_ar : $donation->project->title_en }}
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="row mb-3 py-3 border-top border-bottom">
                            <div class="col-6">
                                <strong class="h5">{{ __('messages.donation_amount') }}:</strong>
                            </div>
                            <div class="col-6 text-end">
                                <strong class="h5 text-primary">{{ number_format($donation->amount, 2) }} SAR</strong>
                            </div>
                        </div>

                        <!-- Gift Info -->
                        @if($donation->is_gift)
                        <div class="gift-form-section p-3 mb-3">
                            <h6 class="mb-2">🎁 {{ app()->getLocale() == 'ar' ? 'تبرع كهدية' : 'Gift Donation' }}</h6>
                            <p class="mb-1"><strong>{{ __('messages.gift_recipient_name') }}:</strong> {{ $donation->gift_recipient_name }}</p>
                            @if($donation->gift_occasion)
                            <p class="mb-1"><strong>{{ __('messages.gift_occasion') }}:</strong> {{ ucfirst($donation->gift_occasion) }}</p>
                            @endif
                            @if($donation->gift_message)
                            <p class="mb-0"><strong>{{ __('messages.gift_message') }}:</strong> {{ $donation->gift_message }}</p>
                            @endif
                        </div>
                        @endif

                        <!-- Status -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <strong>{{ app()->getLocale() == 'ar' ? 'الحالة' : 'Status' }}:</strong>
                            </div>
                            <div class="col-6 text-end">
                                <span class="badge bg-success">{{ app()->getLocale() == 'ar' ? 'مكتمل' : 'Completed' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-grid gap-2">
                        @if($donation->receipt)
                        <a href="#" class="btn btn-outline-primary">
                            {{ __('messages.download_receipt') }}
                        </a>
                        @endif
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            {{ app()->getLocale() == 'ar' ? 'العودة للرئيسية' : 'Back to Home' }}
                        </a>
                        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                            {{ app()->getLocale() == 'ar' ? 'تصفح مشاريع أخرى' : 'Browse More Projects' }}
                        </a>
                    </div>
                </div>

                <!-- Impact Message -->
                <div class="alert alert-success" role="alert">
                    <h6 class="alert-heading">{{ app()->getLocale() == 'ar' ? 'شكراً لدعمك!' : 'Thank You for Your Support!' }}</h6>
                    <p class="mb-0">
                        {{ app()->getLocale() == 'ar'
                            ? 'تبرعك سيساعد في إحداث فرق حقيقي في حياة المستفيدين. سيتم إرسال إيصال التبرع إلى بريدك الإلكتروني.'
                            : 'Your donation will make a real difference in the lives of beneficiaries. A donation receipt will be sent to your email.'
                        }}
                    </p>
                </div>

                <!-- Share -->
                <div class="text-center mt-4">
                    <p class="text-muted">{{ app()->getLocale() == 'ar' ? 'شارك الخير' : 'Share the Good' }}</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                            </svg>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-info">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                            </svg>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-success">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <p class="mb-0">{{ app()->getLocale() == 'ar' ? 'تفاصيل التبرع غير متاحة' : 'Donation details not available' }}</p>
                </div>
                <div class="d-grid">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        {{ app()->getLocale() == 'ar' ? 'العودة للرئيسية' : 'Back to Home' }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
