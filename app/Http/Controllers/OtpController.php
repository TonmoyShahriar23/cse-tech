<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:otps,email',
        ]);

        $otpRecord = Otp::where('email', $request->email)->first();

        if (!$otpRecord) {
            return back()->withErrors(['email' => 'No OTP found for this email.']);
        }

        if (!$otpRecord->isExpired()) {
            return back()->withErrors(['email' => 'OTP is still valid. Please wait before requesting a new one.']);
        }

        // Generate new OTP
        $newOtp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiredAt = now()->addMinutes(2);

        // Update OTP record
        $otpRecord->update([
            'otp' => $newOtp,
            'expired_at' => $expiredAt
        ]);

        // Send new OTP email
        Mail::to($request->email)->send(new OtpMail($newOtp, 'User'));

        return back()->with('success', 'New OTP sent to your email.');
    }

    public function checkOtpStatus(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $otpRecord = Otp::where('email', $request->email)->first();

        if (!$otpRecord) {
            return response()->json([
                'exists' => false,
                'expired' => false
            ]);
        }

        return response()->json([
            'exists' => true,
            'expired' => $otpRecord->isExpired(),
            'time_remaining' => $otpRecord->isExpired() ? 0 : $otpRecord->expired_at->diffInSeconds(now())
        ]);
    }
}
