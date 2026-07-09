@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'استعادة كلمة المرور' : 'Forgot Password')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-bg-lime">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-text-dark">
                {{ app()->getLocale() == 'ar' ? 'استعادة كلمة المرور' : 'Forgot Password' }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ app()->getLocale() == 'ar' ? 'أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين' : 'Enter your email and we will send you a reset link' }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-primary/10">
            @if(session('success'))
                <div class="bg-green-50 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-text-dark mb-2">{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}</label>
                    <input type="email" name="email" required class="input @error('email') input-error @enderror" placeholder="you@example.com" value="{{ old('email') }}">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full btn btn-primary text-base py-3">{{ app()->getLocale() == 'ar' ? 'إرسال رابط إعادة التعيين' : 'Send Reset Link' }}</button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-secondary hover:text-amber-700 transition">{{ app()->getLocale() == 'ar' ? 'العودة لتسجيل الدخول' : 'Back to Login' }}</a>
            </div>
        </div>
    </div>
</div>
@endsection