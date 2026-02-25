<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleService
{
    /**
     * Get all roles with their permissions.
     */
    public function getAllRoles()
    {
        return Role::with('permissions')->get();
    }

    /**
     * Get all permissions.
     */
    public function getAllPermissions()
    {
        return Permission::all();
    }

    /**
     * Create a new role.
     */
    public function createRole(array $data)
    {
        return DB::transaction(function () use ($data) {
            $role = Role::create([
                'name' => $data['name'],
                'display_name' => $data['display_name'] ?? ucfirst(str_replace('_', ' ', $data['name'])),
                'description' => $data['description'] ?? null,
                'is_system_role' => $data['is_system_role'] ?? false,
            ]);

            if (isset($data['permissions'])) {
                $role->syncPermissions($data['permissions']);
            }

            return $role;
        });
    }

    /**
     * Update a role.
     */
    public function updateRole(Role $role, array $data)
    {
        return DB::transaction(function () use ($role, $data) {
            // Prevent modification of system roles
            if ($role->is_system_role && isset($data['name'])) {
                unset($data['name']);
            }

            $role->update([
                'display_name' => $data['display_name'] ?? $role->display_name,
                'description' => $data['description'] ?? $role->description,
            ]);

            if (isset($data['permissions'])) {
                $role->syncPermissions($data['permissions']);
            }

            return $role->fresh('permissions');
        });
    }

    /**
     * Delete a role.
     */
    public function deleteRole(Role $role)
    {
        if ($role->is_system_role) {
            throw new \Exception('Cannot delete system roles.');
        }

        if ($role->users()->count() > 0) {
            throw new \Exception('Cannot delete role with assigned users. Reassign users first.');
        }

        return $role->delete();
    }

    /**
     * Assign role to user.
     */
    public function assignRole(User $user, string $roleName)
    {
        $role = Role::where('name', $roleName)->first();
        
        if (!$role) {
            throw new \Exception('Role not found.');
        }

        // Handle subscription status based on role
        $subscriptionData = [];
        if ($roleName === 'premium_user') {
            $subscriptionData = [
                'subscription_status' => 'premium',
                'subscription_ends_at' => now()->addYear(),
                'subscription_plan' => 'premium',
            ];
        } elseif ($roleName === 'normal_user') {
            $subscriptionData = [
                'subscription_status' => 'free',
                'subscription_ends_at' => null,
                'subscription_plan' => null,
            ];
        }

        $user->update(array_merge([
            'role_id' => $role->id,
        ], $subscriptionData));

        return $user->fresh('role');
    }

    /**
     * Suspend a user.
     */
    public function suspendUser(User $user, string $reason = null, \DateTimeInterface $until = null)
    {
        $user->suspend($reason, $until);
        
        Log::info('User suspended', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'reason' => $reason,
            'until' => $until,
            'suspended_by' => auth()->id(),
        ]);

        return $user;
    }

    /**
     * Activate a user.
     */
    public function activateUser(User $user)
    {
        $user->activate();
        
        Log::info('User activated', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'activated_by' => auth()->id(),
        ]);

        return $user;
    }

    /**
     * Get user statistics.
     */
    public function getUserStatistics()
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'suspended_users' => User::where('is_suspended', true)->count(),
            'normal_users' => User::whereHas('role', function ($query) {
                $query->where('name', 'normal_user');
            })->count(),
            'premium_users' => User::whereHas('role', function ($query) {
                $query->where('name', 'premium_user');
            })->where('subscription_status', 'premium')->count(),
            'admin_users' => User::whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'super_admin']);
            })->count(),
        ];
    }

    /**
     * Get role usage statistics.
     */
    public function getRoleUsageStatistics()
    {
        $roles = Role::withCount('users')->get();
        
        return $roles->map(function ($role) {
            return [
                'role' => $role->name,
                'display_name' => $role->display_name,
                'user_count' => $role->users_count,
                'percentage' => User::count() > 0 ? round(($role->users_count / User::count()) * 100, 2) : 0,
            ];
        });
    }

    /**
     * Get premium conversion statistics.
     */
    public function getPremiumConversionStatistics()
    {
        $totalUsers = User::count();
        $premiumUsers = User::whereHas('role', function ($query) {
            $query->where('name', 'premium_user');
        })->where('subscription_status', 'premium')->count();

        return [
            'total_users' => $totalUsers,
            'premium_users' => $premiumUsers,
            'conversion_rate' => $totalUsers > 0 ? round(($premiumUsers / $totalUsers) * 100, 2) : 0,
            'free_users' => $totalUsers - $premiumUsers,
        ];
    }

    /**
     * Bulk update user roles.
     */
    public function bulkUpdateRoles(array $userIds, string $roleName)
    {
        $role = Role::where('name', $roleName)->first();
        
        if (!$role) {
            throw new \Exception('Role not found.');
        }

        $users = User::whereIn('id', $userIds)->get();
        
        foreach ($users as $user) {
            $this->assignRole($user, $roleName);
        }

        return $users;
    }

    /**
     * Get permissions by resource.
     */
    public function getPermissionsByResource(string $resource)
    {
        return Permission::byResource($resource)->get();
    }

    /**
     * Create a new permission.
     */
    public function createPermission(array $data)
    {
        return Permission::create([
            'name' => $data['name'],
            'display_name' => $data['display_name'] ?? ucfirst(str_replace('_', ' ', $data['name'])),
            'description' => $data['description'] ?? null,
            'resource' => $data['resource'] ?? null,
            'action' => $data['action'] ?? null,
        ]);
    }
}