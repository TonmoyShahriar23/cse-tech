<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
use App\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get the admin role and role_system_modify permission
        $adminRole = Role::where('name', 'admin')->first();
        $roleSystemModifyPermission = Permission::where('name', 'role_system_modify')->first();

        if ($adminRole && $roleSystemModifyPermission) {
            // Add the role_system_modify permission to the admin role
            $adminRole->permissions()->syncWithoutDetaching([$roleSystemModifyPermission->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the role_system_modify permission from the admin role
        $adminRole = Role::where('name', 'admin')->first();
        $roleSystemModifyPermission = Permission::where('name', 'role_system_modify')->first();

        if ($adminRole && $roleSystemModifyPermission) {
            $adminRole->permissions()->detach($roleSystemModifyPermission->id);
        }
    }
};