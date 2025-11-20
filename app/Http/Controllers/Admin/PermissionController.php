<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->can('permissions.view')) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of permissions.
     */
    public function index(Request $request)
    {
        $query = Permission::withCount('roles', 'users');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Group filter
        if ($request->has('group') && $request->group) {
            $query->where('name', 'like', $request->group . '.%');
        }

        $permissions = $query->orderBy('name')->paginate(20);
        
        // Get unique groups for filter
        $groups = Permission::select('name')
            ->get()
            ->map(function($permission) {
                return explode('.', $permission->name)[0];
            })
            ->unique()
            ->sort()
            ->values();

        return view('admin.permissions.index', compact('permissions', 'groups'));
    }

    /**
     * Display the specified permission.
     */
    public function show(Permission $permission)
    {
        $permission->load('roles.users');
        
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Sync permissions with roles via AJAX
     */
    public function syncWithRole(Request $request)
    {
        if (!auth()->user()->can('permissions.assign')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'permission_id' => ['required', 'exists:permissions,id'],
            'action' => ['required', 'in:assign,remove'],
        ]);

        $role = Role::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);

        if ($request->action === 'assign') {
            $role->givePermissionTo($permission);
            $message = "Permission '{$permission->name}' assigned to role '{$role->name}'.";
        } else {
            $role->revokePermissionTo($permission);
            $message = "Permission '{$permission->name}' removed from role '{$role->name}'.";
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Assign permission directly to user
     */
    public function assignToUser(Request $request)
    {
        if (!auth()->user()->can('permissions.assign')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'permission_id' => ['required', 'exists:permissions,id'],
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);
        $permission = Permission::findOrFail($request->permission_id);

        $user->givePermissionTo($permission);

        return response()->json([
            'success' => true,
            'message' => "Permission '{$permission->name}' assigned to {$user->name}."
        ]);
    }

    /**
     * Remove permission directly from user
     */
    public function removeFromUser(Request $request)
    {
        if (!auth()->user()->can('permissions.assign')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'permission_id' => ['required', 'exists:permissions,id'],
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);
        $permission = Permission::findOrFail($request->permission_id);

        $user->revokePermissionTo($permission);

        return response()->json([
            'success' => true,
            'message' => "Permission '{$permission->name}' removed from {$user->name}."
        ]);
    }
}