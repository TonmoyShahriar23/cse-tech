<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
        'is_suspended',
        'suspended_until',
        'suspension_reason',
        'subscription_status',
        'subscription_ends_at',
        'subscription_plan',
        'stripe_customer_id',
        'stripe_subscription_id',
    ];

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'is_suspended' => 'boolean',
        'suspended_until' => 'datetime',
        'subscription_ends_at' => 'datetime',
    ];

    /**
     * Check if user has a specific permission
     */
    public function hasPermission($permissionName)
    {
        if (!$this->role) {
            return false;
        }

        // Eager load permissions if not already loaded
        if (!$this->role->relationLoaded('permissions')) {
            $this->role->load('permissions');
        }

        return $this->role->permissions->contains('name', $permissionName);
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($roleName)
    {
        if (is_array($roleName)) {
            return $this->role && in_array($this->role->name, $roleName);
        }
        
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole($roles)
    {
        if (!is_array($roles)) {
            $roles = [$roles];
        }
        
        return $this->role && in_array($this->role->name, $roles);
    }

    /**
     * Check if user has a specific permission (custom method to avoid conflict with Laravel's can method).
     */
    public function hasSpecificPermission($permissionName)
    {
        return $this->role && $this->role->hasPermission($permissionName);
    }

    /**
     * Check if user is a premium user.
     */
    public function isPremium()
    {
        return $this->hasRole('premium_user') && 
               $this->subscription_status === 'premium' && 
               (!$this->subscription_ends_at || $this->subscription_ends_at->isFuture());
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin()
    {
        return $this->hasAnyRole(['admin', 'super_admin']);
    }

    /**
     * Check if user is a super admin.
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Suspend user account.
     */
    public function suspend($reason = null, $until = null)
    {
        $this->update([
            'is_suspended' => true,
            'suspension_reason' => $reason,
            'suspended_until' => $until,
        ]);
    }

    /**
     * Activate user account.
     */
    public function activate()
    {
        $this->update([
            'is_suspended' => false,
            'suspension_reason' => null,
            'suspended_until' => null,
        ]);
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole($role)
    {
        if ($role instanceof \App\Models\Role) {
            $this->update(['role_id' => $role->id]);
        } elseif (is_string($role)) {
            $roleModel = \App\Models\Role::where('name', $role)->first();
            if ($roleModel) {
                $this->update(['role_id' => $roleModel->id]);
            }
        }
    }

    /**
     * Remove role from user.
     */
    public function removeRole()
    {
        $this->update(['role_id' => null]);
    }

    /**
     * Update user role.
     */
    public function updateRole($roleName)
    {
        $role = \App\Models\Role::where('name', $roleName)->first();
        if ($role) {
            $this->update(['role_id' => $role->id]);
        }
    }

    /**
     * Upgrade to premium.
     */
    public function upgradeToPremium($plan = 'premium', $endsAt = null)
    {
        $this->update([
            'subscription_status' => 'premium',
            'subscription_plan' => $plan,
            'subscription_ends_at' => $endsAt ?? now()->addYear(),
        ]);
        
        // Also update role to premium_user
        $this->updateRole('premium_user');
    }

    /**
     * Downgrade to normal user.
     */
    public function downgradeToNormal()
    {
        $this->update([
            'subscription_status' => 'free',
            'subscription_plan' => null,
            'subscription_ends_at' => null,
        ]);
        
        // Also update role to normal_user
        $this->updateRole('normal_user');
    }

    /**
     * Check if user account is currently active and not suspended.
     */
    public function isActive()
    {
        return $this->is_active && 
               (!$this->is_suspended || 
                ($this->suspended_until && $this->suspended_until->isPast()));
    }
}
