<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->boolean('is_system_role')->default(false); // Prevent deletion of system roles
            $table->timestamps();
        });

        // Create permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->string('resource')->nullable(); // e.g., 'users', 'chats', 'admin'
            $table->string('action')->nullable(); // e.g., 'create', 'read', 'update', 'delete'
            $table->timestamps();
        });

        // Create role_permission pivot table
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['role_id', 'permission_id']);
        });

        // Add role_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('id');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_suspended')->default(false);
            $table->timestamp('suspended_until')->nullable();
            $table->string('suspension_reason')->nullable();
            
            // Add foreign key constraint
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });

        // Add subscription fields to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('subscription_status')->default('free'); // free, premium, suspended
            $table->timestamp('subscription_ends_at')->nullable();
            $table->string('subscription_plan')->nullable(); // future use for different premium tiers
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'is_active', 'is_suspended', 'suspended_until', 'suspension_reason']);
            $table->dropColumn(['subscription_status', 'subscription_ends_at', 'subscription_plan', 'stripe_customer_id', 'stripe_subscription_id']);
        });

        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};