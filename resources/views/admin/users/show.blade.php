@extends('admin.layouts.app')

@section('title', __('user_details'))

@section('content')
<div class="min-h-screen bg-gray-50 px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Page Title & Breadcrumb -->
            <div class="flex items-center justify-between mb-8">
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
                                    <span class="text-gray-800 font-medium">{{ $user->name }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('user_details') }}</h1>
                    <p class="text-gray-600 mt-1">{{ __('complete_user_profile_and_account_information') ?? 'Complete user profile and account information' }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-edit mr-4"></i>
                        {{ __('edit_user') }}
                    </a>
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-arrow-left mr-4"></i>
                        {{ __('back_to_users') }}
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Left Column - User Profile Card -->
                <div class="lg:col-span-1">
                    <!-- User Profile -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <!-- Profile Header -->
                        <div class="relative bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-600 h-32">
                            <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                                @if($user->getFirstMediaUrl('avatars'))
                                    <img src="{{ $user->getFirstMediaUrl('avatars') }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                                @else
                                    <div class="w-32 h-32 bg-gradient-to-r from-gray-400 to-gray-600 rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                                        <span class="text-3xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Profile Info -->
                        <div class="pt-20 pb-8 px-6 text-center">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $user->name }}</h2>
                            <p class="text-gray-600 mb-4">{{ $user->email }}</p>

                            <!-- Status Badges -->
                            <div class="flex justify-center space-x-2 mb-6">
                                @if($user->trashed())
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        {{ __('inactive') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        {{ __('active') }}
                                    </span>
                                @endif
                                
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                        <i class="fas fa-shield-check mr-1"></i>
                                        {{ __('verified') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold bg-orange-100 text-orange-800 rounded-full">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        {{ __('unverified') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Roles -->
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2">{{ __('roles') }}</h3>
                                <div class="flex flex-wrap justify-center gap-2">
                                    @forelse($user->roles as $role)
                                        <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ $role->name === 'admin' ? 'bg-red-100 text-red-800' : ($role->name === 'moderator' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @empty
                                        <span class="text-sm text-gray-400">{{ __('no_roles') ?? 'No roles assigned' }}</span>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="space-y-3">
                                @if(!$user->trashed())
                                    <a href="{{ route('admin.users.change-password', $user) }}" 
                                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium rounded-lg transition-colors duration-200">
                                        <i class="fas fa-key mr-2"></i>
                                        {{ __('change_password') }}
                                    </a>
                                @endif
                                
                                @if(!$user->hasRole('admin') && !$user->trashed())
                                    <button onclick="impersonateUser({{ $user->id }})"
                                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium rounded-lg transition-colors duration-200">
                                        <i class="fas fa-user-secret mr-2"></i>
                                        {{ __('impersonate') }}
                                    </button>
                                @endif
                                
                                @if(!$user->hasRole('admin') || \App\Models\User::role('admin')->count() > 1)
                                    <button onclick="toggleUserStatus({{ $user->id }})"
                                            class="w-full inline-flex items-center justify-center px-4 py-2 {{ $user->trashed() ? 'bg-green-50 hover:bg-green-100 text-green-700' : 'bg-yellow-50 hover:bg-yellow-100 text-yellow-700' }} font-medium rounded-lg transition-colors duration-200">
                                        @if($user->trashed())
                                            <i class="fas fa-check-circle mr-2"></i>
                                            {{ __('activate') }}
                                        @else
                                            <i class="fas fa-pause-circle mr-2"></i>
                                            {{ __('deactivate') }}
                                        @endif
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-address-card text-white"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ __('contact_information') ?? 'Contact Information' }}</h3>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('email') }}</label>
                                <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                            </div>
                            
                            @if($user->phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('phone_number') }}</label>
                                    <p class="text-gray-900 font-medium">{{ $user->phone }}</p>
                                </div>
                            @endif
                            
                            @if($user->country || $user->city)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('location') ?? 'Location' }}</label>
                                    <p class="text-gray-900 font-medium">
                                        {{ $user->city ? $user->city . ', ' : '' }}{{ $user->country }}
                                    </p>
                                </div>
                            @endif
                            
                            @if($user->preferred_language)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('preferred_language') }}</label>
                                    <p class="text-gray-900 font-medium">
                                        @if($user->preferred_language === 'ar')
                                            العربية
                                        @else
                                            English
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Main Content -->
                <div class="lg:col-span-3 space-y-8">
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Total Donations -->
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm font-medium">{{ __('total_donations') }}</p>
                                    <p class="text-3xl font-bold">{{ number_format($stats['total_donations']) }}</p>
                                </div>
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-heart text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Projects Supported -->
                        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm font-medium">{{ __('projects_supported') ?? 'Projects Supported' }}</p>
                                    <p class="text-3xl font-bold">{{ number_format($stats['total_projects']) }}</p>
                                </div>
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-project-diagram text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Member Since -->
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-100 text-sm font-medium">{{ __('member_since') }}</p>
                                    <p class="text-xl font-bold">{{ $stats['account_created']->format('M Y') }}</p>
                                </div>
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-calendar text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Last Activity -->
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-orange-100 text-sm font-medium">{{ __('last_activity') ?? 'Last Activity' }}</p>
                                    <p class="text-lg font-bold">{{ $stats['last_login']->diffForHumans() }}</p>
                                </div>
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-clock text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabbed Content -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <!-- Tab Navigation -->
                        <div class="border-b border-gray-200">
                            <nav class="flex space-x-8 px-6 py-4">
                                <button onclick="switchTab('details')" id="details-tab"
                                        class="tab-button active flex items-center space-x-2 py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-info-circle"></i>
                                    <span>{{ __('details') ?? 'Details' }}</span>
                                </button>
                                <button onclick="switchTab('permissions')" id="permissions-tab"
                                        class="tab-button flex items-center space-x-2 py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>{{ __('permissions') ?? 'Permissions' }}</span>
                                </button>
                                <button onclick="switchTab('activity')" id="activity-tab"
                                        class="tab-button flex items-center space-x-2 py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-history"></i>
                                    <span>{{ __('activity') ?? 'Activity' }}</span>
                                </button>
                            </nav>
                        </div>

                        <!-- Tab Content -->
                        <div class="p-6">
                            <!-- Details Tab -->
                            <div id="details-content" class="tab-content">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Personal Information -->
                                    <div>
                                        <div class="flex items-center mb-6">
                                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900">{{ __('personal_information') ?? 'Personal Information' }}</h3>
                                        </div>
                                        
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('full_name') }}</label>
                                                <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('email_address') }}</label>
                                                <div class="flex items-center space-x-2">
                                                    <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                                                    @if($user->email_verified_at)
                                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                                            <i class="fas fa-check mr-1"></i>
                                                            {{ __('verified') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @if($user->phone)
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('phone_number') }}</label>
                                                    <p class="text-gray-900 font-medium">{{ $user->phone }}</p>
                                                </div>
                                            @endif
                                            
                                            @if($user->date_of_birth)
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('date_of_birth') }}</label>
                                                    <p class="text-gray-900 font-medium">{{ $user->date_of_birth->format('F d, Y') }}</p>
                                                </div>
                                            @endif
                                            
                                            @if($user->gender)
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('gender') }}</label>
                                                    <p class="text-gray-900 font-medium">{{ ucfirst($user->gender) }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Account Information -->
                                    <div>
                                        <div class="flex items-center mb-6">
                                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-cog text-purple-600"></i>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900">{{ __('account_information') ?? 'Account Information' }}</h3>
                                        </div>
                                        
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('user_id') ?? 'User ID' }}</label>
                                                <p class="text-gray-900 font-medium">#{{ $user->id }}</p>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('account_created') ?? 'Account Created' }}</label>
                                                <p class="text-gray-900 font-medium">{{ $user->created_at->format('F d, Y \a\t H:i') }}</p>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('last_updated') ?? 'Last Updated' }}</label>
                                                <p class="text-gray-900 font-medium">{{ $user->updated_at->format('F d, Y \a\t H:i') }}</p>
                                            </div>
                                            
                                            @if($user->email_verified_at)
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('email_verified') ?? 'Email Verified' }}</label>
                                                    <p class="text-gray-900 font-medium">{{ $user->email_verified_at->format('F d, Y \a\t H:i') }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Permissions Tab -->
                            <div id="permissions-content" class="tab-content hidden">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Assigned Roles -->
                                    <div>
                                        <div class="flex items-center mb-6">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-user-tag text-green-600"></i>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900">{{ __('assigned_roles') ?? 'Assigned Roles' }}</h3>
                                        </div>
                                        
                                        @if($user->roles->count() > 0)
                                            <div class="space-y-3">
                                                @foreach($user->roles as $role)
                                                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                                                        <div class="flex items-center space-x-3">
                                                            <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ $role->name === 'admin' ? 'bg-red-100 text-red-800' : ($role->name === 'moderator' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                                {{ ucfirst($role->name) }}
                                                            </span>
                                                            <span class="text-gray-600 text-sm">{{ $role->description ?? 'No description available' }}</span>
                                                        </div>
                                                        <button onclick="removeRole({{ $user->id }}, '{{ $role->name }}')" 
                                                                class="text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                                            <i class="fas fa-trash text-sm"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-12">
                                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                                    <i class="fas fa-user-minus text-2xl text-gray-400"></i>
                                                </div>
                                                <p class="text-gray-500">{{ __('no_roles_assigned') ?? 'No roles assigned to this user' }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Assign New Role -->
                                    <div>
                                        <div class="flex items-center mb-6">
                                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-plus text-blue-600"></i>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900">{{ __('assign_new_role') ?? 'Assign New Role' }}</h3>
                                        </div>
                                        
                                        <form id="assignRoleForm" onsubmit="assignRole(event, {{ $user->id }})" class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('select_role') ?? 'Select Role' }}</label>
                                                <select id="newRole" required 
                                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                                    <option value="">{{ __('choose_role') ?? 'Choose a role...' }}</option>
                                                    @php
                                                        $availableRoles = \Spatie\Permission\Models\Role::whereNotIn('name', $user->roles->pluck('name'))->get();
                                                    @endphp
                                                    @foreach($availableRoles as $role)
                                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" 
                                                    class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                                <i class="fas fa-plus mr-2"></i>
                                                {{ __('assign_role') ?? 'Assign Role' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Tab -->
                            <div id="activity-content" class="tab-content hidden">
                                <div class="flex items-center mb-6">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-history text-indigo-600"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ __('user_activity_timeline') ?? 'User Activity Timeline' }}</h3>
                                </div>
                                
                                <div class="relative">
                                    <!-- Timeline -->
                                    <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                                    
                                    <!-- Timeline Items -->
                                    <div class="space-y-6">
                                        <!-- Account Created -->
                                        <div class="relative flex items-start space-x-4">
                                            <div class="relative z-10 w-12 h-12 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                                                <i class="fas fa-user-plus text-white"></i>
                                            </div>
                                            <div class="flex-1 bg-green-50 border border-green-200 rounded-xl p-4">
                                                <h4 class="font-semibold text-green-800">{{ __('account_created') ?? 'Account Created' }}</h4>
                                                <p class="text-green-700 text-sm mt-1">{{ __('user_account_created') ?? 'User account was created and activated' }}</p>
                                                <p class="text-green-600 text-xs mt-2">{{ $user->created_at->format('F d, Y \a\t H:i') }}</p>
                                            </div>
                                        </div>

                                        @if($user->email_verified_at)
                                            <!-- Email Verified -->
                                            <div class="relative flex items-start space-x-4">
                                                <div class="relative z-10 w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center shadow-lg">
                                                    <i class="fas fa-envelope-check text-white"></i>
                                                </div>
                                                <div class="flex-1 bg-blue-50 border border-blue-200 rounded-xl p-4">
                                                    <h4 class="font-semibold text-blue-800">{{ __('email_verified') ?? 'Email Verified' }}</h4>
                                                    <p class="text-blue-700 text-sm mt-1">{{ __('user_verified_email') ?? 'User verified their email address' }}</p>
                                                    <p class="text-blue-600 text-xs mt-2">{{ $user->email_verified_at->format('F d, Y \a\t H:i') }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Last Activity -->
                                        <div class="relative flex items-start space-x-4">
                                            <div class="relative z-10 w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center shadow-lg">
                                                <i class="fas fa-clock text-white"></i>
                                            </div>
                                            <div class="flex-1 bg-purple-50 border border-purple-200 rounded-xl p-4">
                                                <h4 class="font-semibold text-purple-800">{{ __('last_activity') ?? 'Last Activity' }}</h4>
                                                <p class="text-purple-700 text-sm mt-1">{{ __('user_last_seen') ?? 'User was last seen online' }}</p>
                                                <p class="text-purple-600 text-xs mt-2">{{ $stats['last_login']->format('F d, Y \a\t H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
// Tab switching functionality
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(tab => {
        tab.classList.remove('active', 'border-blue-500', 'text-blue-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active class to selected tab
    const selectedTab = document.getElementById(tabName + '-tab');
    selectedTab.classList.add('active', 'border-blue-500', 'text-blue-600');
    selectedTab.classList.remove('border-transparent', 'text-gray-500');
}

// Initialize default tab
document.addEventListener('DOMContentLoaded', function() {
    switchTab('details');
});

// Toggle user status
function toggleUserStatus(userId) {
    if (!confirm('{{ __("are_you_sure") }}')) return;

    fetch(`{{ route('admin.users.index') }}/${userId}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMessage(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showMessage(data.message || 'Something went wrong', 'error');
        }
    })
    .catch(error => {
        showMessage('Network error occurred', 'error');
    });
}

// Impersonate user
function impersonateUser(userId) {
    if (!confirm('{{ __("are_you_sure") }}')) return;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ route('admin.users.index') }}/${userId}/impersonate`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    form.appendChild(csrfToken);
    document.body.appendChild(form);
    form.submit();
}

// Assign role
function assignRole(event, userId) {
    event.preventDefault();
    
    const roleSelect = document.getElementById('newRole');
    const role = roleSelect.value;
    
    if (!role) return;

    fetch(`{{ route('admin.users.index') }}/${userId}/assign-role`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ role: role })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMessage(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showMessage(data.message || 'Something went wrong', 'error');
        }
    })
    .catch(error => {
        showMessage('Network error occurred', 'error');
    });
}

// Remove role (placeholder function)
function removeRole(userId, roleName) {
    if (!confirm(`{{ __("are_you_sure") }} ${roleName}?`)) return;
    
    // Implementation for removing role would go here
    showMessage('Role removal functionality needs to be implemented', 'warning');
}

// Show message function
function showMessage(message, type) {
    // Create toast notification
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg transition-all duration-300 transform ${
        type === 'error' ? 'bg-red-500 text-white' : 
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'warning' ? 'bg-yellow-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'error' ? 'fa-exclamation-triangle' : type === 'success' ? 'fa-check' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'} mr-3"></i>
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

<style>
.tab-button.active {
    border-bottom-color: #3b82f6 !important;
    color: #3b82f6 !important;
}
</style>
@endsection