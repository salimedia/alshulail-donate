@extends('admin.layouts.app')

@section('title', __('messages.add_new_user'))

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-dark mb-1">{{ __('messages.add_new_user') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('messages.users') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('messages.add_new') }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-left mx-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                {{ __('messages.back_to_users') }}
            </a>
        </div>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" id="userCreateForm">
        @csrf
        <div class="row g-4">
            <!-- Left Column - User Information -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">
                            <svg width="20" height="20" fill="currentColor" class="bi bi-person-fill mx-2 text-primary" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                            {{ __('messages.basic_information') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name') }}" 
                                        placeholder="{{ __('messages.full_name') }}"
                                        required
                                    >
                                    <label for="name">{{ __('messages.full_name') }} <span class="text-danger">*</span></label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="email" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        id="email" 
                                        name="email" 
                                        value="{{ old('email') }}" 
                                        placeholder="{{ __('messages.email_address') }}"
                                        required
                                    >
                                    <label for="email">{{ __('messages.email_address') }} <span class="text-danger">*</span></label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        id="password" 
                                        name="password" 
                                        placeholder="{{ __('messages.password') }}"
                                        required
                                    >
                                    <label for="password">{{ __('messages.password') }} <span class="text-danger">*</span></label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="password" 
                                        class="form-control @error('password_confirmation') is-invalid @enderror" 
                                        id="password_confirmation" 
                                        name="password_confirmation" 
                                        placeholder="{{ __('messages.confirm_password') }}"
                                        required
                                    >
                                    <label for="password_confirmation">{{ __('messages.confirm_password') }} <span class="text-danger">*</span></label>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="tel" 
                                        class="form-control @error('phone') is-invalid @enderror" 
                                        id="phone" 
                                        name="phone" 
                                        value="{{ old('phone') }}" 
                                        placeholder="{{ __('messages.phone_number') }}"
                                    >
                                    <label for="phone">{{ __('messages.phone_number') }}</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="date" 
                                        class="form-control @error('date_of_birth') is-invalid @enderror" 
                                        id="date_of_birth" 
                                        name="date_of_birth" 
                                        value="{{ old('date_of_birth') }}" 
                                        placeholder="{{ __('messages.date_of_birth') }}"
                                    >
                                    <label for="date_of_birth">{{ __('messages.date_of_birth') }}</label>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">
                            <svg width="20" height="20" fill="currentColor" class="bi bi-geo-alt-fill mx-2 text-info" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                            </svg>
                            {{ __('messages.additional_information') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">{{ __('messages.select_gender') }}</option>
                                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>{{ __('messages.male') }}</option>
                                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>{{ __('messages.female') }}</option>
                                    </select>
                                    <label for="gender">{{ __('messages.gender') }}</label>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control @error('country') is-invalid @enderror" 
                                        id="country" 
                                        name="country" 
                                        value="{{ old('country') }}" 
                                        placeholder="{{ __('messages.country') }}"
                                    >
                                    <label for="country">{{ __('messages.country') }}</label>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control @error('city') is-invalid @enderror" 
                                        id="city" 
                                        name="city" 
                                        value="{{ old('city') }}" 
                                        placeholder="{{ __('messages.city') }}"
                                    >
                                    <label for="city">{{ __('messages.city') }}</label>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-select @error('preferred_language') is-invalid @enderror" id="preferred_language" name="preferred_language">
                                        <option value="">{{ __('messages.select_language') }}</option>
                                        <option value="en" {{ old('preferred_language') === 'en' ? 'selected' : '' }}>English</option>
                                        <option value="ar" {{ old('preferred_language') === 'ar' ? 'selected' : '' }}>العربية</option>
                                    </select>
                                    <label for="preferred_language">{{ __('messages.preferred_language') }}</label>
                                    @error('preferred_language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Avatar & Permissions -->
            <div class="col-lg-4">
                <!-- User Avatar -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">
                            <svg width="20" height="20" fill="currentColor" class="bi bi-image mx-2 text-success" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                            </svg>
                            {{ __('messages.user_avatar') }}
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div id="avatar-preview" class="avatar-preview mx-auto mb-3">
                                <svg width="80" height="80" fill="currentColor" class="bi bi-person-circle text-muted" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input 
                                type="file" 
                                class="form-control @error('avatar') is-invalid @enderror" 
                                id="avatar" 
                                name="avatar" 
                                accept="image/*"
                                onchange="previewAvatar(this)"
                            >
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">{{ __('messages.avatar_requirements') }}</small>
                    </div>
                </div>

                <!-- Roles & Permissions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">
                            <svg width="20" height="20" fill="currentColor" class="bi bi-shield-check mx-2 text-warning" viewBox="0 0 16 16">
                                <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                                <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L9.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            {{ __('messages.roles_permissions') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('messages.assign_roles') }} <span class="text-danger">*</span></label>
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <input 
                                        class="form-check-input @error('roles') is-invalid @enderror" 
                                        type="checkbox" 
                                        id="role_{{ $role->id }}" 
                                        name="roles[]" 
                                        value="{{ $role->name }}"
                                        {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        <span class="badge bg-{{ $role->name === 'admin' ? 'danger' : ($role->name === 'moderator' ? 'warning' : 'secondary') }} bg-opacity-10 text-{{ $role->name === 'admin' ? 'danger' : ($role->name === 'moderator' ? 'warning' : 'secondary') }} me-2">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                        {{ $role->description ?? ucfirst($role->name) }}
                                    </label>
                                </div>
                            @endforeach
                            @error('roles')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <small>
                                <svg width="14" height="14" fill="currentColor" class="bi bi-info-circle mx-1" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                {{ __('messages.roles_info') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">{{ __('messages.required_fields') }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                    {{ __('messages.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <svg width="16" height="16" fill="currentColor" class="bi bi-check-lg mx-2" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                    </svg>
                                    {{ __('messages.create_user') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Avatar preview functionality
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview" class="avatar-preview-img">`;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Form validation
document.getElementById('userCreateForm').addEventListener('submit', function(e) {
    const roles = document.querySelectorAll('input[name="roles[]"]:checked');
    
    if (roles.length === 0) {
        e.preventDefault();
        alert('{{ __('messages.please_select_at_least_one_role') }}');
        return false;
    }
    
    // Password confirmation validation
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('{{ __('messages.passwords_do_not_match') }}');
        return false;
    }
});

// Real-time password confirmation
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (password !== confirmPassword) {
        this.classList.add('is-invalid');
        this.nextElementSibling.textContent = '{{ __('messages.passwords_do_not_match') }}';
    } else {
        this.classList.remove('is-invalid');
    }
});
</script>
@endpush

@push('styles')
<style>
.avatar-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 3px dashed #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.avatar-preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.form-floating > label {
    opacity: 0.6;
}

.form-check {
    margin-bottom: 0.75rem;
}

.form-check-label {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.card {
    border-radius: 10px;
}

.btn {
    border-radius: 6px;
}

.alert-info {
    border-radius: 8px;
    border: 1px solid rgba(13, 110, 253, 0.2);
}
</style>
@endpush