@extends('admin.layouts.app')

@section('title', __('messages.user_details'))

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-dark mb-1">{{ __('messages.user_details') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('messages.users') }}</a></li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary">
                <svg width="16" height="16" fill="currentColor" class="bi bi-pencil mx-2" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708L10.5 8.207l-3-3L12.146.146zM11.207 9l-3-3L2.5 11.707V13.5h1.793L11.207 9z"/>
                </svg>
                {{ __('messages.edit_user') }}
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-left mx-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                {{ __('messages.back_to_users') }}
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column - User Profile -->
        <div class="col-lg-4">
            <!-- User Profile Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center py-5">
                    <!-- Avatar -->
                    <div class="mb-4">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="avatar-xl rounded-circle mb-3">
                        @else
                            <div class="avatar-xl bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                                <span class="h2 mb-0">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- User Basic Info -->
                    <h3 class="h4 text-dark mb-2">{{ $user->name }}</h3>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    <!-- Status Badge -->
                    <div class="mb-4">
                        @if($user->trashed())
                            <span class="badge bg-danger bg-opacity-10 text-danger py-2 px-3">{{ __('messages.inactive') }}</span>
                        @else
                            <span class="badge bg-success bg-opacity-10 text-success py-2 px-3">{{ __('messages.active') }}</span>
                        @endif
                        
                        @if($user->email_verified_at)
                            <span class="badge bg-info bg-opacity-10 text-info py-2 px-3 ms-2">{{ __('messages.verified') }}</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning py-2 px-3 ms-2">{{ __('messages.unverified') }}</span>
                        @endif
                    </div>

                    <!-- Roles -->
                    <div class="mb-4">
                        <h6 class="text-dark mb-2">{{ __('messages.roles') }}</h6>
                        @foreach($user->roles as $role)
                            <span class="badge bg-{{ $role->name === 'admin' ? 'danger' : ($role->name === 'moderator' ? 'warning' : 'secondary') }} me-1">
                                {{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    </div>

                    <!-- Quick Actions -->
                    <div class="d-grid gap-2">
                        @if(!$user->trashed())
                            <a href="{{ route('admin.users.change-password', $user) }}" class="btn btn-outline-primary btn-sm">
                                <svg width="14" height="14" fill="currentColor" class="bi bi-key mx-1" viewBox="0 0 16 16">
                                    <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
                                    <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                {{ __('messages.change_password') }}
                            </a>
                        @endif
                        
                        @if(!$user->hasRole('admin') && !$user->trashed())
                            <button type="button" class="btn btn-outline-info btn-sm" onclick="impersonateUser({{ $user->id }})">
                                <svg width="14" height="14" fill="currentColor" class="bi bi-person-badge mx-1" viewBox="0 0 16 16">
                                    <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z"/>
                                </svg>
                                {{ __('messages.impersonate') }}
                            </button>
                        @endif
                        
                        @if(!$user->hasRole('admin') || \App\Models\User::role('admin')->count() > 1)
                            <button type="button" class="btn btn-outline-{{ $user->trashed() ? 'success' : 'warning' }} btn-sm" onclick="toggleUserStatus({{ $user->id }})">
                                @if($user->trashed())
                                    <svg width="14" height="14" fill="currentColor" class="bi bi-check-circle mx-1" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                    </svg>
                                    {{ __('messages.activate') }}
                                @else
                                    <svg width="14" height="14" fill="currentColor" class="bi bi-x-circle mx-1" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                    {{ __('messages.deactivate') }}
                                @endif
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-telephone mx-2 text-primary" viewBox="0 0 16 16">
                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122L9.98 10.94a6.678 6.678 0 0 1-3.15-.9l-.773-.774a6.678 6.678 0 0 1-.9-3.15L5.665 4.312a.678.678 0 0 0-.122-.58L3.654 1.328z"/>
                        </svg>
                        {{ __('messages.contact_information') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">{{ __('messages.email') }}</label>
                        <div class="fw-medium">{{ $user->email }}</div>
                    </div>
                    @if($user->phone)
                        <div class="mb-3">
                            <label class="form-label text-muted small">{{ __('messages.phone') }}</label>
                            <div class="fw-medium">{{ $user->phone }}</div>
                        </div>
                    @endif
                    @if($user->country || $user->city)
                        <div class="mb-3">
                            <label class="form-label text-muted small">{{ __('messages.location') }}</label>
                            <div class="fw-medium">
                                {{ $user->city ? $user->city . ', ' : '' }}{{ $user->country }}
                            </div>
                        </div>
                    @endif
                    @if($user->preferred_language)
                        <div class="mb-3">
                            <label class="form-label text-muted small">{{ __('messages.preferred_language') }}</label>
                            <div class="fw-medium">
                                @if($user->preferred_language === 'ar')
                                    العربية
                                @else
                                    English
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - User Details & Activity -->
        <div class="col-lg-8">
            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 bg-gradient-primary text-white h-100">
                        <div class="card-body text-center">
                            <div class="h3 mb-1">{{ number_format($stats['total_donations']) }}</div>
                            <div class="small">{{ __('messages.total_donations') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-gradient-success text-white h-100">
                        <div class="card-body text-center">
                            <div class="h3 mb-1">{{ number_format($stats['total_projects']) }}</div>
                            <div class="small">{{ __('messages.projects_supported') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-gradient-info text-white h-100">
                        <div class="card-body text-center">
                            <div class="h3 mb-1">{{ $stats['account_created']->diffForHumans() }}</div>
                            <div class="small">{{ __('messages.member_since') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-gradient-warning text-white h-100">
                        <div class="card-body text-center">
                            <div class="h3 mb-1">{{ $stats['last_login']->diffForHumans() }}</div>
                            <div class="small">{{ __('messages.last_activity') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Information Tabs -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">
                                <svg width="16" height="16" fill="currentColor" class="bi bi-info-circle mx-1" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                {{ __('messages.details') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab">
                                <svg width="16" height="16" fill="currentColor" class="bi bi-shield-check mx-1" viewBox="0 0 16 16">
                                    <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                                    <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L9.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                </svg>
                                {{ __('messages.permissions') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                                <svg width="16" height="16" fill="currentColor" class="bi bi-clock-history mx-1" viewBox="0 0 16 16">
                                    <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1.001.025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                                    <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                                    <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                {{ __('messages.activity') }}
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="userTabsContent">
                        <!-- Details Tab -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h6 class="text-dark mb-3">{{ __('messages.personal_information') }}</h6>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">{{ __('messages.full_name') }}</label>
                                        <div class="fw-medium">{{ $user->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">{{ __('messages.email_address') }}</label>
                                        <div class="fw-medium">
                                            {{ $user->email }}
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success bg-opacity-10 text-success ms-2">{{ __('messages.verified') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($user->phone)
                                        <div class="mb-3">
                                            <label class="form-label text-muted small">{{ __('messages.phone_number') }}</label>
                                            <div class="fw-medium">{{ $user->phone }}</div>
                                        </div>
                                    @endif
                                    @if($user->date_of_birth)
                                        <div class="mb-3">
                                            <label class="form-label text-muted small">{{ __('messages.date_of_birth') }}</label>
                                            <div class="fw-medium">{{ $user->date_of_birth->format('F d, Y') }}</div>
                                        </div>
                                    @endif
                                    @if($user->gender)
                                        <div class="mb-3">
                                            <label class="form-label text-muted small">{{ __('messages.gender') }}</label>
                                            <div class="fw-medium">{{ ucfirst($user->gender) }}</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-dark mb-3">{{ __('messages.account_information') }}</h6>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">{{ __('messages.user_id') }}</label>
                                        <div class="fw-medium">#{{ $user->id }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">{{ __('messages.account_created') }}</label>
                                        <div class="fw-medium">{{ $user->created_at->format('F d, Y \a\t H:i') }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">{{ __('messages.last_updated') }}</label>
                                        <div class="fw-medium">{{ $user->updated_at->format('F d, Y \a\t H:i') }}</div>
                                    </div>
                                    @if($user->email_verified_at)
                                        <div class="mb-3">
                                            <label class="form-label text-muted small">{{ __('messages.email_verified') }}</label>
                                            <div class="fw-medium">{{ $user->email_verified_at->format('F d, Y \a\t H:i') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Permissions Tab -->
                        <div class="tab-pane fade" id="permissions" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-dark mb-3">{{ __('messages.assigned_roles') }}</h6>
                                    @if($user->roles->count() > 0)
                                        @foreach($user->roles as $role)
                                            <div class="d-flex align-items-center justify-content-between p-3 border rounded mb-2">
                                                <div>
                                                    <span class="badge bg-{{ $role->name === 'admin' ? 'danger' : ($role->name === 'moderator' ? 'warning' : 'secondary') }} me-2">
                                                        {{ ucfirst($role->name) }}
                                                    </span>
                                                    <span class="text-muted">{{ $role->description ?? 'No description available' }}</span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRole({{ $user->id }}, '{{ $role->name }}')">
                                                    <svg width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">{{ __('messages.no_roles_assigned') }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-dark mb-3">{{ __('messages.assign_new_role') }}</h6>
                                    <form id="assignRoleForm" onsubmit="assignRole(event, {{ $user->id }})">
                                        <div class="mb-3">
                                            <select class="form-select" id="newRole" required>
                                                <option value="">{{ __('messages.select_role') }}</option>
                                                @php
                                                    $availableRoles = \Spatie\Permission\Models\Role::whereNotIn('name', $user->roles->pluck('name'))->get();
                                                @endphp
                                                @foreach($availableRoles as $role)
                                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            {{ __('messages.assign_role') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Tab -->
                        <div class="tab-pane fade" id="activity" role="tabpanel">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">{{ __('messages.account_created') }}</h6>
                                        <p class="text-muted mb-1">{{ __('messages.user_account_created') }}</p>
                                        <small class="text-muted">{{ $user->created_at->format('F d, Y \a\t H:i') }}</small>
                                    </div>
                                </div>
                                
                                @if($user->email_verified_at)
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-info"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">{{ __('messages.email_verified') }}</h6>
                                            <p class="text-muted mb-1">{{ __('messages.user_verified_email') }}</p>
                                            <small class="text-muted">{{ $user->email_verified_at->format('F d, Y \a\t H:i') }}</small>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">{{ __('messages.last_activity') }}</h6>
                                        <p class="text-muted mb-1">{{ __('messages.user_last_seen') }}</p>
                                        <small class="text-muted">{{ $stats['last_login']->format('F d, Y \a\t H:i') }}</small>
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

@push('scripts')
<script>
// Toggle user status
function toggleUserStatus(userId) {
    if (!confirm('{{ __('messages.confirm_user_status_change') }}')) return;

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
            showAlert('success', data.message);
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showAlert('error', data.message || 'Something went wrong');
        }
    })
    .catch(error => {
        showAlert('error', 'Network error occurred');
    });
}

// Impersonate user
function impersonateUser(userId) {
    if (!confirm('{{ __('messages.confirm_impersonate_user') }}')) return;

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
            showAlert('success', data.message);
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showAlert('error', data.message || 'Something went wrong');
        }
    })
    .catch(error => {
        showAlert('error', 'Network error occurred');
    });
}

// Remove role (placeholder function)
function removeRole(userId, roleName) {
    if (!confirm(`{{ __('messages.confirm_remove_role') }} ${roleName}?`)) return;
    
    // Implementation for removing role
    console.log(`Remove role ${roleName} from user ${userId}`);
}

// Show alert function
function showAlert(type, message) {
    // You can implement your preferred alert system here
    alert(message);
}
</script>
@endpush

@push('styles')
<style>
.avatar-xl {
    width: 120px;
    height: 120px;
    object-fit: cover;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8, #117a8b);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #d39e00);
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    position: relative;
}

.timeline-content::before {
    content: '';
    position: absolute;
    left: -8px;
    top: 15px;
    width: 0;
    height: 0;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    border-right: 8px solid #f8f9fa;
}

.nav-tabs .nav-link {
    border: none;
    border-bottom: 2px solid transparent;
    color: #6c757d;
}

.nav-tabs .nav-link.active {
    background: none;
    border-color: #007bff;
    color: #007bff;
}

.card {
    border-radius: 10px;
}

.btn {
    border-radius: 6px;
}
</style>
@endpush