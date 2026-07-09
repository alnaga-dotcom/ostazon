@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'إعادة تعيين كلمة المرور' : 'Reset Password')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-bg-lime">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-text-dark">
                {{ app()->getLocale() == 'ar' ? 'إعادة تعيين كلمة المرور' : 'Reset Password' }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-primary/10">
            @if($errors->any())
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label class="block text-sm font-medium text-text-dark mb-2">{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}</label>
                    <input type="email" name="email" required class="input" value="{{ old('email', request('email')) }}" placeholder="you@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-dark mb-2">{{ app()->getLocale() == 'ar' ? 'كلمة المرور الجديدة' : 'New Password' }}</label>
                    <input type="password" name="password" required class="input" placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-dark mb-2">{{ app()->getLocale() == 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}</label>
                    <input type="password" name="password_confirmation" required class="input" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full btn btn-primary text-base py-3">{{ app()->getLocale() == 'ar' ? 'إعادة التعيين' : 'Reset Password' }}</button>
            </form>
        </div>
    </div>
</div>
@endsection