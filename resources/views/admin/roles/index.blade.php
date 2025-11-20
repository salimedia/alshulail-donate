@extends('admin.layouts.app')

@section('title', 'Roles Management')

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
                                    <i class="fas fa-home mr-2"></i>
                                    {{ __('Dashboard') }}
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                    <span class="text-gray-800 font-medium">{{ __('Roles Management') }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('Roles Management') }}</h1>
                    <p class="text-gray-600 mt-1">{{ __('Manage system roles and their permissions') }}</p>
                </div>
                @can('roles.create')
                <div class="flex space-x-3">
                    <a href="{{ route('admin.roles.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Add New Role') }}
                    </a>
                </div>
                @endcan
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Roles -->
                <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $roles->total() }}</h3>
                            <p class="text-blue-100">{{ __('Total Roles') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-shield-alt text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-blue-100">
                            <i class="fas fa-chart-line mr-2"></i>
                            <span class="text-sm">{{ __('System Roles') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Users with Roles -->
                <div class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $roles->sum('users_count') }}</h3>
                            <p class="text-emerald-100">{{ __('Users with Roles') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-emerald-100">
                            <i class="fas fa-user-check mr-2"></i>
                            <span class="text-sm">{{ __('Active Users') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Total Permissions -->
                <div class="bg-gradient-to-br from-amber-500 via-amber-600 to-amber-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $roles->sum('permissions_count') }}</h3>
                            <p class="text-amber-100">{{ __('Total Permissions') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-key text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-amber-100">
                            <i class="fas fa-lock mr-2"></i>
                            <span class="text-sm">{{ __('Access Control') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Custom Roles -->
                <div class="bg-gradient-to-br from-purple-500 via-purple-600 to-purple-700 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $roles->where('name', '!=', 'admin')->count() }}</h3>
                            <p class="text-purple-100">{{ __('Custom Roles') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-cog text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-purple-100">
                            <i class="fas fa-tools mr-2"></i>
                            <span class="text-sm">{{ __('Customizable') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <form method="GET" action="{{ route('admin.roles.index') }}">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Search Roles') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="{{ __('Search by role name...') }}"
                                       class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <button type="submit" 
                                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                <i class="fas fa-filter mr-2"></i>
                                {{ __('Filter') }}
                            </button>
                            <a href="{{ route('admin.roles.index') }}" 
                               class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                <i class="fas fa-times mr-2"></i>
                                {{ __('Clear') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Roles Grid -->
            @if($roles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($roles as $role)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden">
                    <!-- Role Header -->
                    <div class="relative p-6 {{ $role->name === 'admin' ? 'bg-gradient-to-r from-red-500 to-pink-500' : 'bg-gradient-to-r from-blue-500 to-purple-500' }} text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-{{ $role->name === 'admin' ? 'crown' : 'shield-alt' }} text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold">{{ ucfirst($role->name) }}</h3>
                                    @if($role->name === 'admin')
                                    <span class="inline-flex px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                        {{ __('System Role') }}
                                    </span>
                                    @else
                                    <span class="inline-flex px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                        {{ __('Custom Role') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role Stats -->
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $role->users_count }}</div>
                                <div class="text-sm text-gray-500">{{ __('Users') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-purple-600">{{ $role->permissions_count }}</div>
                                <div class="text-sm text-gray-500">{{ __('Permissions') }}</div>
                            </div>
                        </div>

                        <!-- Role Info -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar mr-2"></i>
                                <span class="text-sm">{{ __('Created') }}: {{ $role->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-clock mr-2"></i>
                                <span class="text-sm">{{ $role->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.roles.show', $role) }}" 
                               class="flex-1 text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-200">
                                <i class="fas fa-eye mr-1"></i>
                                {{ __('View') }}
                            </a>
                            
                            @can('roles.edit')
                            @if($role->name !== 'admin' || auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.roles.edit', $role) }}" 
                               class="flex-1 text-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl transition-all duration-200">
                                <i class="fas fa-edit mr-1"></i>
                                {{ __('Edit') }}
                            </a>
                            @endif
                            @endcan

                            @can('roles.delete')
                            @if($role->name !== 'admin')
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="delete-form flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl transition-all duration-200">
                                    <i class="fas fa-trash mr-1"></i>
                                    {{ __('Delete') }}
                                </button>
                            </form>
                            @endif
                            @endcan
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($roles->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-2xl shadow-lg p-4">
                    {{ $roles->withQueryString()->links() }}
                </div>
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shield-alt text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('No Roles Found') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('There are no roles matching your criteria.') }}</p>
                @can('roles.create')
                <a href="{{ route('admin.roles.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Create First Role') }}
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
    // Delete confirmation with SweetAlert
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '{{ __("Are you sure?") }}',
                    text: '{{ __("This role will be permanently deleted. Users will lose this role.") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '{{ __("Yes, delete it!") }}',
                    cancelButtonText: '{{ __("Cancel") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            } else {
                // Fallback to native confirm
                if (confirm('{{ __("Are you sure you want to delete this role?") }}')) {
                    form.submit();
                }
            }
        });
    });

    // Add loading states to buttons
    document.querySelectorAll('form button[type="submit"]').forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-spinner fa-spin mr-2';
            }
        });
    });
});
</script>
@endsection