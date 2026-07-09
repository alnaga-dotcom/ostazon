@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'إنشاء حساب' : 'Register')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-bg-lime">
    <div class="max-w-xl mx-auto">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="OstazON" class="h-20 mx-auto mb-4">
            <h2 class="text-3xl font-extrabold text-text-dark">
                {{ app()->getLocale() == 'ar' ? 'انضم إلى OstazON' : 'Join OstazON' }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ app()->getLocale() == 'ar' ? 'إنشاء حساب جديد' : 'Create New Account' }}
            </p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-primary/10">
            @if(session('error'))
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-text-dark mb-2">
                        {{ app()->getLocale() == 'ar' ? 'الاسم الكامل' : 'Full Name' }}
                    </label>
                    <input type="text" name="name" id="name" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition @error('name') border-red-500 @enderror"
                        placeholder="{{ app()->getLocale() == 'ar' ? 'أحمد محمد' : 'John Doe' }}" value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

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

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-text-dark mb-2">
                        {{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone Number' }}
                    </label>
                    <input type="tel" name="phone" id="phone" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="+20 1XX XXX XXXX" value="{{ old('phone') }}">
                </div>

                <!-- Country -->
                <div>
                    <label for="country" class="block text-sm font-medium text-text-dark mb-2">
                        {{ app()->getLocale() == 'ar' ? 'الدولة' : 'Country' }}
                    </label>
                    <select name="country" id="country" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition bg-white">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'اختر الدولة' : 'Select Country' }}</option>
                        <option value="Egypt">{{ app()->getLocale() == 'ar' ? 'مصر' : 'Egypt' }}</option>
                        <option value="Saudi Arabia">{{ app()->getLocale() == 'ar' ? 'السعودية' : 'Saudi Arabia' }}</option>
                        <option value="UAE">{{ app()->getLocale() == 'ar' ? 'الإمارات' : 'UAE' }}</option>
                        <option value="Kuwait">{{ app()->getLocale() == 'ar' ? 'الكويت' : 'Kuwait' }}</option>
                        <option value="Qatar">{{ app()->getLocale() == 'ar' ? 'قطر' : 'Qatar' }}</option>
                        <option value="Bahrain">{{ app()->getLocale() == 'ar' ? 'البحرين' : 'Bahrain' }}</option>
                        <option value="Oman">{{ app()->getLocale() == 'ar' ? 'عمان' : 'Oman' }}</option>
                        <option value="Jordan">{{ app()->getLocale() == 'ar' ? 'الأردن' : 'Jordan' }}</option>
                        <option value="Lebanon">{{ app()->getLocale() == 'ar' ? 'لبنان' : 'Lebanon' }}</option>
                        <option value="Iraq">{{ app()->getLocale() == 'ar' ? 'العراق' : 'Iraq' }}</option>
                        <option value="Morocco">{{ app()->getLocale() == 'ar' ? 'المغرب' : 'Morocco' }}</option>
                        <option value="Tunisia">{{ app()->getLocale() == 'ar' ? 'تونس' : 'Tunisia' }}</option>
                        <option value="Algeria">{{ app()->getLocale() == 'ar' ? 'الجزائر' : 'Algeria' }}</option>
                        <option value="Libya">{{ app()->getLocale() == 'ar' ? 'ليبيا' : 'Libya' }}</option>
                        <option value="Sudan">{{ app()->getLocale() == 'ar' ? 'السودان' : 'Sudan' }}</option>
                        <option value="Yemen">{{ app()->getLocale() == 'ar' ? 'اليمن' : 'Yemen' }}</option>
                        <option value="Palestine">{{ app()->getLocale() == 'ar' ? 'فلسطين' : 'Palestine' }}</option>
                        <option value="Syria">{{ app()->getLocale() == 'ar' ? 'سوريا' : 'Syria' }}</option>
                        <option value="India">{{ app()->getLocale() == 'ar' ? 'الهند' : 'India' }}</option>
                        <option value="Pakistan">{{ app()->getLocale() == 'ar' ? 'باكستان' : 'Pakistan' }}</option>
                        <option value="Bangladesh">{{ app()->getLocale() == 'ar' ? 'بنغلاديش' : 'Bangladesh' }}</option>
                        <option value="United Kingdom">{{ app()->getLocale() == 'ar' ? 'المملكة المتحدة' : 'United Kingdom' }}</option>
                        <option value="United States">{{ app()->getLocale() == 'ar' ? 'الولايات المتحدة' : 'United States' }}</option>
                        <option value="Canada">{{ app()->getLocale() == 'ar' ? 'كندا' : 'Canada' }}</option>
                        <option value="Australia">{{ app()->getLocale() == 'ar' ? 'أستراليا' : 'Australia' }}</option>
                        <option value="Other">{{ app()->getLocale() == 'ar' ? 'أخرى' : 'Other' }}</option>
                    </select>
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-text-dark mb-2">
                        {{ app()->getLocale() == 'ar' ? 'المدينة' : 'City' }}
                    </label>
                    <input type="text" name="city" id="city"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: القاهرة' : 'e.g. Cairo' }}" value="{{ old('city') }}">
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-text-dark mb-3">
                        {{ app()->getLocale() == 'ar' ? 'نوع الحساب' : 'Account Type' }}
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="student" class="peer sr-only" checked>
                            <div class="rounded-xl border-2 border-gray-200 p-4 text-center hover:border-primary transition peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white">
                                <div class="text-2xl mb-1">🎓</div>
                                <div class="font-semibold text-sm">{{ app()->getLocale() == 'ar' ? 'طالب' : 'Student' }}</div>
                                <div class="text-xs mt-1 opacity-80">{{ app()->getLocale() == 'ar' ? 'ابحث عن معلمين' : 'Find tutors' }}</div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="tutor" class="peer sr-only">
                            <div class="rounded-xl border-2 border-gray-200 p-4 text-center hover:border-primary transition peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white">
                                <div class="text-2xl mb-1">👨‍🏫</div>
                                <div class="font-semibold text-sm">{{ app()->getLocale() == 'ar' ? 'معلم' : 'Tutor' }}</div>
                                <div class="text-xs mt-1 opacity-80">{{ app()->getLocale() == 'ar' ? 'علّم واكسب' : 'Teach & earn' }}</div>
                            </div>
                        </label>
                    </div>
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

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-text-dark mb-2">
                        {{ app()->getLocale() == 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="••••••••">
                </div>

                <!-- Terms -->
                <div class="flex items-start gap-3">
                    <input type="checkbox" name="terms" id="terms" required 
                        class="h-5 w-5 text-primary focus:ring-primary border-gray-300 rounded mt-0.5">
                    <label for="terms" class="text-sm text-gray-600">
                        {{ app()->getLocale() == 'ar' ? 'أوافق على' : 'I agree to the' }}
                        <a href="#" class="text-primary hover:text-green-800 font-medium">{{ app()->getLocale() == 'ar' ? 'شروط الخدمة' : 'Terms of Service' }}</a>
                        {{ app()->getLocale() == 'ar' ? 'و' : 'and' }}
                        <a href="#" class="text-primary hover:text-green-800 font-medium">{{ app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full bg-primary hover:bg-green-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                    {{ app()->getLocale() == 'ar' ? 'إنشاء حساب' : 'Register' }}
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">
                    {{ app()->getLocale() == 'ar' ? 'لديك حساب بالفعل؟' : 'Already have an account?' }}
                    <a href="{{ route('login') }}" class="font-semibold text-secondary hover:text-amber-700 transition">
                        {{ app()->getLocale() == 'ar' ? 'تسجيل الدخول' : 'Login' }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
