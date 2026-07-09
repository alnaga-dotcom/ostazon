<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\TutorProfile;
use App\Services\CoinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,tutor',
            'referral_code' => 'nullable|string|exists:users,referral_code',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'referral_code' => Str::random(8),
            'referred_by' => $request->referral_code ? User::where('referral_code', $request->referral_code)->first()->id : null,
        ]);

        if ($request->role === 'student') {
            StudentProfile::create(['user_id' => $user->id]);
            CoinService::credit($user->id, 40, 'welcome', 'Welcome bonus 40 coins', 'welcome', $user->id);
        } else {
            TutorProfile::create([
                'user_id' => $user->id,
                'country' => $request->country,
                'city' => $request->city,
            ]);
        }

        if ($request->referral_code) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
            if ($referrer) {
                CoinService::credit(
                    $referrer->id,
                    50,
                    'referral',
                    'Referral bonus for inviting ' . $user->name,
                    'referral',
                    $user->id
                );
            }
        }

        Auth::login($user);

        return redirect()->route($request->role === 'student' ? 'student.dashboard' : 'tutor.dashboard')
            ->with('success', 'Welcome to OstazON!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            $user->update(['last_login_at' => now()]);

            return redirect()->intended(
                $user->isAdmin() ? route('admin.dashboard') :
                ($user->isTutor() ? route('tutor.dashboard') : route('student.dashboard'))
            );
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->with('error', __($status));
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->with('error', __($status));
    }
}
