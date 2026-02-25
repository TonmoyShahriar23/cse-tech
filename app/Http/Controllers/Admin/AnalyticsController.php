<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use App\Models\Chat;
use App\Models\ChatSession;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Show analytics dashboard.
     */
    public function index()
    {
        $statistics = $this->roleService->getUserStatistics();
        $roleUsage = $this->roleService->getRoleUsageStatistics();
        $conversionStats = $this->roleService->getPremiumConversionStatistics();

        // Get recent activity
        $recentChats = Chat::with(['user', 'session'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.analytics.index', compact('statistics', 'roleUsage', 'conversionStats', 'recentChats'));
    }

    /**
     * Daily active users analytics.
     */
    public function dailyActiveUsers(Request $request)
    {
        $days = $request->input('days', 30);
        
        $data = ChatSession::selectRaw('DATE(last_message_at) as date, COUNT(DISTINCT user_id) as count')
            ->where('last_message_at', '>=', now()->subDays($days))
            ->whereNotNull('user_id')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.analytics.daily-active-users', compact('data', 'days'));
    }

    /**
     * API usage statistics.
     */
    public function apiUsage(Request $request)
    {
        $days = $request->input('days', 7);
        
        $data = Chat::selectRaw('DATE(created_at) as date, COUNT(*) as message_count')
            ->where('created_at', '>=', now()->subDays($days))
            ->where('role', 'assistant')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalMessages = Chat::where('role', 'assistant')
            ->where('created_at', '>=', now()->subDays($days))
            ->count();

        return view('admin.analytics.api-usage', compact('data', 'totalMessages', 'days'));
    }

    /**
     * Premium conversion rate analytics.
     */
    public function conversionRate(Request $request)
    {
        $conversionStats = $this->roleService->getPremiumConversionStatistics();
        
        // Get conversion trends over time
        $trends = User::selectRaw('DATE(created_at) as date, COUNT(*) as new_users')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.analytics.conversion-rate', compact('conversionStats', 'trends'));
    }

    /**
     * Revenue dashboard (Super Admin only).
     */
    public function revenueDashboard(Request $request)
    {
        // Mock revenue data - in a real application, this would come from payment system
        $revenueData = [
            'total_revenue' => 15000.00,
            'monthly_revenue' => 2500.00,
            'active_subscriptions' => 50,
            'churn_rate' => 5.2,
        ];

        return view('admin.analytics.revenue', compact('revenueData'));
    }
}