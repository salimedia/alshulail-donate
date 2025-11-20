@extends('admin.layouts.app')

@section('title', __('users_management'))

@section('content')
<div class="min-h-screen bg-gray-50 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
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
                                    <span class="text-gray-800 font-medium">{{ __('users_management') }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('users_management') }}</h1>
                    <p class="text-gray-600 mt-1">{{ __('manage_users_and_their_access') }}</p>
                </div>
                @can('users.create')
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-plus mr-4"></i>
                        {{ __('add_new_user') }}
                    </a>
                </div>
                @endcan
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ number_format($users->total()) }}</h3>
                            <p class="text-blue-100">{{ __('total_users') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-blue-100">
                            <i class="fas fa-chart-line mr-2"></i>
                            <span class="text-sm">{{ __('registered_users') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ number_format(\App\Models\User::whereNull('deleted_at')->count()) }}</h3>
                            <p class="text-emerald-100">{{ __('active_users') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-check text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-emerald-100">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span class="text-sm">{{ __('verified_active') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Admin Users -->
                <div class="bg-gradient-to-br from-amber-500 via-amber-600 to-amber-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ number_format(\App\Models\User::role('admin')->count()) }}</h3>
                            <p class="text-amber-100">{{ __('admin_users') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-crown text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-amber-100">
                            <i class="fas fa-shield-alt mr-2"></i>
                            <span class="text-sm">{{ __('privileged_access') }}</span>
                        </div>
                    </div>
                </div>

                <!-- New This Month -->
                <div class="bg-gradient-to-br from-purple-500 via-purple-600 to-purple-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ number_format(\App\Models\User::whereMonth('created_at', now()->month)->count()) }}</h3>
                            <p class="text-purple-100">{{ __('new_this_month') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-plus text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-purple-100">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            <span class="text-sm">{{ __('recent_registrations') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <form method="GET" action="{{ route('admin.users.index') }}">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('search_users') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="{{ __('search_by_name_email') }}"
                                       class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('filter_by_role') }}</label>
                            <select name="role" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">{{ __('all_roles') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('filter_by_status') }}</label>
                            <select name="status" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">{{ __('all_statuses') }}</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('active') }}</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex space-x-3 mt-6">
                        <button type="submit" 
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                            <i class="fas fa-filter mr-2"></i>
                            {{ __('filter') }}
                        </button>
                        <a href="{{ route('admin.users.index') }}" 
                           class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>
                            {{ __('clear') }}
                        </a>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            @if($users->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-100">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span>{{ __('user') }}</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('email') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('roles') }}</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('status') }}</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('verified') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('created_at') }}</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ __('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-25 transition-all duration-200 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" name="selected_users[]" value="{{ $user->id }}" class="user-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        @if($user->getFirstMediaUrl('avatars'))
                                            <img src="{{ $user->getFirstMediaUrl('avatars') }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-100">
                                        @else
                                            <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                    @if($user->phone)
                                        <div class="text-xs text-gray-500">{{ $user->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($user->roles as $role)
                                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $role->name === 'admin' ? 'bg-red-100 text-red-800' : ($role->name === 'user' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">{{ __('no_roles') ?? 'No Roles' }}</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($user->trashed())
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            {{ __('inactive') }}
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            {{ __('active') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($user->email_verified_at)
                                        <div class="inline-flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                            <span class="text-xs text-green-700">{{ __('verified') }}</span>
                                        </div>
                                    @else
                                        <div class="inline-flex items-center">
                                            <i class="fas fa-clock text-orange-500 mr-1"></i>
                                            <span class="text-xs text-orange-700">{{ __('unverified') }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->created_at->format('M j, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        @can('users.view')
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="text-gray-600 hover:text-indigo-600 transition-colors duration-200"
                                           title="{{ __('view') }}">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        @endcan
                                        
                                        @can('users.edit')
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="text-gray-600 hover:text-blue-600 transition-colors duration-200"
                                           title="{{ __('edit') }}">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        @endcan

                                        <!-- More Actions Dropdown -->
                                        <div class="relative">
                                            <button onclick="toggleDropdown('actions-{{ $user->id }}')" 
                                                    class="text-gray-600 hover:text-gray-800 transition-colors duration-200 p-1"
                                                    title="{{ __('more_actions') }}">
                                                <i class="fas fa-ellipsis-v text-sm"></i>
                                            </button>
                                            
                                            <div id="actions-{{ $user->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border z-50 py-1">
                                                @can('users.edit')
                                                <a href="{{ route('admin.users.change-password', $user) }}" 
                                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                    <i class="fas fa-key mr-3 text-gray-400"></i>
                                                    {{ __('change_password') }}
                                                </a>
                                                @endcan
                                                
                                                @if(!$user->hasRole('admin') || \App\Models\User::role('admin')->count() > 1)
                                                    <button onclick="toggleUserStatus({{ $user->id }}, '{{ $user->trashed() ? 'activate' : 'deactivate' }}')"
                                                            class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                        @if($user->trashed())
                                                            <i class="fas fa-check-circle mr-3 text-green-500"></i>
                                                            {{ __('activate') }}
                                                        @else
                                                            <i class="fas fa-times-circle mr-3 text-yellow-500"></i>
                                                            {{ __('deactivate') }}
                                                        @endif
                                                    </button>
                                                @endif
                                                
                                                @if(!$user->hasRole('admin'))
                                                    <button onclick="impersonateUser({{ $user->id }})"
                                                            class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                        <i class="fas fa-user-secret mr-3 text-indigo-500"></i>
                                                        {{ __('impersonate') }}
                                                    </button>
                                                @endif
                                                
                                                @can('users.delete')
                                                @if(!$user->hasRole('admin') || \App\Models\User::role('admin')->count() > 1)
                                                    <button onclick="deleteUser({{ $user->id }})"
                                                            class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                        <i class="fas fa-trash mr-3"></i>
                                                        {{ __('delete') }}
                                                    </button>
                                                @endif
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Bulk Actions -->
                <div id="bulkActions" class="hidden bg-gray-50 px-6 py-3 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-medium text-gray-700">
                                <span id="selectedCount">0</span> {{ __('users_selected') ?? 'users selected' }}
                            </span>
                            <div class="flex space-x-2">
                                <button onclick="bulkActivateUsers()" class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ __('activate_selected') }}
                                </button>
                                <button onclick="bulkDeactivateUsers()" class="inline-flex items-center px-3 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                                    <i class="fas fa-pause-circle mr-1"></i>
                                    {{ __('deactivate_selected') }}
                                </button>
                                <button onclick="bulkDeleteUsers()" class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-200">
                                    <i class="fas fa-trash mr-1"></i>
                                    {{ __('delete_selected') }}
                                </button>
                            </div>
                        </div>
                        <button onclick="clearSelection()" class="text-xs text-gray-500 hover:text-gray-700">
                            {{ __('clear_selection') ?? 'Clear Selection' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-2xl shadow-lg p-4">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('no_users_found') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('no_users_matching_criteria') }}</p>
                @can('users.create')
                <a href="{{ route('admin.users.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('create_first_user') }}
                </a>
                @endcan
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .gradient-border {
        background: linear-gradient(45deg, #3b82f6, #8b5cf6);
        padding: 2px;
        border-radius: 1rem;
    }
    .gradient-border > div {
        background: white;
        border-radius: calc(1rem - 2px);
    }
</style>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('[id^="dropdown-"], [id^="actions-"]');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target) && !event.target.closest('button[onclick^="toggleDropdown"]')) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // Handle select all checkbox
    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');

    selectAllCheckbox?.addEventListener('change', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsVisibility();
    });

    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateBulkActionsVisibility();
        });
    });

    function updateSelectAllState() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const allBoxes = document.querySelectorAll('.user-checkbox');
        
        if (checkedBoxes.length === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (checkedBoxes.length === allBoxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
            selectAllCheckbox.checked = false;
        }
    }

    function updateBulkActionsVisibility() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        if (checkedBoxes.length > 0) {
            bulkActions.classList.remove('hidden');
            selectedCount.textContent = checkedBoxes.length;
        } else {
            bulkActions.classList.add('hidden');
        }
    }
});

// Toggle dropdown visibility
function toggleDropdown(dropdownId) {
    // Close all other dropdowns first
    document.querySelectorAll('[id^="dropdown-"], [id^="actions-"]').forEach(dropdown => {
        if (dropdown.id !== dropdownId) {
            dropdown.classList.add('hidden');
        }
    });
    
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('hidden');
}

// Clear selection
function clearSelection() {
    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    document.getElementById('selectAll').indeterminate = false;
    document.getElementById('bulkActions').classList.add('hidden');
}

// Get selected user IDs
function getSelectedUserIds() {
    return Array.from(document.querySelectorAll('.user-checkbox:checked')).map(checkbox => checkbox.value);
}

// Bulk activate users
function bulkActivateUsers() {
    const userIds = getSelectedUserIds();
    if (userIds.length === 0) {
        showMessage('{{ __("please_select_users") }}', 'warning');
        return;
    }
    
    if (!confirm('{{ __("confirm_bulk_action") }} (' + userIds.length + ' users)?')) return;
    
    fetch('{{ route("admin.users.index") }}/bulk/activate', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_ids: userIds })
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

// Bulk deactivate users
function bulkDeactivateUsers() {
    const userIds = getSelectedUserIds();
    if (userIds.length === 0) {
        showMessage('{{ __("please_select_users") }}', 'warning');
        return;
    }
    
    if (!confirm('{{ __("confirm_bulk_action") }} (' + userIds.length + ' users)?')) return;
    
    fetch('{{ route("admin.users.index") }}/bulk/deactivate', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_ids: userIds })
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

// Bulk delete users
function bulkDeleteUsers() {
    const userIds = getSelectedUserIds();
    if (userIds.length === 0) {
        showMessage('{{ __("please_select_users") }}', 'warning');
        return;
    }
    
    if (!confirm('{{ __("confirm_bulk_action") }} (' + userIds.length + ' users)? This action can be undone.')) return;
    
    fetch('{{ route("admin.users.index") }}/bulk/delete', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_ids: userIds })
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

// Toggle user status
function toggleUserStatus(userId, action) {
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

// Delete user
function deleteUser(userId) {
    if (!confirm('{{ __("are_you_sure") }}')) return;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ route('admin.users.index') }}/${userId}`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    
    form.appendChild(csrfToken);
    form.appendChild(methodField);
    document.body.appendChild(form);
    form.submit();
}

// Show message function
function showMessage(message, type) {
    if (typeof window.admin !== 'undefined' && window.admin.showMessage) {
        window.admin.showMessage(message, type);
    } else {
        alert(message);
    }
}
</script>
@endsection