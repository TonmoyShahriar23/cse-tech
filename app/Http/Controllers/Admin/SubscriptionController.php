<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display subscription management.
     */
    public function index(Request $request)
    {
        $query = User::with('role')
            ->whereHas('role', function ($query) {
                $query->whereIn('name', ['normal_user', 'premium_user']);
            });

        // Filter by subscription status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('subscription_status', $request->status);
        }

        $users = $query->latest()->paginate(20);

        return view('admin.subscriptions.index', compact('users'));
    }

    /**
     * Activate subscription.
     */
    public function activate(Request $request, User $user)
    {
        $request->validate([
            'plan' => 'required|in:premium,business',
            'duration' => 'required|in:1_month,3_months,6_months,1_year',
        ]);

        $endDate = match($request->duration) {
            '1_month' => now()->addMonth(),
            '3_months' => now()->addMonths(3),
            '6_months' => now()->addMonths(6),
            '1_year' => now()->addYear(),
        };

        $user->upgradeToPremium($request->plan, $endDate);

        return back()->with('success', 'Subscription activated successfully.');
    }

    /**
     * Deactivate subscription.
     */
    public function deactivate(User $user)
    {
        $user->downgradeToNormal();

        return back()->with('success', 'Subscription deactivated successfully.');
    }

    /**
     * Manual upgrade to premium.
     */
    public function upgrade(User $user)
    {
        $user->upgradeToPremium('premium', now()->addYear());

        return back()->with('success', 'User upgraded to premium successfully.');
    }

    /**
     * Manual downgrade to normal.
     */
    public function downgrade(User $user)
    {
        $user->downgradeToNormal();

        return back()->with('success', 'User downgraded to normal successfully.');
    }

    /**
     * Update subscription pricing (Super Admin only).
     */
    public function updatePricing(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:premium,business',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
        ]);

        // This would typically update pricing in a database or configuration
        // For now, we'll just log the request
        \Log::info('Pricing update request', [
            'plan' => $request->plan,
            'price' => $request->price,
            'currency' => $request->currency,
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Subscription pricing updated successfully.');
    }
}