<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimpleRBACTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed roles and permissions
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_role_assignment_and_retrieval()
    {
        $user = User::factory()->create();
        $adminRole = Role::where('name', 'admin')->first();

        // Test direct assignment
        $user->update(['role_id' => $adminRole->id]);
        
        // Reload user
        $user->refresh();

        $this->assertEquals($adminRole->id, $user->role_id);
        $this->assertTrue($user->hasRole('admin'));
    }

    public function test_permission_checking()
    {
        $user = User::factory()->create();
        $adminRole = Role::where('name', 'admin')->first();
        
        // Direct assignment
        $user->update(['role_id' => $adminRole->id]);
        $user->refresh();

        $this->assertTrue($user->hasPermission('user_list'));
        $this->assertTrue($user->hasPermission('analytics_view'));
    }

    public function test_user_role_permissions()
    {
        $user = User::factory()->create();
        $userRole = Role::where('name', 'normal_user')->first();
        
        $user->update(['role_id' => $userRole->id]);
        $user->refresh();

        $this->assertTrue($user->hasPermission('chat_read'));
        $this->assertTrue($user->hasPermission('chat_create'));
        $this->assertFalse($user->hasPermission('user_list'));
    }

    public function test_premium_role_permissions()
    {
        $user = User::factory()->create();
        $premiumRole = Role::where('name', 'premium_user')->first();
        
        $user->update(['role_id' => $premiumRole->id]);
        $user->refresh();

        // Should have all user permissions
        $this->assertTrue($user->hasPermission('chat_read'));
        $this->assertTrue($user->hasPermission('chat_create'));
        
        // And premium-specific permissions
        $this->assertTrue($user->hasPermission('voice_chat_read'));
        $this->assertTrue($user->hasPermission('image_chat_create'));
    }
}