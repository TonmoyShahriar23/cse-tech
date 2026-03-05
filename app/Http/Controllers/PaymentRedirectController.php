<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentRedirectController extends Controller
{
    /**
     * Handle SSLCommerz redirect after OTP verification
     * This method specifically handles the redirect issue that causes about:blank#blocked
     */
    public function handleSslCommerzRedirect(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('SSLCommerz redirect request received', [
            'method' => $request->method(),
            'headers' => $request->headers->all(),
            'query_params' => $request->query(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip()
        ]);

        // Check if this is a GET request from SSLCommerz redirect
        if ($request->isMethod('get')) {
            // Check if we have payment success data in session
            if (session('payment_success')) {
                // Store session data temporarily
                $successData = session('payment_success');
                $tran_id = session('tran_id');
                $amount = session('amount');
                $currency = session('currency');
                $card_type = session('card_type');
                
                // Clear the session data after using it
                session()->forget(['payment_success', 'tran_id', 'amount', 'currency', 'card_type']);
                
                // Return a page with JavaScript redirect to avoid about:blank#blocked issues
                return response()->view('payment.js_redirect', [
                    'success_url' => route('payment.success')
                ]);
            }
            
            // If no session data, redirect to pricing page
            return redirect('/pricing')->with('error', 'Invalid Transaction');
        }

        // For POST requests, redirect to the success handler
        return redirect()->route('payment.success');
    }

    /**
     * Alternative redirect method using JavaScript to avoid about:blank#blocked
     */
    public function handleSslCommerzRedirectJS(Request $request)
    {
        // Check if we have payment success data in session
        if (session('payment_success')) {
            // Return a page with JavaScript redirect to avoid cross-origin issues
            return response()->view('payment.js_redirect', [
                'success_url' => route('payment.success')
            ]);
        }
        
        // If no session data, redirect to pricing page
        return redirect('/pricing')->with('error', 'Invalid Transaction');
    }
}