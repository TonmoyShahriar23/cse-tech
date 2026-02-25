<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call(RolesAndPermissionsSeeder::class);
        
        // Create default admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role_id' => \App\Models\Role::where('name', 'super_admin')->first()->id,
        ]);
        
        // Create test users for different roles
        \App\Models\User::factory(5)->create([
            'role_id' => \App\Models\Role::where('name', 'normal_user')->first()->id,
        ]);
        
        \App\Models\User::factory(3)->create([
            'role_id' => \App\Models\Role::where('name', 'premium_user')->first()->id,
            'subscription_status' => 'premium',
            'subscription_ends_at' => now()->addYear(),
        ]);
        
        \App\Models\User::factory(2)->create([
            'role_id' => \App\Models\Role::where('name', 'admin')->first()->id,
        ]);
    }
}
