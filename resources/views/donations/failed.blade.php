@extends('layouts.app')

@section('title', (app()->getLocale() == 'ar' ? 'فشلت عملية التبرع' : 'Donation Failed') . ' - ' . config('app.name'))

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Error Icon -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger rounded-circle p-4 mb-3" style="width: 120px; height: 120px;">
                        <svg width="64" height="64" fill="white" class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </div>
                    <h1 class="h3 text-danger mb-2">
                        {{ app()->getLocale() == 'ar' ? 'فشلت عملية الدفع' : 'Payment Failed' }}
                    </h1>
                    <p class="text-muted">
                        {{ app()->getLocale() == 'ar' ? 'عذراً، لم نتمكن من إتمام عملية التبرع' : 'Sorry, we could not complete your donation' }}
                    </p>
                </div>

                <!-- Error Details -->
                <div class="alert alert-danger" role="alert">
                    <h6 class="alert-heading">{{ app()->getLocale() == 'ar' ? 'ماذا حدث؟' : 'What happened?' }}</h6>
                    <p class="mb-0">
                        {{ app()->getLocale() == 'ar'
                            ? 'حدث خطأ أثناء معالجة الدفع. قد يكون السبب أحد الآتي:'
                            : 'An error occurred while processing the payment. This could be due to:'
                        }}
                    </p>
                    <ul class="mb-0 mt-2">
                        <li>{{ app()->getLocale() == 'ar' ? 'رصيد غير كافٍ' : 'Insufficient funds' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'معلومات بطاقة غير صحيحة' : 'Incorrect card information' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'مشكلة في الاتصال' : 'Connection issue' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'رفض البنك للعملية' : 'Bank declined the transaction' }}</li>
                    </ul>
                </div>

                @if($donation)
                <!-- Donation Attempt Details -->
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="h6 mb-3">{{ app()->getLocale() == 'ar' ? 'تفاصيل المحاولة' : 'Attempt Details' }}</h5>

                    <div class="row mb-2">
                        <div class="col-6">
                            <strong>{{ app()->getLocale() == 'ar' ? 'رقم المحاولة' : 'Attempt Number' }}:</strong>
                        </div>
                        <div class="col-6 text-end">
                            {{ $donation->donation_number }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <strong>{{ __('messages.projects') }}:</strong>
                        </div>
                        <div class="col-6 text-end">
                            {{ Str::limit(app()->getLocale() == 'ar' ? $donation->project->title_ar : $donation->project->title_en, 30) }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <strong>{{ __('messages.donation_amount') }}:</strong>
                        </div>
                        <div class="col-6 text-end">
                            {{ number_format($donation->amount, 2) }} SAR
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <strong>{{ app()->getLocale() == 'ar' ? 'الوقت' : 'Time' }}:</strong>
                        </div>
                        <div class="col-6 text-end">
                            {{ $donation->created_at->format('Y-m-d H:i') }}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="d-grid gap-2 mb-4">
                    @if($donation)
                    <a href="{{ route('projects.show', $donation->project->slug) }}" class="btn btn-primary">
                        {{ app()->getLocale() == 'ar' ? 'إعادة المحاولة' : 'Try Again' }}
                    </a>
                    @endif
                    <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                        {{ app()->getLocale() == 'ar' ? 'تصفح المشاريع' : 'Browse Projects' }}
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        {{ app()->getLocale() == 'ar' ? 'العودة للرئيسية' : 'Back to Home' }}
                    </a>
                </div>

                <!-- Help Section -->
                <div class="bg-light p-4 rounded">
                    <h6 class="mb-3">{{ app()->getLocale() == 'ar' ? 'تحتاج مساعدة؟' : 'Need Help?' }}</h6>
                    <p class="text-muted small">
                        {{ app()->getLocale() == 'ar'
                            ? 'إذا استمرت المشكلة، يرجى التواصل مع فريق الدعم لدينا'
                            : 'If the problem persists, please contact our support team'
                        }}
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-envelope me-1" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'راسلنا' : 'Email Us' }}
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-success">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-whatsapp me-1" viewBox="0 0 16 16">
                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'واتساب' : 'WhatsApp' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
