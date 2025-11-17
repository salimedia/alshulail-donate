<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('messages.site_name_' . app()->getLocale()))</title>
    <meta name="description" content="@yield('description', __('messages.hero_subtitle'))">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <strong>{{ app()->getLocale() == 'ar' ? 'منصة الشلايل للتبرعات' : 'Al-Shulail Donate' }}</strong>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav {{ app()->getLocale() == 'ar' ? 'me-auto' : 'ms-auto' }}">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ __('messages.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projects.index') }}">{{ __('messages.projects') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('messages.about') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('messages.contact') }}</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3 {{ app()->getLocale() == 'ar' ? 'me-3' : 'ms-3' }}">
                    <!-- Language Switcher -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#" onclick="switchLanguage('ar'); return false;">
                                    العربية
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="switchLanguage('en'); return false;">
                                    English
                                </a>
                            </li>
                        </ul>
                    </div>

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">{{ __('messages.my_account') }}</a></li>
                                <li><a class="dropdown-item" href="#">{{ __('messages.my_donations') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="#">
                                        @csrf
                                        <button type="submit" class="dropdown-item">{{ __('messages.logout') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="#" class="btn btn-sm btn-outline-primary">{{ __('messages.login') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-white mb-3">
                        {{ app()->getLocale() == 'ar' ? 'منصة الشلايل للتبرعات' : 'Al-Shulail Donate' }}
                    </h5>
                    <p class="text-white-50">
                        {{ __('messages.hero_subtitle') }}
                    </p>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">{{ __('messages.projects') }}</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">{{ __('messages.education') }}</a></li>
                        <li><a href="#">{{ __('messages.health') }}</a></li>
                        <li><a href="#">{{ __('messages.relief') }}</a></li>
                        <li><a href="#">{{ __('messages.development') }}</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">{{ __('messages.about') }}</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">{{ __('messages.about') }}</a></li>
                        <li><a href="#">{{ __('messages.transparency') }}</a></li>
                        <li><a href="#">{{ __('messages.certifications') }}</a></li>
                        <li><a href="#">{{ __('messages.reports') }}</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">{{ __('messages.support') }}</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">{{ __('messages.contact') }}</a></li>
                        <li><a href="#">{{ __('messages.faq') }}</a></li>
                        <li><a href="#">{{ __('messages.terms_of_service') }}</a></li>
                        <li><a href="#">{{ __('messages.privacy_policy') }}</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">{{ __('messages.contact') }}</h6>
                    <ul class="list-unstyled text-white-50">
                        <li>info@alshulail-donate.org</li>
                        <li>+966 11 234 5678</li>
                    </ul>
                </div>
            </div>

            <hr class="bg-white">

            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-white-50 mb-0">
                        &copy; {{ date('Y') }} Al-Shulail Donate. {{ __('messages.all_rights_reserved') }}
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="text-white-50 mb-0">
                        License #123456 | Tax #123456789
                    </p>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
