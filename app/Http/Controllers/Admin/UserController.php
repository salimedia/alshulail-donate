<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->hasRole('admin')) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = User::with('roles');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->has('role') && $request->role) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Status filter
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->whereNull('deleted_at');
            } elseif ($request->status === 'inactive') {
                $query->onlyTrashed();
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,name'],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female'],
            'country' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'preferred_language' => ['nullable', 'in:ar,en'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'country' => $request->country,
            'city' => $request->city,
            'preferred_language' => $request->preferred_language ?? 'en',
            'email_verified_at' => now(),
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')
                  ->toMediaCollection('avatars');
        }

        // Assign roles
        $user->assignRole($request->roles);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.user_created_successfully'));
    }

    public function show(User $user)
    {
        $user->load('roles', 'permissions');
        $user->avatar = $user->getFirstMediaUrl('avatars');
        
        // Get user's activity statistics
        $stats = [
            'total_donations' => 0, // You can implement this based on your donations table
            'total_projects' => 0, // If users can create projects
            'last_login' => $user->last_login_at ?? $user->updated_at,
            'account_created' => $user->created_at,
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $user->avatar = $user->getFirstMediaUrl('avatars');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,name'],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female'],
            'country' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'preferred_language' => ['nullable', 'in:ar,en'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'country' => $request->country,
            'city' => $request->city,
            'preferred_language' => $request->preferred_language,
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $user->clearMediaCollection('avatars');
            $user->addMediaFromRequest('avatar')
                  ->toMediaCollection('avatars');
        }

        // Update roles
        $user->syncRoles($request->roles);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.user_updated_successfully'));
    }

    public function changePassword(User $user)
    {
        return view('admin.users.change-password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', __('messages.password_updated_successfully'));
    }

    public function destroy(User $user)
    {
        // Prevent deletion of the last admin
        $adminUsers = User::role('admin')->count();
        if ($user->hasRole('admin') && $adminUsers <= 1) {
            return redirect()
                ->back()
                ->with('error', __('messages.cannot_delete_last_admin'));
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.user_deleted_successfully'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.user_restored_successfully'));
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        
        // Clear media
        $user->clearMediaCollection('avatars');
        
        $user->forceDelete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.user_permanently_deleted'));
    }

    public function toggleStatus(User $user)
    {
        if ($user->trashed()) {
            $user->restore();
            $message = __('messages.user_activated_successfully');
            $status = 'active';
        } else {
            $user->delete();
            $message = __('messages.user_deactivated_successfully');
            $status = 'inactive';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'status' => $status
        ]);
    }

    public function impersonate(User $user)
    {
        if ($user->hasRole('admin') && !auth()->user()->hasRole('super-admin')) {
            return redirect()
                ->back()
                ->with('error', __('messages.cannot_impersonate_admin'));
        }

        session(['impersonate_user_id' => auth()->id()]);
        auth()->login($user);

        return redirect()
            ->route('home')
            ->with('success', __('messages.impersonating_user', ['name' => $user->name]));
    }

    public function stopImpersonating()
    {
        if (!session('impersonate_user_id')) {
            return redirect()->route('home');
        }

        $originalUserId = session('impersonate_user_id');
        session()->forget('impersonate_user_id');
        
        auth()->loginUsingId($originalUserId);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.stopped_impersonating'));
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);

        return response()->json([
            'success' => true,
            'message' => __('messages.role_assigned_successfully'),
        ]);
    }
}