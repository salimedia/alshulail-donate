@extends('admin.layouts.app')

@section('title', 'Create Role')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Create New Role</h1>
                    <p class="text-muted mb-0">Define a new role with specific permissions</p>
                </div>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Roles
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.roles.store') }}" method="POST" id="createRoleForm">
        @csrf
        <div class="row">
            <!-- Role Information -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-info-circle me-2"></i>Role Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="e.g., editor" required>
                            <div class="form-text">Use lowercase letters, numbers, and hyphens only.</div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="display_name" class="form-label">Display Name</label>
                            <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                   id="display_name" name="display_name" value="{{ old('display_name') }}" 
                                   placeholder="e.g., Content Editor">
                            <div class="form-text">Human-readable name for this role.</div>
                            @error('display_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Brief description of this role's purpose...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role Preview -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="fw-bold mb-2">Role Preview</h6>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm bg-primary text-white rounded-circle me-3">
                                    <i class="bi bi-shield"></i>
                                </div>
                                <div>
                                    <div class="fw-medium" id="preview-name">New Role</div>
                                    <small class="text-muted" id="preview-description">Role description will appear here</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-key me-2"></i>Permissions
                            </h5>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-success" id="selectAll">
                                    <i class="bi bi-check-all me-1"></i>Select All
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-warning" id="deselectAll">
                                    <i class="bi bi-x-circle me-1"></i>Deselect All
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="permission-groups">
                            @foreach($permissions as $group => $groupPermissions)
                            <div class="permission-group mb-4">
                                <div class="group-header mb-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input group-toggle" type="checkbox" 
                                                       id="group-{{ $group }}" data-group="{{ $group }}">
                                                <label class="form-check-label fw-bold text-capitalize" for="group-{{ $group }}">
                                                    <i class="bi bi-{{ $this->getGroupIcon($group) }} me-2"></i>
                                                    {{ str_replace('-', ' ', $group) }} Management
                                                </label>
                                            </div>
                                        </div>
                                        <span class="badge bg-secondary permission-count-{{ $group }}">
                                            0 of {{ $groupPermissions->count() }} selected
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="row permission-items ms-4">
                                    @foreach($groupPermissions as $permission)
                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox" 
                                                   type="checkbox" name="permissions[]" 
                                                   value="{{ $permission->id }}" 
                                                   id="permission-{{ $permission->id }}"
                                                   data-group="{{ $group }}">
                                            <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                {{ ucfirst(str_replace(['.', '-'], [' ', ' '], explode('.', $permission->name)[1] ?? $permission->name)) }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                <span id="selected-count">0</span> permissions selected
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-secondary me-2" onclick="history.back()">
                                    <i class="bi bi-x-circle me-1"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i>Create Role
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
.avatar {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
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

.permission-items {
    margin-top: 0.75rem;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.group-toggle:checked ~ label {
    color: #0d6efd;
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const displayNameInput = document.getElementById('display_name');
    const descriptionInput = document.getElementById('description');
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    
    // Update preview
    function updatePreview() {
        previewName.textContent = displayNameInput.value || nameInput.value || 'New Role';
        previewDescription.textContent = descriptionInput.value || 'Role description will appear here';
    }
    
    nameInput.addEventListener('input', updatePreview);
    displayNameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    
    // Permission management
    const selectAllBtn = document.getElementById('selectAll');
    const deselectAllBtn = document.getElementById('deselectAll');
    const selectedCountElement = document.getElementById('selected-count');
    
    function updatePermissionCounts() {
        const allCheckboxes = document.querySelectorAll('.permission-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.permission-checkbox:checked');
        
        selectedCountElement.textContent = checkedCheckboxes.length;
        
        // Update group counts
        document.querySelectorAll('.group-toggle').forEach(groupToggle => {
            const group = groupToggle.dataset.group;
            const groupCheckboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
            const checkedGroupCheckboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]:checked`);
            
            const countElement = document.querySelector(`.permission-count-${group}`);
            countElement.textContent = `${checkedGroupCheckboxes.length} of ${groupCheckboxes.length} selected`;
            
            // Update group toggle state
            if (checkedGroupCheckboxes.length === 0) {
                groupToggle.indeterminate = false;
                groupToggle.checked = false;
            } else if (checkedGroupCheckboxes.length === groupCheckboxes.length) {
                groupToggle.indeterminate = false;
                groupToggle.checked = true;
            } else {
                groupToggle.indeterminate = true;
            }
        });
    }
    
    // Group toggle functionality
    document.querySelectorAll('.group-toggle').forEach(groupToggle => {
        groupToggle.addEventListener('change', function() {
            const group = this.dataset.group;
            const groupCheckboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
            
            groupCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            
            updatePermissionCounts();
        });
    });
    
    // Individual permission checkboxes
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updatePermissionCounts);
    });
    
    // Select/Deselect all buttons
    selectAllBtn.addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = true;
        });
        updatePermissionCounts();
    });
    
    deselectAllBtn.addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
        updatePermissionCounts();
    });
    
    // Initial count update
    updatePermissionCounts();
    updatePreview();
});

// Helper function for group icons
function getGroupIcon(group) {
    const icons = {
        'users': 'people',
        'roles': 'shield',
        'permissions': 'key',
        'donations': 'heart',
        'projects': 'folder',
        'categories': 'tags',
        'payments': 'credit-card',
        'beneficiaries': 'person-check',
        'settings': 'gear',
        'audit-logs': 'journal',
        'statistics': 'bar-chart',
        'reports': 'file-text',
        'pages': 'file-text'
    };
    
    return icons[group] || 'circle';
}
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