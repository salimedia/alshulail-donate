@extends('admin.layouts.app')

@section('title', __('permissions_management'))

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
                                    <span class="text-gray-800 font-medium">{{ __('permissions_management') }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('permissions_management') }}</h1>
                    <p class="text-gray-600 mt-1">{{ __('view_and_manage_system_permissions') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.roles.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-shield-alt mr-4"></i>
                        {{ __('manage_roles') }}
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Permissions -->
                <div class="bg-gradient-to-br from-indigo-500 via-indigo-600 to-indigo-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $permissions->total() }}</h3>
                            <p class="text-indigo-100">{{ __('total_permissions') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-key text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-indigo-100">
                            <i class="fas fa-lock mr-2"></i>
                            <span class="text-sm">{{ __('system_permissions') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Permission Groups -->
                <div class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $groups->count() }}</h3>
                            <p class="text-emerald-100">{{ __('permission_groups') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-layer-group text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-emerald-100">
                            <i class="fas fa-cubes mr-2"></i>
                            <span class="text-sm">{{ __('organized_categories') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Role Assignments -->
                <div class="bg-gradient-to-br from-amber-500 via-amber-600 to-amber-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $permissions->sum('roles_count') }}</h3>
                            <p class="text-amber-100">{{ __('role_assignments') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-link text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-amber-100">
                            <i class="fas fa-shield-alt mr-2"></i>
                            <span class="text-sm">{{ __('role_connections') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Direct User Assignments -->
                <div class="bg-gradient-to-br from-rose-500 via-rose-600 to-rose-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $permissions->sum('users_count') }}</h3>
                            <p class="text-rose-100">{{ __('direct_user_assignments') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-check text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-rose-100">
                            <i class="fas fa-user-cog mr-2"></i>
                            <span class="text-sm">{{ __('individual_access') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <form method="GET" action="{{ route('admin.permissions.index') }}">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('search_permissions') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="{{ __('search_by_permission_name') }}"
                                       class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('permission_group') }}</label>
                            <select name="group" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                <option value="">{{ __('all_groups') }}</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group }}" {{ request('group') === $group ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('-', ' ', $group)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">&nbsp;</label>
                            <div class="flex space-x-3">
                                <button type="submit" 
                                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                    <i class="fas fa-filter mr-2"></i>
                                    {{ __('filter') }}
                                </button>
                                <a href="{{ route('admin.permissions.index') }}" 
                                   class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                    <i class="fas fa-times mr-2"></i>
                                    {{ __('clear') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Permissions Grid -->
            @if($permissions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($permissions as $permission)
                @php
                    $parts = explode('.', $permission->name);
                    $group = $parts[0];
                    $action = $parts[1] ?? '';
                    $totalCoverage = $permission->roles_count + $permission->users_count;
                @endphp
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden">
                    <!-- Permission Header -->
                    <div class="relative p-6 bg-gradient-to-r {{ $this->getGroupGradient($group) }} text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-{{ $this->getPermissionIcon($action) }} text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold">{{ $permission->name }}</h3>
                                    <p class="text-white text-opacity-80 text-sm">{{ ucfirst(str_replace(['.', '-'], [' ', ' '], $action)) }} {{ __('permission') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Group Badge -->
                        <div class="flex justify-between items-center">
                            <span class="inline-flex px-3 py-1 text-sm font-medium bg-white bg-opacity-20 text-white rounded-full">
                                <i class="fas fa-{{ $this->getGroupIcon($group) }} mr-2"></i>
                                {{ ucfirst(str_replace('-', ' ', $group)) }}
                            </span>
                            
                            <!-- Coverage Status -->
                            @if($totalCoverage > 0)
                                <span class="inline-flex px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    {{ $totalCoverage }} {{ __('assignments') }}
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                    {{ __('not_assigned') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Permission Stats -->
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-indigo-600">{{ $permission->roles_count }}</div>
                                <div class="text-sm text-gray-500">{{ __('roles') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-rose-600">{{ $permission->users_count }}</div>
                                <div class="text-sm text-gray-500">{{ __('direct_users') }}</div>
                            </div>
                        </div>

                        <!-- Coverage Bar -->
                        @if($totalCoverage > 0)
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ __('coverage') }}</span>
                                <span class="text-sm text-gray-500">{{ min(($totalCoverage / 10) * 100, 100) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full" 
                                     style="width: {{ min(($totalCoverage / 10) * 100, 100) }}%"></div>
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.permissions.show', $permission) }}" 
                               class="text-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg transition-all duration-200">
                                <i class="fas fa-eye mr-1"></i>
                                {{ __('view_details') }}
                            </a>
                            
                            @can('permissions.assign')
                            <button onclick="showAssignModal('{{ $permission->id }}', '{{ $permission->name }}')"
                                    class="text-center px-3 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-sm rounded-lg transition-all duration-200">
                                <i class="fas fa-plus mr-1"></i>
                                {{ __('assign') }}
                            </button>
                            @endcan
                        </div>

                        <!-- Additional Actions -->
                        @can('permissions.assign')
                        <div class="mt-3">
                            <div class="relative">
                                <button onclick="toggleDropdown('dropdown-{{ $permission->id }}')" 
                                        class="w-full px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm rounded-lg transition-all duration-200 flex items-center justify-center">
                                    <i class="fas fa-ellipsis-h mr-2"></i>
                                    {{ __('more_actions') }}
                                </button>
                                
                                <div id="dropdown-{{ $permission->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border z-50">
                                    <button onclick="showAssignModal('{{ $permission->id }}', '{{ $permission->name }}')"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg">
                                        <i class="fas fa-shield-alt mr-2"></i>
                                        {{ __('assign_to_role') }}
                                    </button>
                                    <button onclick="showUserAssignModal('{{ $permission->id }}', '{{ $permission->name }}')"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        {{ __('assign_to_user') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($permissions->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-2xl shadow-lg p-4">
                    {{ $permissions->withQueryString()->links() }}
                </div>
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-key text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('no_permissions_found') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('no_permissions_matching_criteria') }}</p>
                <a href="{{ route('admin.permissions.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                    <i class="fas fa-refresh mr-2"></i>
                    {{ __('reset_filters') }}
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Assign to Role Modal -->
@can('permissions.assign')
<div id="assignRoleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">{{ __('assign_permission_to_role') }}</h3>
        </div>
        <form id="assignRoleForm" class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('permission') }}</label>
                <input type="text" id="assignPermissionName" class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50" readonly>
                <input type="hidden" id="assignPermissionId">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('select_role') }}</label>
                <select id="assignRoleSelect" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">{{ __('choose_role') }}</option>
                    @foreach(\Spatie\Permission\Models\Role::all() as $role)
                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="hideAssignModal()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-200">
                    {{ __('cancel') }}
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-all duration-200">
                    {{ __('assign_permission') }}
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Assign to User Modal -->
<div id="assignUserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">{{ __('assign_permission_to_user') }}</h3>
        </div>
        <form id="assignUserForm" class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('permission') }}</label>
                <input type="text" id="assignUserPermissionName" class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50" readonly>
                <input type="hidden" id="assignUserPermissionId">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('select_user') }}</label>
                <select id="assignUserSelect" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">{{ __('choose_user') }}</option>
                    @foreach(\App\Models\User::select('id', 'name', 'email')->get() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="hideUserAssignModal()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-200">
                    {{ __('cancel') }}
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-xl transition-all duration-200">
                    {{ __('assign_permission') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endcan

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target) && !event.target.closest('button[onclick^="toggleDropdown"]')) {
                dropdown.classList.add('hidden');
            }
        });
    });
});

// Toggle dropdown visibility
function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('hidden');
}

// Show assign to role modal
function showAssignModal(permissionId, permissionName) {
    document.getElementById('assignPermissionId').value = permissionId;
    document.getElementById('assignPermissionName').value = permissionName;
    document.getElementById('assignRoleSelect').value = '';
    document.getElementById('assignRoleModal').classList.remove('hidden');
}

// Hide assign to role modal
function hideAssignModal() {
    document.getElementById('assignRoleModal').classList.add('hidden');
}

// Show assign to user modal
function showUserAssignModal(permissionId, permissionName) {
    document.getElementById('assignUserPermissionId').value = permissionId;
    document.getElementById('assignUserPermissionName').value = permissionName;
    document.getElementById('assignUserSelect').value = '';
    document.getElementById('assignUserModal').classList.remove('hidden');
}

// Hide assign to user modal
function hideUserAssignModal() {
    document.getElementById('assignUserModal').classList.add('hidden');
}

// Handle role assignment form
document.getElementById('assignRoleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const permissionId = document.getElementById('assignPermissionId').value;
    const roleId = document.getElementById('assignRoleSelect').value;
    
    fetch('{{ route('admin.permissions.sync-role') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            permission_id: permissionId,
            role_id: roleId,
            action: 'assign'
        })
    })
    .then(response => response.json())
    .then(data => {
        hideAssignModal();
        if (data.success) {
            showMessage(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showMessage(data.message, 'error');
        }
    })
    .catch(error => {
        showMessage('{{ __("operation_failed") }}', 'error');
    });
});

// Handle user assignment form
document.getElementById('assignUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const permissionId = document.getElementById('assignUserPermissionId').value;
    const userId = document.getElementById('assignUserSelect').value;
    
    fetch('{{ route('admin.permissions.assign-user') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            permission_id: permissionId,
            user_id: userId
        })
    })
    .then(response => response.json())
    .then(data => {
        hideUserAssignModal();
        if (data.success) {
            showMessage(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showMessage(data.message, 'error');
        }
    })
    .catch(error => {
        showMessage('{{ __("operation_failed") }}', 'error');
    });
});

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

@php
function getGroupIcon($group) {
    $icons = [
        'users' => 'users',
        'roles' => 'shield-alt',
        'permissions' => 'key',
        'donations' => 'heart',
        'projects' => 'project-diagram',
        'categories' => 'tags',
        'payments' => 'credit-card',
        'beneficiaries' => 'user-check',
        'settings' => 'cog',
        'audit-logs' => 'history',
        'statistics' => 'chart-bar',
        'reports' => 'file-alt',
        'pages' => 'file-text'
    ];
    
    return $icons[$group] ?? 'circle';
}

function getPermissionIcon($action) {
    $icons = [
        'view' => 'eye',
        'create' => 'plus-circle',
        'edit' => 'edit',
        'delete' => 'trash',
        'restore' => 'undo',
        'force-delete' => 'times-circle',
        'impersonate' => 'user-secret',
        'assign' => 'link',
        'approve' => 'check-circle',
        'export' => 'download',
        'publish' => 'globe',
        'unpublish' => 'eye-slash',
        'refund' => 'undo',
        'change-password' => 'key'
    ];
    
    return $icons[$action] ?? 'cog';
}

function getGroupGradient($group) {
    $gradients = [
        'users' => 'from-blue-500 to-cyan-600',
        'roles' => 'from-purple-500 to-pink-600',
        'permissions' => 'from-indigo-500 to-purple-600',
        'donations' => 'from-red-500 to-pink-600',
        'projects' => 'from-green-500 to-teal-600',
        'categories' => 'from-yellow-500 to-orange-600',
        'payments' => 'from-blue-600 to-purple-600',
        'beneficiaries' => 'from-emerald-500 to-green-600',
        'settings' => 'from-gray-500 to-slate-600',
        'audit-logs' => 'from-orange-500 to-red-600',
        'statistics' => 'from-teal-500 to-cyan-600',
        'reports' => 'from-indigo-600 to-blue-600',
        'pages' => 'from-purple-600 to-indigo-600'
    ];
    
    return $gradients[$group] ?? 'from-gray-500 to-gray-600';
}
@endphp