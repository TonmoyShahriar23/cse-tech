<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\SubscriptionController;

// Admin routes group
Route::prefix('admin')
    ->middleware(['auth', 'role:admin,super_admin'])
    ->name('admin.')
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard')
            ->middleware('permission:analytics_view');

        // User Management
        Route::prefix('users')
            ->name('users.')
            ->group(function () {
                Route::get('/', [UserController::class, 'index'])
                    ->name('index')
                    ->middleware('permission:user_list');
                
                Route::get('/create', [UserController::class, 'create'])
                    ->name('create')
                    ->middleware('permission:user_create');
                
                Route::post('/', [UserController::class, 'store'])
                    ->name('store')
                    ->middleware('permission:user_create');
                
                Route::get('/{user}', [UserController::class, 'show'])
                    ->name('show')
                    ->middleware('permission:user_read');
                
                Route::get('/{user}/edit', [UserController::class, 'edit'])
                    ->name('edit')
                    ->middleware('permission:user_update');
                
                Route::put('/{user}', [UserController::class, 'update'])
                    ->name('update')
                    ->middleware('permission:user_update');
                
                Route::delete('/{user}', [UserController::class, 'destroy'])
                    ->name('destroy')
                    ->middleware('permission:user_delete');
                
                Route::put('/{user}/role', [UserController::class, 'updateRole'])
                    ->name('updateRole')
                    ->middleware('permission:user_role_change');
                
                Route::put('/{user}/suspend', [UserController::class, 'suspend'])
                    ->name('suspend')
                    ->middleware('permission:user_suspend');
                
                Route::put('/{user}/activate', [UserController::class, 'activate'])
                    ->name('activate')
                    ->middleware('permission:user_role_change');
                
                Route::get('/{user}/usage', [UserController::class, 'viewUsage'])
                    ->name('usage')
                    ->middleware('permission:user_usage_view');
            });

        // Analytics
        Route::prefix('analytics')
            ->name('analytics.')
            ->group(function () {
                Route::get('/', [AnalyticsController::class, 'index'])
                    ->name('index')
                    ->middleware('permission:analytics_view');
                
                Route::get('/daily-active-users', [AnalyticsController::class, 'dailyActiveUsers'])
                    ->name('daily_active_users')
                    ->middleware('permission:daily_active_users');
                
                Route::get('/api-usage', [AnalyticsController::class, 'apiUsage'])
                    ->name('api_usage')
                    ->middleware('permission:api_usage_stats');
                
                Route::get('/conversion-rate', [AnalyticsController::class, 'conversionRate'])
                    ->name('conversion_rate')
                    ->middleware('permission:premium_conversion_rate');
            });

        // Subscription Management
        Route::prefix('subscriptions')
            ->name('subscriptions.')
            ->group(function () {
                Route::get('/', [SubscriptionController::class, 'index'])
                    ->name('index')
                    ->middleware('permission:subscription_activate');
                
                Route::post('/{user}/activate', [SubscriptionController::class, 'activate'])
                    ->name('activate')
                    ->middleware('permission:subscription_activate');
                
                Route::post('/{user}/deactivate', [SubscriptionController::class, 'deactivate'])
                    ->name('deactivate')
                    ->middleware('permission:subscription_deactivate');
                
                Route::post('/{user}/upgrade', [SubscriptionController::class, 'upgrade'])
                    ->name('upgrade')
                    ->middleware('permission:subscription_manual_upgrade');
                
                Route::post('/{user}/downgrade', [SubscriptionController::class, 'downgrade'])
                    ->name('downgrade')
                    ->middleware('permission:subscription_manual_downgrade');
            });

        // Chat Logs (Admin only)
        Route::get('/chat-logs', [DashboardController::class, 'chatLogs'])
            ->name('chat_logs')
            ->middleware('permission:chat_logs_view');

        // Admin Management (Super Admin only)
        Route::prefix('admins')
            ->middleware('role:super_admin')
            ->name('admins.')
            ->group(function () {
                Route::get('/', [UserController::class, 'adminIndex'])
                    ->name('index');
                
                Route::post('/', [UserController::class, 'createAdmin'])
                    ->name('create')
                    ->middleware('permission:admin_create');
                
                Route::delete('/{user}', [UserController::class, 'deleteAdmin'])
                    ->name('delete')
                    ->middleware('permission:admin_delete');
            });

        // Role Management (Permission-based)
        Route::prefix('roles')
            ->name('roles.')
            ->group(function () {
                Route::get('/', [UserController::class, 'rolesIndex'])
                    ->name('index')
                    ->middleware('permission:role_system_modify');
                
                Route::post('/', [UserController::class, 'createRole'])
                    ->name('create')
                    ->middleware('permission:role_system_modify');
                
                Route::put('/{role}', [UserController::class, 'updateRole'])
                    ->name('update')
                    ->middleware('permission:role_system_modify');
                
                Route::delete('/{role}', [UserController::class, 'deleteRole'])
                    ->name('delete')
                    ->middleware('permission:role_system_modify');
            });

        // Business Control (Super Admin only)
        Route::prefix('business')
            ->middleware('role:super_admin')
            ->name('business.')
            ->group(function () {
                Route::get('/revenue', [AnalyticsController::class, 'revenueDashboard'])
                    ->name('revenue')
                    ->middleware('permission:revenue_dashboard');
                
                Route::post('/subscription-pricing', [SubscriptionController::class, 'updatePricing'])
                    ->name('update_pricing')
                    ->middleware('permission:subscription_pricing_change');
                
                Route::post('/feature-rollout', [DashboardController::class, 'featureRollout'])
                    ->name('feature_rollout')
                    ->middleware('permission:feature_rollout');
            });
    });