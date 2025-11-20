@extends('admin.layouts.app')

@section('title', __('messages.change_password'))

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-dark mb-1">{{ __('messages.change_password') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('messages.users') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></li>
                    <li class="breadcrumb-item active">{{ __('messages.change_password') }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-info">
                <svg width="16" height="16" fill="currentColor" class="bi bi-eye mx-2" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                </svg>
                {{ __('messages.view_user') }}
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary">
                <svg width="16" height="16" fill="currentColor" class="bi bi-pencil mx-2" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708L10.5 8.207l-3-3L12.146.146zM11.207 9l-3-3L2.5 11.707V13.5h1.793L11.207 9z"/>
                </svg>
                {{ __('messages.edit_user') }}
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <!-- User Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <!-- Avatar -->
                    <div class="mb-3">
                        @if($user->getFirstMediaUrl('avatars'))
                            <img src="{{ $user->getFirstMediaUrl('avatars') }}" alt="{{ $user->name }}" class="avatar-lg rounded-circle">
                        @else
                            <div class="avatar-lg bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                                <span class="h3 mb-0">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                        @endif
                    </div>
                    <h4 class="text-dark mb-2">{{ $user->name }}</h4>
                    <p class="text-muted mb-1">{{ $user->email }}</p>
                    <div>
                        @foreach($user->roles as $role)
                            <span class="badge bg-{{ $role->name === 'admin' ? 'danger' : ($role->name === 'moderator' ? 'warning' : 'secondary') }} me-1">
                                {{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <svg width="24" height="24" fill="currentColor" class="bi bi-key-fill mx-2 text-warning" viewBox="0 0 16 16">
                            <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                        </svg>
                        {{ __('messages.change_password') }}
                    </h5>
                    <small class="text-muted">{{ __('messages.change_password_description') }}</small>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.update-password', $user) }}" method="POST" id="changePasswordForm">
                        @csrf
                        
                        <!-- Security Notice -->
                        <div class="alert alert-warning" role="alert">
                            <div class="d-flex align-items-start">
                                <svg width="20" height="20" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2 mt-1" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                                <div>
                                    <strong>{{ __('messages.security_notice') }}</strong>
                                    <p class="mb-0 small">{{ __('messages.password_change_security_notice') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="mb-4">
                            <div class="form-floating">
                                <input 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    placeholder="{{ __('messages.new_password') }}"
                                    required
                                    minlength="8"
                                >
                                <label for="password">
                                    {{ __('messages.new_password') }} <span class="text-danger">*</span>
                                </label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">{{ __('messages.password_requirements') }}</small>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <div class="form-floating">
                                <input 
                                    type="password" 
                                    class="form-control @error('password_confirmation') is-invalid @enderror" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    placeholder="{{ __('messages.confirm_new_password') }}"
                                    required
                                >
                                <label for="password_confirmation">
                                    {{ __('messages.confirm_new_password') }} <span class="text-danger">*</span>
                                </label>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback" id="password-match-error" style="display: none;">
                                    {{ __('messages.passwords_do_not_match') }}
                                </div>
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="mb-4">
                            <label class="form-label small text-muted">{{ __('messages.password_strength') }}</label>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" id="password-strength-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted" id="password-strength-text">{{ __('messages.password_strength_weak') }}</small>
                        </div>

                        <!-- Show Password Toggle -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="showPassword" onchange="togglePasswordVisibility()">
                                <label class="form-check-label" for="showPassword">
                                    {{ __('messages.show_passwords') }}
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn" disabled>
                                <svg width="18" height="18" fill="currentColor" class="bi bi-shield-check mx-2" viewBox="0 0 16 16">
                                    <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                                    <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L9.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                </svg>
                                {{ __('messages.update_password') }}
                            </button>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary">
                                {{ __('messages.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Security Tips -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0">
                        <svg width="18" height="18" fill="currentColor" class="bi bi-lightbulb mx-2 text-info" viewBox="0 0 16 16">
                            <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13a.5.5 0 0 1 0 1 .5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1-.46-.302l-.761-1.77a1.964 1.964 0 0 0-.453-.618A5.984 5.984 0 0 1 2 6zm6-5a5 5 0 0 0-3.479 8.592c.263.254.514.564.676.941L5.83 12h4.342l.632-1.467c.162-.377.413-.687.676-.941A5 5 0 0 0 8 1z"/>
                        </svg>
                        {{ __('messages.security_tips') }}
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <svg width="14" height="14" fill="currentColor" class="bi bi-check-circle text-success me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                            {{ __('messages.password_tip_1') }}
                        </li>
                        <li class="mb-2">
                            <svg width="14" height="14" fill="currentColor" class="bi bi-check-circle text-success me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                            {{ __('messages.password_tip_2') }}
                        </li>
                        <li class="mb-2">
                            <svg width="14" height="14" fill="currentColor" class="bi bi-check-circle text-success me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                            {{ __('messages.password_tip_3') }}
                        </li>
                        <li>
                            <svg width="14" height="14" fill="currentColor" class="bi bi-check-circle text-success me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                            {{ __('messages.password_tip_4') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Password strength checker
function checkPasswordStrength(password) {
    let strength = 0;
    let feedback = [];

    // Length check
    if (password.length >= 8) strength += 1;
    else feedback.push('{{ __('messages.password_length_requirement') }}');

    // Lowercase check
    if (/[a-z]/.test(password)) strength += 1;
    else feedback.push('{{ __('messages.password_lowercase_requirement') }}');

    // Uppercase check
    if (/[A-Z]/.test(password)) strength += 1;
    else feedback.push('{{ __('messages.password_uppercase_requirement') }}');

    // Number check
    if (/[0-9]/.test(password)) strength += 1;
    else feedback.push('{{ __('messages.password_number_requirement') }}');

    // Special character check
    if (/[^A-Za-z0-9]/.test(password)) strength += 1;
    else feedback.push('{{ __('messages.password_special_requirement') }}');

    return { strength, feedback };
}

// Update password strength indicator
function updatePasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthBar = document.getElementById('password-strength-bar');
    const strengthText = document.getElementById('password-strength-text');
    const submitBtn = document.getElementById('submitBtn');
    
    const { strength } = checkPasswordStrength(password);
    const percentage = (strength / 5) * 100;
    
    strengthBar.style.width = percentage + '%';
    
    if (strength <= 2) {
        strengthBar.className = 'progress-bar bg-danger';
        strengthText.textContent = '{{ __('messages.password_strength_weak') }}';
        strengthText.className = 'text-danger small';
    } else if (strength <= 3) {
        strengthBar.className = 'progress-bar bg-warning';
        strengthText.textContent = '{{ __('messages.password_strength_medium') }}';
        strengthText.className = 'text-warning small';
    } else if (strength <= 4) {
        strengthBar.className = 'progress-bar bg-info';
        strengthText.textContent = '{{ __('messages.password_strength_good') }}';
        strengthText.className = 'text-info small';
    } else {
        strengthBar.className = 'progress-bar bg-success';
        strengthText.textContent = '{{ __('messages.password_strength_strong') }}';
        strengthText.className = 'text-success small';
    }
    
    // Enable submit button only if password is strong enough and passwords match
    const confirmPassword = document.getElementById('password_confirmation').value;
    const isValid = strength >= 3 && password === confirmPassword && password.length >= 8;
    submitBtn.disabled = !isValid;
}

// Password confirmation checker
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const errorDiv = document.getElementById('password-match-error');
    const confirmField = document.getElementById('password_confirmation');
    
    if (confirmPassword && password !== confirmPassword) {
        confirmField.classList.add('is-invalid');
        errorDiv.style.display = 'block';
    } else {
        confirmField.classList.remove('is-invalid');
        errorDiv.style.display = 'none';
    }
    
    updatePasswordStrength();
}

// Toggle password visibility
function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('password_confirmation');
    const checkbox = document.getElementById('showPassword');
    
    const type = checkbox.checked ? 'text' : 'password';
    passwordField.type = type;
    confirmField.type = type;
}

// Event listeners
document.getElementById('password').addEventListener('input', updatePasswordStrength);
document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);

// Form submission
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const { strength } = checkPasswordStrength(password);
    
    if (strength < 3) {
        e.preventDefault();
        alert('{{ __('messages.password_strength_insufficient') }}');
        return false;
    }
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('{{ __('messages.passwords_do_not_match') }}');
        return false;
    }
    
    if (!confirm('{{ __('messages.confirm_password_change') }}')) {
        e.preventDefault();
        return false;
    }
});
</script>
@endpush

@push('styles')
<style>
.avatar-lg {
    width: 80px;
    height: 80px;
    object-fit: cover;
}

.form-floating > label {
    opacity: 0.6;
}

.progress {
    border-radius: 10px;
    overflow: hidden;
}

.card {
    border-radius: 12px;
}

.btn {
    border-radius: 8px;
}

.alert {
    border-radius: 8px;
    border: none;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.list-unstyled li {
    padding: 0.25rem 0;
}
</style>
@endpush