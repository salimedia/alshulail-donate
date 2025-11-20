@extends('admin.layouts.app')

@section('title', __('edit_user'))

@section('content')
<div class="min-h-screen bg-gray-50 px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Page Title & Breadcrumb -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <nav class="flex mb-2" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700 inline-flex items-center">
                                    <i class="fas fa-home mr-4"></i>
                                    {{ __('dashboard') }}
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                    <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700">
                                        {{ __('users_management') }}
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                    <span class="text-gray-800 font-medium">{{ __('edit_user') }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('edit_user') }}: {{ $user->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ __('update_user_information_and_permissions') ?? 'Update user information and permissions' }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.show', $user) }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-eye mr-4"></i>
                        {{ __('view_user') }}
                    </a>
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-arrow-left mr-4"></i>
                        {{ __('back_to_users') }}
                    </a>
                </div>
            </div>

            <!-- User Edit Form -->
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" id="userEditForm">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Main Information -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Basic Information -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">{{ __('basic_information') }}</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Full Name -->
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('full_name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}"
                                           placeholder="{{ __('full_name_placeholder') }}"
                                           class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('name') border-red-300 @enderror"
                                           required>
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('email_address') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}"
                                           placeholder="{{ __('email_placeholder') }}"
                                           class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('email') border-red-300 @enderror"
                                           required>
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('phone_number') }}</label>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', $user->phone) }}"
                                           placeholder="{{ __('phone_placeholder') }}"
                                           class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('phone') border-red-300 @enderror">
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('date_of_birth') }}</label>
                                    <input type="date" 
                                           id="date_of_birth" 
                                           name="date_of_birth" 
                                           value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                                           class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('date_of_birth') border-red-300 @enderror">
                                    @error('date_of_birth')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">{{ __('additional_information') }}</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Gender -->
                                <div>
                                    <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('gender') }}</label>
                                    <select id="gender" 
                                            name="gender" 
                                            class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('gender') border-red-300 @enderror">
                                        <option value="">{{ __('select_gender') }}</option>
                                        <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>{{ __('male') }}</option>
                                        <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>{{ __('female') }}</option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Country -->
                                <div>
                                    <label for="country" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('country') }}</label>
                                    <input type="text" 
                                           id="country" 
                                           name="country" 
                                           value="{{ old('country', $user->country) }}"
                                           placeholder="{{ __('country_placeholder') }}"
                                           class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('country') border-red-300 @enderror">
                                    @error('country')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- City -->
                                <div>
                                    <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('city') }}</label>
                                    <input type="text" 
                                           id="city" 
                                           name="city" 
                                           value="{{ old('city', $user->city) }}"
                                           placeholder="{{ __('city_placeholder') }}"
                                           class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('city') border-red-300 @enderror">
                                    @error('city')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Preferred Language -->
                                <div class="md:col-span-3">
                                    <label for="preferred_language" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('preferred_language') }}</label>
                                    <select id="preferred_language" 
                                            name="preferred_language" 
                                            class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('preferred_language') border-red-300 @enderror">
                                        <option value="">{{ __('select_language') }}</option>
                                        <option value="en" {{ old('preferred_language', $user->preferred_language) === 'en' ? 'selected' : '' }}>{{ __('english') }}</option>
                                        <option value="ar" {{ old('preferred_language', $user->preferred_language) === 'ar' ? 'selected' : '' }}>{{ __('arabic') }}</option>
                                    </select>
                                    @error('preferred_language')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Password Change Notice -->
                        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                                <div>
                                    <h4 class="text-blue-900 font-semibold mb-2">{{ __('password_notice') ?? 'Password Change' }}</h4>
                                    <p class="text-blue-700 text-sm mb-4">{{ __('password_change_notice') ?? 'To update the user\'s password, please use the dedicated password change form.' }}</p>
                                    <a href="{{ route('admin.users.change-password', $user) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                        <i class="fas fa-key mr-2"></i>
                                        {{ __('change_password') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Avatar & Roles -->
                    <div class="lg:col-span-1 space-y-8">
                        <!-- User Avatar -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-camera text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">{{ __('user_avatar') }}</h3>
                            </div>
                            
                            <div class="text-center">
                                <div id="avatar-preview" class="w-32 h-32 mx-auto mb-6 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center border-4 border-white shadow-lg overflow-hidden">
                                    @if($user->getFirstMediaUrl('avatars'))
                                        <img src="{{ $user->getFirstMediaUrl('avatars') }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-full">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="relative">
                                    <input type="file" 
                                           id="avatar" 
                                           name="avatar" 
                                           accept="image/*"
                                           onchange="previewAvatar(this)"
                                           class="hidden">
                                    <label for="avatar" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 cursor-pointer">
                                        <i class="fas fa-upload mr-2"></i>
                                        {{ __('change_avatar') ?? 'Change Avatar' }}
                                    </label>
                                    @error('avatar')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <p class="mt-4 text-sm text-gray-500">{{ __('avatar_requirements') }}</p>
                            </div>
                        </div>

                        <!-- Roles & Permissions -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-shield-alt text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">{{ __('roles_permissions') }}</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-4">
                                    {{ __('assign_roles') }} <span class="text-red-500">*</span>
                                </label>
                                
                                <div class="space-y-3">
                                    @foreach($roles as $role)
                                        <label class="flex items-center p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-all duration-200 cursor-pointer">
                                            <input type="checkbox" 
                                                   id="role_{{ $role->id }}" 
                                                   name="roles[]" 
                                                   value="{{ $role->name }}"
                                                   {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                                            <div class="flex items-center">
                                                <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full mr-3 {{ $role->name === 'admin' ? 'bg-red-100 text-red-800' : ($role->name === 'moderator' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ ucfirst($role->name) }}
                                                </span>
                                                <span class="text-sm text-gray-700">{{ $role->description ?? ucfirst($role->name) }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                
                                @error('roles')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                                    <div class="flex items-start">
                                        <i class="fas fa-info-circle text-blue-500 mr-3 mt-0.5"></i>
                                        <p class="text-sm text-blue-700">{{ __('roles_update_info') ?? 'Updating roles will immediately change the user\'s permissions and access levels.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Status -->
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-gradient-to-r from-gray-500 to-gray-700 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-cog text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">{{ __('account_status') }}</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ __('account_status') }}</p>
                                        <p class="text-sm text-gray-500">{{ __('current_status') ?? 'Current account status' }}</p>
                                    </div>
                                    <div>
                                        @if($user->trashed())
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">
                                                {{ __('inactive') }}
                                            </span>
                                        @else
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                                {{ __('active') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex justify-between items-center py-2">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ __('email_verification') }}</p>
                                        <p class="text-sm text-gray-500">{{ __('email_verification_status') ?? 'Email verification status' }}</p>
                                    </div>
                                    <div>
                                        @if($user->email_verified_at)
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                                {{ __('verified') }}
                                            </span>
                                        @else
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold bg-orange-100 text-orange-800 rounded-full">
                                                {{ __('unverified') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex justify-between items-center py-2">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ __('member_since') }}</p>
                                        <p class="text-sm text-gray-500">{{ __('account_created_date') ?? 'Account creation date' }}</p>
                                    </div>
                                    <div>
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                            {{ $user->created_at->format('M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="mt-8 bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-orange-500 mr-2"></i>
                            <span class="text-sm text-gray-600">{{ __('required_fields') ?? 'Fields marked with * are required' }}</span>
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                <i class="fas fa-times mr-4"></i>
                                {{ __('cancel') }}
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-save mr-4"></i>
                                {{ __('update_user') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('userEditForm');
    
    form.addEventListener('submit', function(e) {
        const roles = document.querySelectorAll('input[name="roles[]"]:checked');
        
        if (roles.length === 0) {
            e.preventDefault();
            showMessage('{{ __("please_select_at_least_one_role") ?? "Please select at least one role" }}', 'error');
            return false;
        }
    });
});

// Avatar preview functionality
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview" class="w-full h-full object-cover rounded-full">`;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Show message function
function showMessage(message, type) {
    // Create toast notification
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg transition-all duration-300 transform ${
        type === 'error' ? 'bg-red-500 text-white' : 
        type === 'success' ? 'bg-green-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'error' ? 'fa-exclamation-triangle' : type === 'success' ? 'fa-check' : 'fa-info-circle'} mr-3"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 5000);
}
</script>
@endsection