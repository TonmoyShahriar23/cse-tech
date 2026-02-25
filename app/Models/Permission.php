<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'resource',
        'action',
    ];

    /**
     * Get the roles that have this permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    /**
     * Get permission name in a readable format.
     */
    public function getDisplayNameAttribute($value)
    {
        return $value ?: ucfirst(str_replace('_', ' ', $this->name));
    }

    /**
     * Scope to get permissions by resource.
     */
    public function scopeByResource($query, $resource)
    {
        return $query->where('resource', $resource);
    }

    /**
     * Scope to get permissions by action.
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }
}