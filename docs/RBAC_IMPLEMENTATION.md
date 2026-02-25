# Role-Based Access Control (RBAC) Implementation

This document describes the RBAC system implemented in the CSE Tech Laravel application.

## Overview

The RBAC system provides fine-grained access control through roles and permissions, allowing different levels of access based on user roles. The system supports multiple user tiers with different capabilities.

## Architecture

### Database Structure

The RBAC system uses three main tables:

1. **roles** - Defines different user roles
2. **permissions** - Defines individual permissions
3. **users** - Extended with `role_id` field for role assignment

### Models

#### Role Model (`app/Models/Role.php`)
- Represents different user roles (admin, user, premium_user)
- Has many permissions through role_permissions pivot table
- Provides methods for permission management

#### Permission Model (`app/Models/Permission.php`)
- Represents individual permissions
- Belongs to many roles through role_permissions pivot table

#### User Model (`app/Models/User.php`)
- Extended with role relationship
- Provides methods for role and permission checking:
  - `hasRole($roleName)`
  - `hasPermission($permissionName)`
  - `assignRole($role)`
  - `removeRole()`

### Middleware

#### CheckRole Middleware (`app/Http/Middleware/CheckRole.php`)
- Verifies if user has required role
- Usage: `role:admin,moderator`

#### CheckPermission Middleware (`app/Http/Middleware/CheckPermission.php`)
- Verifies if user has required permission
- Usage: `permission:manage_users`

### Service Classes

#### RoleService (`app/Services/RoleService.php`)
- Manages role assignment and removal
- Provides business logic for role operations
- Handles role validation and updates

#### AiService (`app/Services/AiService.php`)
- Implements tier-based AI access control
- Manages different access levels for AI features
- Handles rate limiting and feature restrictions

## User Roles and Permissions

### Admin Role
- **Permissions**: All permissions
- **Access**: Full system access, user management, analytics

### Premium User Role
- **Permissions**: All user permissions + premium features
- **Access**: Enhanced AI features, priority support

### User Role (Default)
- **Permissions**: Basic access
- **Access**: Standard features, limited AI access

## Implementation Details

### Middleware Registration
In Laravel 12, middleware is registered in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
        'permission' => \App\Http\Middleware\CheckPermission::class,
    ]);
})
```

### Route Protection
Routes can be protected using middleware:

```php
Route::get('/admin', function() {
    // Admin only content
})->middleware(['auth', 'role:admin']);

Route::get('/analytics', function() {
    // Analytics access
})->middleware(['auth', 'permission:view_analytics']);
```

### Controller Usage
Controllers can check permissions:

```php
public function index()
{
    if (!auth()->user()->hasPermission('manage_users')) {
        abort(403, 'Unauthorized action.');
    }
    
    // Controller logic
}
```

### Frontend Components
Navigation and UI elements can be conditionally displayed:

```blade
@auth
    @if(auth()->user()->hasPermission('access_chat'))
        <a href="{{ route('chat.index') }}">AI Chat</a>
    @endif
@endauth
```

## Testing

The RBAC system includes comprehensive tests in `tests/Feature/RBACTest.php`:

- Role assignment and checking
- Permission inheritance
- Route protection
- Access control validation

Run tests with:
```bash
php artisan test tests/Feature/RBACTest.php
```

## Seeding

Default roles and permissions are created via `database/seeders/RolesAndPermissionsSeeder.php`:

- Creates admin, user, and premium_user roles
- Assigns appropriate permissions to each role
- Can be run with: `php artisan db:seed --class=RolesAndPermissionsSeeder`

## Usage Examples

### Assigning Roles
```php
$user = User::find(1);
$role = Role::where('name', 'admin')->first();
$user->assignRole($role);
```

### Checking Permissions
```php
if ($user->hasPermission('manage_users')) {
    // Allow action
}
```

### Protecting Routes
```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);
});
```

## Security Considerations

1. **Always validate permissions** - Never trust client-side checks
2. **Use middleware for route protection** - Don't rely only on controller checks
3. **Implement proper error handling** - Return appropriate HTTP status codes
4. **Log security events** - Track role changes and permission violations
5. **Regular audits** - Review role assignments and permissions periodically

## Future Enhancements

1. **Role hierarchy** - Support for role inheritance
2. **Dynamic permissions** - Runtime permission creation
3. **Audit logging** - Track all role and permission changes
4. **API tokens** - Role-based API access control
5. **Multi-tenancy** - Role isolation per organization

## Troubleshooting

### Common Issues

1. **Middleware not working** - Ensure middleware is registered in `bootstrap/app.php`
2. **Permissions not inherited** - Check role-permission relationships
3. **Route protection bypassed** - Verify middleware order and authentication

### Debug Commands

```bash
# Check user roles
php artisan tinker
>>> $user = App\Models\User::find(1);
>>> $user->role;

# Check user permissions
>>> $user->hasPermission('manage_users');

# List all roles
>>> App\Models\Role::all();