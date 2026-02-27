<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use App\Models\User;
use App\Models\Role;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::with('role')
            ->whereHas('role', function ($query) {
                $query->whereNotIn('name', ['super_admin']);
            });

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role !== 'all') {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filter by status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true);
                    break;
                case 'suspended':
                    $query->where('is_suspended', true);
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
            }
        }

        $users = $query->orderBy('id', 'asc')->paginate(20);
        $roles = Role::whereNotIn('name', ['super_admin'])->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::whereNotIn('name', ['super_admin'])->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::whereNotIn('name', ['super_admin'])->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->hasRole('super_admin')) {
            return back()->with('error', 'Cannot delete super admin users.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['role', 'chatSessions.chats']);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Update user role.
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $role = Role::find($request->role_id);
        
        if (!$role) {
            return back()->with('error', 'Role not found.');
        }

        $this->roleService->assignRole($user, $role->name);

        return back()->with('success', "User role updated to {$role->display_name}.");
    }

    /**
     * Suspend user account.
     */
    public function suspend(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
            'duration' => 'nullable|in:1_hour,6_hours,1_day,1_week,1_month,permanent',
        ]);

        $until = null;
        $durationText = '';

        if ($request->duration && $request->duration !== 'permanent') {
            switch ($request->duration) {
                case '1_hour':
                    $until = now()->addHour();
                    $durationText = '1 hour';
                    break;
                case '6_hours':
                    $until = now()->addHours(6);
                    $durationText = '6 hours';
                    break;
                case '1_day':
                    $until = now()->addDay();
                    $durationText = '1 day';
                    break;
                case '1_week':
                    $until = now()->addWeek();
                    $durationText = '1 week';
                    break;
                case '1_month':
                    $until = now()->addMonth();
                    $durationText = '1 month';
                    break;
            }
        }

        $this->roleService->suspendUser($user, $request->reason, $until);

        $message = $until 
            ? "User suspended for {$durationText}" 
            : "User suspended permanently";

        return back()->with('success', $message);
    }

    /**
     * Activate user account.
     */
    public function activate(User $user)
    {
        $this->roleService->activateUser($user);

        return back()->with('success', 'User account activated.');
    }

    /**
     * View user usage statistics.
     */
    public function viewUsage(User $user)
    {
        $chatCount = $user->chatSessions()->count();
        $messageCount = Chat::where('user_id', $user->id)->count();
        $lastActivity = $user->chatSessions()->latest()->first()?->last_message_at;

        return view('admin.users.usage', compact('user', 'chatCount', 'messageCount', 'lastActivity'));
    }

    /**
     * Display admin users.
     */
    public function adminIndex(Request $request)
    {
        $admins = User::with('role')
            ->whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'super_admin']);
            })
            ->latest()
            ->paginate(20);

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Create admin user.
     */
    public function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,super_admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('admin123'), // Default password for admin
            'role_id' => Role::where('name', $request->role)->first()->id,
        ]);

        return back()->with('success', 'Admin user created successfully.');
    }

    /**
     * Delete admin user.
     */
    public function deleteAdmin(User $user)
    {
        if ($user->hasRole('super_admin')) {
            return back()->with('error', 'Cannot delete super admin users.');
        }

        $user->delete();

        return back()->with('success', 'Admin user deleted successfully.');
    }

    /**
     * Display roles management.
     */
    public function rolesIndex()
    {
        $roles = Role::with('permissions')->get();
        $permissions = \App\Models\Permission::all();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Create role.
     */
    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'display_name' => 'required|string',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = $this->roleService->createRole([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Update role.
     */
    public function updateRolePermissions(Request $request, Role $role)
    {
        $request->validate([
            'display_name' => 'required|string',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = $this->roleService->updateRole($role, [
            'display_name' => $request->display_name,
            'description' => $request->description,
            'permissions' => $request->permissions ?? [],
        ]);

        return back()->with('success', 'Role updated successfully.');
    }

    /**
     * Delete role.
     */
    public function deleteRole(Role $role)
    {
        try {
            $this->roleService->deleteRole($role);
            return back()->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display assign roles form.
     */
    public function assignRoles()
    {
        $users = User::with('role')
            ->whereHas('role', function ($query) {
                $query->whereNotIn('name', ['super_admin']);
            })
            ->get();
        
        $roles = Role::whereNotIn('name', ['super_admin'])->get();

        return view('admin.roles.assign', compact('users', 'roles'));
    }

    /**
     * Process assign roles form.
     */
    public function processAssignRoles(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);

        if (!$user || !$role) {
            return back()->with('error', 'User or role not found.');
        }

        if ($role->name === 'super_admin') {
            return back()->with('error', 'Cannot assign super admin role through this form.');
        }

        $this->roleService->assignRole($user, $role->name);

        return back()->with('success', "Role {$role->display_name} assigned to {$user->name} successfully.");
    }
}
