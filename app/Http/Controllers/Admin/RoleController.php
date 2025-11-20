<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->can('roles.view')) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of roles.
     */
    public function index(Request $request)
    {
        $query = Role::withCount('users', 'permissions');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $roles = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        if (!auth()->user()->can('roles.create')) {
            abort(403, 'Unauthorized');
        }

        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('roles.create')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name', 'regex:/^[a-zA-Z0-9_-]+$/'],
            'display_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        // Assign permissions if provided
        if ($request->permissions) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', "Role '{$role->name}' has been created successfully.");
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        $role->load('permissions', 'users');
        
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        if (!auth()->user()->can('roles.edit')) {
            abort(403, 'Unauthorized');
        }

        // Prevent editing the admin role if not admin
        if ($role->name === 'admin' && !auth()->user()->hasRole('admin')) {
            abort(403, 'You cannot edit the admin role');
        }

        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });

        $role->load('permissions');

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        if (!auth()->user()->can('roles.edit')) {
            abort(403, 'Unauthorized');
        }

        // Prevent editing the admin role if not admin
        if ($role->name === 'admin' && !auth()->user()->hasRole('admin')) {
            abort(403, 'You cannot edit the admin role');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id), 'regex:/^[a-zA-Z0-9_-]+$/'],
            'display_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        // Update permissions
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', "Role '{$role->name}' has been updated successfully.");
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        if (!auth()->user()->can('roles.delete')) {
            abort(403, 'Unauthorized');
        }

        // Prevent deleting the admin role
        if ($role->name === 'admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'The admin role cannot be deleted.');
        }

        // Check if role has users
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', "Cannot delete role '{$role->name}' because it has assigned users. Please reassign users first.");
        }

        $roleName = $role->name;
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', "Role '{$roleName}' has been deleted successfully.");
    }

    /**
     * Assign role to user
     */
    public function assignToUser(Request $request, Role $role)
    {
        if (!auth()->user()->can('roles.assign')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);
        $user->assignRole($role);

        return response()->json([
            'success' => true,
            'message' => "Role '{$role->name}' has been assigned to {$user->name}."
        ]);
    }

    /**
     * Remove role from user
     */
    public function removeFromUser(Request $request, Role $role)
    {
        if (!auth()->user()->can('roles.assign')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);
        $user->removeRole($role);

        return response()->json([
            'success' => true,
            'message' => "Role '{$role->name}' has been removed from {$user->name}."
        ]);
    }
}