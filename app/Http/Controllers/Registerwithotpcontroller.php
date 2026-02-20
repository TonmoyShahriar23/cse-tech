<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Registerwithotpcontroller extends Controller
{
    public function create()
    {
        return view('auth_otp.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate 6-digit OTP
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Set expiration time (2 minutes from now)
        $expiredAt = now()->addMinutes(2);

        // Check if OTP already exists for this email
        $otpRecord = Otp::where('email', $request->email)->first();
        
        if ($otpRecord) {
            // Update existing OTP
            $otpRecord->update([
                'otp' => $otp,
                'expired_at' => $expiredAt
            ]);
        } else {
            // Create new OTP record
            Otp::create([
                'email' => $request->email,
                'otp' => $otp,
                'expired_at' => $expiredAt
            ]);
        }

        // Send OTP email
        Mail::to($request->email)->queue(new OtpMail($otp, $request->name));

        // Store user data temporarily (you might want to use session or cache)
        session([
            'temp_user_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]
        ]);

        return redirect()->route('otp.verify.form')->with('email', $request->email);
    }

    public function showVerifyForm()
    {
        $email = session('email');
        return view('auth_otp.verify', compact('email'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|array',
            'otp.*' => 'required|numeric|digits:1',
        ]);

        $otpRecord = Otp::where('email', $request->email)->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid OTP or email not found.']);
        }

        if ($otpRecord->isExpired()) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // Convert OTP from array to string (since we use separate inputs)
        $enteredOtp = '';
        if (is_array($request->otp)) {
            $enteredOtp = implode('', $request->otp);
        } else {
            $enteredOtp = $request->otp;
        }

        if ($otpRecord->otp !== $enteredOtp) {
            // Wrong OTP entered, but OTP is still valid - allow retry within same 2-minute window
            return back()->withErrors(['otp' => 'Your entered OTP code is wrong. Please enter the correct OTP.'])->withInput();
        }

        // Get temporary user data
        $tempUserData = session('temp_user_data');
        
        if (!$tempUserData || $tempUserData['email'] !== $request->email) {
            return back()->withErrors(['otp' => 'Session expired. Please register again.']);
        }

        // Create user
        $user = User::create([
            'name' => $tempUserData['name'],
            'email' => $tempUserData['email'],
            'password' => Hash::make($tempUserData['password']),
        ]);

        // Clear OTP record
        $otpRecord->delete();

        // Clear temporary session data
        session()->forget(['temp_user_data', 'email']);

        // Log in the user
        auth()->login($user);

        return redirect()->route('chat.index')->with('success', 'Registration successful! Welcome to the chat.');
    }
}
