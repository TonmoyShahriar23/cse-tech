<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Chat permissions
            ['name' => 'chat_read', 'display_name' => 'Read Chat', 'resource' => 'chat', 'action' => 'read'],
            ['name' => 'chat_create', 'display_name' => 'Create Chat', 'resource' => 'chat', 'action' => 'create'],
            ['name' => 'chat_update', 'display_name' => 'Update Chat', 'resource' => 'chat', 'action' => 'update'],
            ['name' => 'chat_delete', 'display_name' => 'Delete Chat', 'resource' => 'chat', 'action' => 'delete'],
            
            // Voice chat permissions (for future premium feature)
            ['name' => 'voice_chat_read', 'display_name' => 'Read Voice Chat', 'resource' => 'voice_chat', 'action' => 'read'],
            ['name' => 'voice_chat_create', 'display_name' => 'Create Voice Chat', 'resource' => 'voice_chat', 'action' => 'create'],
            
            // Image chat permissions (for future premium feature)
            ['name' => 'image_chat_read', 'display_name' => 'Read Image Chat', 'resource' => 'image_chat', 'action' => 'read'],
            ['name' => 'image_chat_create', 'display_name' => 'Create Image Chat', 'resource' => 'image_chat', 'action' => 'create'],
            
            // User management permissions
            ['name' => 'user_list', 'display_name' => 'List Users', 'resource' => 'user', 'action' => 'list'],
            ['name' => 'user_read', 'display_name' => 'Read User', 'resource' => 'user', 'action' => 'read'],
            ['name' => 'user_update', 'display_name' => 'Update User', 'resource' => 'user', 'action' => 'update'],
            ['name' => 'user_delete', 'display_name' => 'Delete User', 'resource' => 'user', 'action' => 'delete'],
            ['name' => 'user_role_change', 'display_name' => 'Change User Role', 'resource' => 'user', 'action' => 'role_change'],
            ['name' => 'user_suspend', 'display_name' => 'Suspend User', 'resource' => 'user', 'action' => 'suspend'],
            ['name' => 'user_usage_view', 'display_name' => 'View User Usage', 'resource' => 'user', 'action' => 'usage_view'],
            
            // Chat monitoring permissions
            ['name' => 'chat_logs_view', 'display_name' => 'View Chat Logs', 'resource' => 'chat_logs', 'action' => 'view'],
            
            // Analytics permissions
            ['name' => 'analytics_view', 'display_name' => 'View Analytics', 'resource' => 'analytics', 'action' => 'view'],
            ['name' => 'daily_active_users', 'display_name' => 'View Daily Active Users', 'resource' => 'analytics', 'action' => 'daily_active_users'],
            ['name' => 'api_usage_stats', 'display_name' => 'View API Usage Stats', 'resource' => 'analytics', 'action' => 'api_usage_stats'],
            ['name' => 'premium_conversion_rate', 'display_name' => 'View Premium Conversion Rate', 'resource' => 'analytics', 'action' => 'premium_conversion_rate'],
            
            // Subscription control permissions
            ['name' => 'subscription_activate', 'display_name' => 'Activate Subscription', 'resource' => 'subscription', 'action' => 'activate'],
            ['name' => 'subscription_deactivate', 'display_name' => 'Deactivate Subscription', 'resource' => 'subscription', 'action' => 'deactivate'],
            ['name' => 'subscription_manual_upgrade', 'display_name' => 'Manual Upgrade', 'resource' => 'subscription', 'action' => 'manual_upgrade'],
            ['name' => 'subscription_manual_downgrade', 'display_name' => 'Manual Downgrade', 'resource' => 'subscription', 'action' => 'manual_downgrade'],
            
            // Admin management permissions (Super Admin only)
            ['name' => 'admin_create', 'display_name' => 'Create Admin', 'resource' => 'admin', 'action' => 'create'],
            ['name' => 'admin_delete', 'display_name' => 'Delete Admin', 'resource' => 'admin', 'action' => 'delete'],
            ['name' => 'role_system_modify', 'display_name' => 'Modify Role System', 'resource' => 'role_system', 'action' => 'modify'],
            
            // Business control permissions (Super Admin only)
            ['name' => 'revenue_dashboard', 'display_name' => 'View Revenue Dashboard', 'resource' => 'revenue', 'action' => 'dashboard'],
            ['name' => 'subscription_pricing_change', 'display_name' => 'Change Subscription Pricing', 'resource' => 'subscription', 'action' => 'pricing_change'],
            ['name' => 'feature_rollout', 'display_name' => 'Feature Rollout', 'resource' => 'feature', 'action' => 'rollout'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::create($permissionData);
        }

        // Create roles
        $normalUserRole = Role::create([
            'name' => 'normal_user',
            'display_name' => 'Normal User',
            'description' => 'Basic user with access to text chat only',
            'is_system_role' => true,
        ]);

        $premiumUserRole = Role::create([
            'name' => 'premium_user',
            'display_name' => 'Premium User',
            'description' => 'Premium user with access to all chat features',
            'is_system_role' => true,
        ]);

        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'System administrator with user management and monitoring capabilities',
            'is_system_role' => true,
        ]);

        $superAdminRole = Role::create([
            'name' => 'super_admin',
            'display_name' => 'Super Administrator',
            'description' => 'Full system control including admin management',
            'is_system_role' => true,
        ]);

        // Assign permissions to Normal User
        $normalUserRole->syncPermissions([
            'chat_read',
            'chat_create',
            'chat_update',
            'chat_delete',
        ]);

        // Assign permissions to Premium User (inherits normal user permissions + premium features)
        $premiumUserRole->syncPermissions([
            'chat_read',
            'chat_create',
            'chat_update',
            'chat_delete',
            'voice_chat_read',
            'voice_chat_create',
            'image_chat_read',
            'image_chat_create',
        ]);

        // Assign permissions to Admin
        $adminRole->syncPermissions([
            // Chat permissions
            'chat_read',
            'chat_create',
            'chat_update',
            'chat_delete',
            
            // User management permissions
            'user_list',
            'user_read',
            'user_update',
            'user_role_change',
            'user_suspend',
            'user_usage_view',
            
            // Chat monitoring permissions
            'chat_logs_view',
            
            // Analytics permissions
            'analytics_view',
            'daily_active_users',
            'api_usage_stats',
            'premium_conversion_rate',
            
            // Subscription control permissions
            'subscription_activate',
            'subscription_deactivate',
            'subscription_manual_upgrade',
            'subscription_manual_downgrade',
            
            // Role management permissions
            'role_system_modify',
        ]);

        // Assign permissions to Super Admin (all permissions)
        $superAdminRole->syncPermissions([
            // All admin permissions
            'chat_read',
            'chat_create',
            'chat_update',
            'chat_delete',
            'user_list',
            'user_read',
            'user_update',
            'user_delete',
            'user_role_change',
            'user_suspend',
            'user_usage_view',
            'chat_logs_view',
            'analytics_view',
            'daily_active_users',
            'api_usage_stats',
            'premium_conversion_rate',
            'subscription_activate',
            'subscription_deactivate',
            'subscription_manual_upgrade',
            'subscription_manual_downgrade',
            
            // Super Admin only permissions
            'admin_create',
            'admin_delete',
            'role_system_modify',
            'revenue_dashboard',
            'subscription_pricing_change',
            'feature_rollout',
        ]);
    }
}