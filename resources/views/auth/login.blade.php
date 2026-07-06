@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'تسجيل الدخول' : 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-bg-lime">
    <div class="max-w-md w-full">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="OstazON" class="h-20 mx-auto mb-4">
            <h2 class="text-3xl font-extrabold text-text-dark">
                {{ app()->getLocale() == 'ar' ? 'مرحباً بعودتك' : 'Welcome Back' }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ app()->getLocale() == 'ar' ? 'سجل الدخول إلى حسابك' : 'Login to your account' }}
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-primary/10">
            @if(session('error'))
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-text-dark mb-2">
                        {{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}
                    </label>
                    <input type="email" name="email" id="email" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition @error('email') border-red-500 @enderror"
                        placeholder="you@example.com" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-text-dark mb-2">
                        {{ app()->getLocale() == 'ar' ? 'كلمة المرور' : 'Password' }}
                    </label>
                    <input type="password" name="password" id="password" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition @error('password') border-red-500 @enderror"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">
                            {{ app()->getLocale() == 'ar' ? 'تذكرني' : 'Remember Me' }}
                        </span>
                    </label>
                    <a href="#" class="text-sm font-medium text-secondary hover:text-amber-700 transition">
                        {{ app()->getLocale() == 'ar' ? 'نسيت كلمة المرور؟' : 'Forgot Password?' }}
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full bg-primary hover:bg-green-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                    {{ app()->getLocale() == 'ar' ? 'تسجيل الدخول' : 'Login' }}
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">
                    {{ app()->getLocale() == 'ar' ? 'ليس لديك حساب؟' : "Don't have an account?" }}
                    <a href="{{ route('register') }}" class="font-semibold text-secondary hover:text-amber-700 transition">
                        {{ app()->getLocale() == 'ar' ? 'سجل الآن' : 'Register Now' }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
