@extends('admin.layouts.app')

@section('title', 'Permission Details - ' . $permission->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Permission Details</h1>
                    <p class="text-muted mb-0">View permission assignments and manage access</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Permissions
                    </a>
                    @can('permissions.assign')
                    <button class="btn btn-success" onclick="showAssignRoleModal()">
                        <i class="bi bi-plus-circle me-2"></i>Assign to Role
                    </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Permission Information -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-key me-2"></i>Permission Information
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $parts = explode('.', $permission->name);
                        $group = $parts[0];
                        $action = $parts[1] ?? '';
                    @endphp
                    
                    <div class="text-center mb-4">
                        <div class="avatar avatar-lg bg-primary text-white rounded-circle mx-auto mb-3">
                            <i class="bi bi-{{ $this->getPermissionIcon($action) }} fs-3"></i>
                        </div>
                        <h4 class="fw-bold">{{ $permission->name }}</h4>
                        <span class="badge bg-secondary mb-2">
                            <i class="bi bi-{{ $this->getGroupIcon($group) }} me-1"></i>
                            {{ ucfirst(str_replace('-', ' ', $group)) }} Group
                        </span>
                    </div>

                    <div class="row text-center mb-3">
                        <div class="col">
                            <h5 class="fw-bold text-info mb-0">{{ $permission->roles->count() }}</h5>
                            <small class="text-muted">Roles</small>
                        </div>
                        <div class="col">
                            <h5 class="fw-bold text-warning mb-0">{{ $permission->users->count() }}</h5>
                            <small class="text-muted">Direct Users</small>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Permission Type</label>
                        <div>{{ ucfirst(str_replace(['.', '-'], [' ', ' '], $action)) }}</div>
                        <small class="text-muted">{{ $this->getActionDescription($action) }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Guard Name</label>
                        <div>{{ $permission->guard_name }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Created Date</label>
                        <div>{{ $permission->created_at->format('F j, Y \a\t g:i A') }}</div>
                        <small class="text-muted">{{ $permission->created_at->diffForHumans() }}</small>
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
                    @can('permissions.assign')
                    <button class="btn btn-outline-primary w-100 mb-2" onclick="showAssignRoleModal()">
                        <i class="bi bi-shield-plus me-2"></i>Assign to Role
                    </button>
                    
                    <button class="btn btn-outline-warning w-100 mb-2" onclick="showAssignUserModal()">
                        <i class="bi bi-person-plus me-2"></i>Assign to User
                    </button>
                    @endcan
                    
                    <a href="{{ route('admin.permissions.index', ['group' => $group]) }}" 
                       class="btn btn-outline-info w-100 mb-2">
                        <i class="bi bi-collection me-2"></i>View Group Permissions
                    </a>
                    
                    <a href="{{ route('admin.roles.index') }}" 
                       class="btn btn-outline-success w-100">
                        <i class="bi bi-shield me-2"></i>Manage Roles
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs" id="permissionDetailTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="roles-tab" data-bs-toggle="tab" 
                            data-bs-target="#roles" type="button" role="tab">
                        <i class="bi bi-shield me-2"></i>Assigned Roles <span class="badge bg-info ms-1">{{ $permission->roles->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="direct-users-tab" data-bs-toggle="tab" 
                            data-bs-target="#direct-users" type="button" role="tab">
                        <i class="bi bi-person me-2"></i>Direct Users <span class="badge bg-warning ms-1">{{ $permission->users->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="all-users-tab" data-bs-toggle="tab" 
                            data-bs-target="#all-users" type="button" role="tab">
                        <i class="bi bi-people me-2"></i>All Users with Access
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="permissionDetailTabsContent">
                <!-- Roles Tab -->
                <div class="tab-pane fade show active" id="roles" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Roles with this Permission</h5>
                        </div>
                        <div class="card-body">
                            @if($permission->roles->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Users Count</th>
                                            <th>Total Permissions</th>
                                            <th>Assigned Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permission->roles as $role)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-primary text-white rounded-circle me-3">
                                                        <i class="bi bi-shield{{ $role->name === 'admin' ? '-check' : '' }}"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ ucfirst($role->name) }}</h6>
                                                        @if($role->name === 'admin')
                                                        <span class="badge bg-danger small">System Role</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $role->users->count() }}</span>
                                                <small class="text-muted">users</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $role->permissions->count() }} permissions</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $role->created_at->format('M j, Y') }}</span>
                                                <br>
                                                <small class="text-muted">{{ $role->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.roles.show', $role) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                @can('permissions.assign')
                                                @if($role->name !== 'admin' || auth()->user()->hasRole('admin'))
                                                <button class="btn btn-sm btn-outline-danger ms-1" 
                                                        onclick="removeFromRole({{ $role->id }}, '{{ $role->name }}')">
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
                                <i class="bi bi-shield display-4 text-muted"></i>
                                <h5 class="mt-3">No Roles Assigned</h5>
                                <p class="text-muted">This permission is not assigned to any roles yet.</p>
                                @can('permissions.assign')
                                <button class="btn btn-primary" onclick="showAssignRoleModal()">
                                    <i class="bi bi-plus-circle me-2"></i>Assign to Role
                                </button>
                                @endcan
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Direct Users Tab -->
                <div class="tab-pane fade" id="direct-users" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Users with Direct Permission Assignment</h5>
                        </div>
                        <div class="card-body">
                            @if($permission->users->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permission->users as $user)
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
                                                @if($user->roles->count() > 0)
                                                @foreach($user->roles as $userRole)
                                                <span class="badge bg-secondary me-1">{{ $userRole->name }}</span>
                                                @endforeach
                                                @else
                                                <span class="text-muted">No roles</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->deleted_at)
                                                <span class="badge bg-danger">Inactive</span>
                                                @else
                                                <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @can('users.view')
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @endcan
                                                
                                                @can('permissions.assign')
                                                <button class="btn btn-sm btn-outline-danger ms-1" 
                                                        onclick="removeFromUser({{ $user->id }}, '{{ $user->name }}')">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-person display-4 text-muted"></i>
                                <h5 class="mt-3">No Direct User Assignments</h5>
                                <p class="text-muted">This permission is not directly assigned to any users.</p>
                                @can('permissions.assign')
                                <button class="btn btn-warning" onclick="showAssignUserModal()">
                                    <i class="bi bi-person-plus me-2"></i>Assign to User
                                </button>
                                @endcan
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- All Users Tab -->
                <div class="tab-pane fade" id="all-users" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">All Users with Access to this Permission</h5>
                        </div>
                        <div class="card-body">
                            @php
                                // Get all users who have this permission either directly or through roles
                                $allUsersWithPermission = collect();
                                
                                // Users with direct permission
                                foreach($permission->users as $user) {
                                    $allUsersWithPermission->push([
                                        'user' => $user,
                                        'source' => 'Direct Assignment',
                                        'type' => 'direct'
                                    ]);
                                }
                                
                                // Users with permission through roles
                                foreach($permission->roles as $role) {
                                    foreach($role->users as $user) {
                                        // Avoid duplicates
                                        if (!$allUsersWithPermission->pluck('user.id')->contains($user->id)) {
                                            $allUsersWithPermission->push([
                                                'user' => $user,
                                                'source' => 'Role: ' . ucfirst($role->name),
                                                'type' => 'role'
                                            ]);
                                        }
                                    }
                                }
                                
                                $allUsersWithPermission = $allUsersWithPermission->sortBy('user.name');
                            @endphp
                            
                            @if($allUsersWithPermission->count() > 0)
                            <div class="alert alert-info mb-3">
                                <i class="bi bi-info-circle me-2"></i>
                                This shows all users who have access to this permission, either directly or through role assignments.
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Access Source</th>
                                            <th>Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allUsersWithPermission as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm rounded-circle me-3">
                                                        @if($item['user']->hasMedia('avatar'))
                                                        <img src="{{ $item['user']->getFirstMediaUrl('avatar') }}" 
                                                             alt="{{ $item['user']->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                                        @else
                                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                             style="width: 32px; height: 32px;">
                                                            {{ substr($item['user']->name, 0, 1) }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $item['user']->name }}</h6>
                                                        <small class="text-muted">ID: #{{ $item['user']->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $item['user']->email }}</span>
                                                @if($item['user']->email_verified_at)
                                                <i class="bi bi-patch-check text-success ms-1" title="Verified"></i>
                                                @else
                                                <i class="bi bi-exclamation-triangle text-warning ms-1" title="Unverified"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item['type'] === 'direct')
                                                <span class="badge bg-warning">{{ $item['source'] }}</span>
                                                @else
                                                <span class="badge bg-info">{{ $item['source'] }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item['user']->deleted_at)
                                                <span class="badge bg-danger">Inactive</span>
                                                @else
                                                <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @can('users.view')
                                                <a href="{{ route('admin.users.show', $item['user']) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
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
                                <h5 class="mt-3">No Users Have Access</h5>
                                <p class="text-muted">This permission is not assigned to any users or roles.</p>
                                @can('permissions.assign')
                                <div class="d-flex gap-2 justify-content-center">
                                    <button class="btn btn-primary" onclick="showAssignRoleModal()">
                                        <i class="bi bi-shield-plus me-2"></i>Assign to Role
                                    </button>
                                    <button class="btn btn-warning" onclick="showAssignUserModal()">
                                        <i class="bi bi-person-plus me-2"></i>Assign to User
                                    </button>
                                </div>
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

