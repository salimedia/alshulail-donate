@extends('admin.layouts.app')

@section('title', 'Role Details - ' . ucfirst($role->name))

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Role Details</h1>
                    <p class="text-muted mb-0">View and manage role information and assignments</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Roles
                    </a>
                    @can('roles.edit')
                    @if($role->name !== 'admin' || auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Role
                    </a>
                    @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Role Information -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-shield-check me-2"></i>Role Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-lg bg-primary text-white rounded-circle mx-auto mb-3">
                            <i class="bi bi-shield{{ $role->name === 'admin' ? '-check' : '' }} fs-3"></i>
                        </div>
                        <h4 class="fw-bold">{{ ucfirst($role->name) }}</h4>
                        @if($role->name === 'admin')
                        <span class="badge bg-danger mb-2">System Role</span>
                        @else
                        <span class="badge bg-success mb-2">Custom Role</span>
                        @endif
                    </div>

                    <div class="row text-center mb-3">
                        <div class="col">
                            <h5 class="fw-bold text-primary mb-0">{{ $role->users->count() }}</h5>
                            <small class="text-muted">Users</small>
                        </div>
                        <div class="col">
                            <h5 class="fw-bold text-info mb-0">{{ $role->permissions->count() }}</h5>
                            <small class="text-muted">Permissions</small>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Created Date</label>
                        <div>{{ $role->created_at->format('F j, Y \a\t g:i A') }}</div>
                        <small class="text-muted">{{ $role->created_at->diffForHumans() }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Last Updated</label>
                        <div>{{ $role->updated_at->format('F j, Y \a\t g:i A') }}</div>
                        <small class="text-muted">{{ $role->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    @can('roles.edit')
                    @if($role->name !== 'admin' || auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-pencil me-2"></i>Edit Permissions
                    </a>
                    @endif
                    @endcan
                    
                    <a href="{{ route('admin.permissions.index') }}?group={{ explode('.', $role->permissions->first()->name ?? 'users.view')[0] }}" 
                       class="btn btn-outline-info w-100 mb-2">
                        <i class="bi bi-key me-2"></i>View All Permissions
                    </a>
                    
                    @can('users.view')
                    <a href="{{ route('admin.users.index') }}?role={{ $role->name }}" 
                       class="btn btn-outline-success w-100 mb-2">
                        <i class="bi bi-people me-2"></i>View Assigned Users
                    </a>
                    @endcan
                    
                    @can('roles.delete')
                    @if($role->name !== 'admin' && $role->users->count() === 0)
                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i>Delete Role
                        </button>
                    </form>
                    @endif
                    @endcan
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs" id="roleDetailTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="permissions-tab" data-bs-toggle="tab" 
                            data-bs-target="#permissions" type="button" role="tab">
                        <i class="bi bi-key me-2"></i>Permissions <span class="badge bg-info ms-1">{{ $role->permissions->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="users-tab" data-bs-toggle="tab" 
                            data-bs-target="#users" type="button" role="tab">
                        <i class="bi bi-people me-2"></i>Assigned Users <span class="badge bg-success ms-1">{{ $role->users->count() }}</span>
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="roleDetailTabsContent">
                <!-- Permissions Tab -->
                <div class="tab-pane fade show active" id="permissions" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Role Permissions</h5>
                        </div>
                        <div class="card-body">
                            @if($role->permissions->count() > 0)
                            @php
                                $groupedPermissions = $role->permissions->groupBy(function($permission) {
                                    return explode('.', $permission->name)[0];
                                });
                            @endphp
                            
                            <div class="permission-groups">
                                @foreach($groupedPermissions as $group => $permissions)
                                <div class="permission-group mb-4">
                                    <div class="group-header mb-3">
                                        <h6 class="fw-bold text-capitalize mb-2">
                                            <i class="bi bi-{{ $this->getGroupIcon($group) }} me-2"></i>
                                            {{ str_replace('-', ' ', $group) }} Management
                                            <span class="badge bg-primary ms-2">{{ $permissions->count() }} permissions</span>
                                        </h6>
                                    </div>
                                    
                                    <div class="row">
                                        @foreach($permissions as $permission)
                                        <div class="col-md-6 col-lg-4 mb-2">
                                            <div class="d-flex align-items-center p-2 border rounded">
                                                <i class="bi bi-check-circle text-success me-2"></i>
                                                <span class="fw-medium">
                                                    {{ ucfirst(str_replace(['.', '-'], [' ', ' '], explode('.', $permission->name)[1] ?? $permission->name)) }}
                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-key display-4 text-muted"></i>
                                <h5 class="mt-3">No Permissions Assigned</h5>
                                <p class="text-muted">This role doesn't have any permissions assigned yet.</p>
                                @can('roles.edit')
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Assign Permissions
                                </a>
                                @endcan
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Users Tab -->
                <div class="tab-pane fade" id="users" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Users with this Role</h5>
                        </div>
                        <div class="card-body">
                            @if($role->users->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Assigned Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($role->users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm rounded-circle me-3">
                                                        @if($user->hasMedia('avatar'))
                                                        <img src="{{ $user->getFirstMediaUrl('avatar') }}" 
                                                             alt="{{ $user->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                                        @else
                                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                             style="width: 32px; height: 32px;">
                                                            {{ substr($user->name, 0, 1) }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                                        <small class="text-muted">ID: #{{ $user->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $user->email }}</span>
                                                @if($user->email_verified_at)
                                                <i class="bi bi-patch-check text-success ms-1" title="Verified"></i>
                                                @else
                                                <i class="bi bi-exclamation-triangle text-warning ms-1" title="Unverified"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->deleted_at)
                                                <span class="badge bg-danger">Inactive</span>
                                                @else
                                                <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $user->created_at->format('M j, Y') }}</span>
                                                <br>
                                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td class="text-center">
                                                @can('users.view')
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @endcan
                                                
                                                @can('roles.assign')
                                                @if($role->name !== 'admin' || auth()->user()->hasRole('admin'))
                                                <button class="btn btn-sm btn-outline-danger ms-1" 
                                                        onclick="removeUserRole({{ $user->id }}, '{{ $role->name }}')">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                                @endif
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-people display-4 text-muted"></i>
                                <h5 class="mt-3">No Users Assigned</h5>
                                <p class="text-muted">No users are currently assigned to this role.</p>
                                @can('users.view')
                                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Assign Users
                                </a>
                                @endcan
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.avatar {
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-lg {
    width: 80px;
    height: 80px;
}

.avatar-sm {
    width: 32px;
    height: 32px;
}

.permission-group {
    border: 1px solid #e9ecef;
    border-radius: 0.375rem;
    padding: 1rem;
    background: #f8f9fa;
}

.group-header {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 0.75rem;
}

.nav-tabs .nav-link {
    color: #6c757d;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    border-color: #0d6efd #0d6efd #fff;
}
</style>
@endpush

@push('scripts')
<script>
// Remove user from role
function removeUserRole(userId, roleName) {
    Swal.fire({
        title: 'Remove User Role?',
        text: `Are you sure you want to remove the "${roleName}" role from this user?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Make AJAX request to remove role
            fetch(`{{ route('admin.roles.remove-user', $role) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    user_id: userId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
            });
        }
    });
}

// Delete role confirmation
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'This role will be permanently deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
@endsection

@php
function getGroupIcon($group) {
    $icons = [
        'users' => 'people',
        'roles' => 'shield',
        'permissions' => 'key',
        'donations' => 'heart',
        'projects' => 'folder',
        'categories' => 'tags',
        'payments' => 'credit-card',
        'beneficiaries' => 'person-check',
        'settings' => 'gear',
        'audit-logs' => 'journal',
        'statistics' => 'bar-chart',
        'reports' => 'file-text',
        'pages' => 'file-text'
    ];
    
    return $icons[$group] ?? 'circle';
}
@endphp