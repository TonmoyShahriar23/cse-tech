<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use App\Models\Chat;
use App\Models\ChatSession;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Show admin dashboard.
     */
    public function index()
    {
        $statistics = $this->roleService->getUserStatistics();
        $roleUsage = $this->roleService->getRoleUsageStatistics();
        $conversionStats = $this->roleService->getPremiumConversionStatistics();

        return view('admin.dashboard', compact('statistics', 'roleUsage', 'conversionStats'));
    }

    /**
     * View chat logs.
     */
    public function chatLogs(Request $request)
    {
        $query = Chat::with(['session', 'user'])
            ->latest();

        // Filter by user if specified
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date,
                $request->end_date . ' 23:59:59'
            ]);
        }

        $chats = $query->paginate(50);

        return view('admin.chat-logs', compact('chats'));
    }

    /**
     * Feature rollout management.
     */
    public function featureRollout(Request $request)
    {
        $request->validate([
            'feature_name' => 'required|string',
            'status' => 'required|in:enabled,disabled',
            'target_roles' => 'nullable|array',
        ]);

        // This would typically integrate with a feature flag system
        // For now, we'll just log the request
        \Log::info('Feature rollout request', [
            'feature' => $request->feature_name,
            'status' => $request->status,
            'target_roles' => $request->target_roles,
            'requested_by' => auth()->id(),
        ]);

        return back()->with('success', 'Feature rollout request processed.');
    }
}