<!-- Assign to Role Modal -->
@can('permissions.assign')
<div class="modal fade" id="assignRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Permission to Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="assignRoleForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Permission</label>
                        <input type="text" class="form-control" value="{{ $permission->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Role</label>
                        <select class="form-select" id="assignRoleSelect" required>
                            <option value="">Choose a role...</option>
                            @foreach(\Spatie\Permission\Models\Role::whereNotIn('id', $permission->roles->pluck('id'))->get() as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Assign Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assign to User Modal -->
<div class="modal fade" id="assignUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Permission to User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="assignUserForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Permission</label>
                        <input type="text" class="form-control" value="{{ $permission->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select User</label>
                        <select class="form-select" id="assignUserSelect" required>
                            <option value="">Choose a user...</option>
                            @foreach(\App\Models\User::whereNotIn('id', $permission->users->pluck('id'))->select('id', 'name', 'email')->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Assign Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan

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
// Show assign modals
function showAssignRoleModal() {
    document.getElementById('assignRoleSelect').value = '';
    new bootstrap.Modal(document.getElementById('assignRoleModal')).show();
}

function showAssignUserModal() {
    document.getElementById('assignUserSelect').value = '';
    new bootstrap.Modal(document.getElementById('assignUserModal')).show();
}

// Remove permission from role
function removeFromRole(roleId, roleName) {
    Swal.fire({
        title: 'Remove Permission?',
        text: `Remove this permission from the "${roleName}" role?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route('admin.permissions.sync-role') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    permission_id: {{ $permission->id }},
                    role_id: roleId,
                    action: 'remove'
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
            });
        }
    });
}

// Remove permission from user
function removeFromUser(userId, userName) {
    Swal.fire({
        title: 'Remove Permission?',
        text: `Remove this permission from "${userName}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route('admin.permissions.remove-user') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    permission_id: {{ $permission->id }},
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
            });
        }
    });
}

// Handle assignment forms
document.getElementById('assignRoleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const roleId = document.getElementById('assignRoleSelect').value;
    
    fetch('{{ route('admin.permissions.sync-role') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            permission_id: {{ $permission->id }},
            role_id: roleId,
            action: 'assign'
        })
    })
    .then(response => response.json())
    .then(data => {
        bootstrap.Modal.getInstance(document.getElementById('assignRoleModal')).hide();
        if (data.success) {
            Swal.fire('Success!', data.message, 'success').then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    });
});

document.getElementById('assignUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const userId = document.getElementById('assignUserSelect').value;
    
    fetch('{{ route('admin.permissions.assign-user') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            permission_id: {{ $permission->id }},
            user_id: userId
        })
    })
    .then(response => response.json())
    .then(data => {
        bootstrap.Modal.getInstance(document.getElementById('assignUserModal')).hide();
        if (data.success) {
            Swal.fire('Success!', data.message, 'success').then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
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

function getPermissionIcon($action) {
    $icons = [
        'view' => 'eye',
        'create' => 'plus-circle',
        'edit' => 'pencil',
        'delete' => 'trash',
        'restore' => 'arrow-clockwise',
        'force-delete' => 'x-octagon',
        'impersonate' => 'person-check',
        'assign' => 'link',
        'approve' => 'check-circle',
        'export' => 'download',
        'publish' => 'globe',
        'unpublish' => 'eye-slash',
        'refund' => 'arrow-left-circle',
        'change-password' => 'key'
    ];
    
    return $icons[$action] ?? 'gear';
}

function getActionDescription($action) {
    $descriptions = [
        'view' => 'Allows viewing/reading access',
        'create' => 'Allows creating new records',
        'edit' => 'Allows editing existing records',
        'delete' => 'Allows deleting records',
        'restore' => 'Allows restoring soft-deleted records',
        'force-delete' => 'Allows permanent deletion',
        'impersonate' => 'Allows impersonating other users',
        'assign' => 'Allows assigning roles/permissions',
        'approve' => 'Allows approving/rejecting items',
        'export' => 'Allows exporting data',
        'publish' => 'Allows publishing content',
        'unpublish' => 'Allows unpublishing content',
        'refund' => 'Allows processing refunds',
        'change-password' => 'Allows changing passwords'
    ];
    
    return $descriptions[$action] ?? 'System permission';
}
@endphp