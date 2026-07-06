@extends('layouts.main')

@section('title', 'OstazON - ' . __('messages.hero_title'))

@section('content')

<!-- Hero Section -->
<section class="hero-gradient relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0,50 Q25,30 50,50 T100,50 L100,100 L0,100 Z" fill="#166534"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Text -->
            <div class="text-center lg:text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                <div class="inline-flex items-center bg-white/80 backdrop-blur-sm border border-primary/20 rounded-full px-4 py-2 mb-6 shadow-sm">
                    <span class="w-2 h-2 bg-accent rounded-full mr-2 animate-pulse"></span>
                    <span class="text-base font-bold text-primary">{{ __('messages.money_back_guarantee') }}</span>
                </div>

                <h1 class="text-4xl lg:text-6xl font-extrabold text-text-dark leading-tight mb-6">
                    {{ __('messages.hero_title') }}
                </h1>
                <p class="text-lg lg:text-xl text-gray-600 mb-8 leading-relaxed max-w-2xl">
                    {{ __('messages.hero_subtitle') }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-{{ app()->getLocale() == 'ar' ? 'end' : 'start' }}">
                    <a href="{{ url('/tutors') }}" class="bg-secondary hover:bg-amber-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        {{ __('messages.find_tutor') }}
                    </a>
                    <a href="{{ route('register') }}" class="bg-primary hover:bg-green-800 text-white border-2 border-primary px-8 py-4 rounded-xl font-bold text-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        {{ __('messages.become_tutor') }}
                    </a>
                </div>

                <p class="mt-4 text-sm text-gray-500 flex items-center justify-center lg:justify-{{ app()->getLocale() == 'ar' ? 'end' : 'start' }} gap-1">
                    <svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ __('messages.guarantee_text') }}
                </p>
            </div>

            <!-- Visual -->
            <div class="relative">
                <div class="bg-white rounded-2xl shadow-2xl p-6 border border-primary/10 relative z-10">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-text-dark">{{ __('messages.online') }}</h3>
                            <p class="text-sm text-gray-500">{{ __('messages.find_tutor') }}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 bg-surface rounded-lg p-3">
                            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm">A</div>
                            <div class="flex-1">
                                <div class="font-semibold text-sm">{{ __('messages.math') }}</div>
                                <div class="text-xs text-gray-500">50 {{ __('messages.tutors_count') }}</div>
                            </div>
                            <span class="text-secondary font-bold text-sm">25 {{ __('messages.hour') }}</span>
                        </div>
                        <div class="flex items-center gap-3 bg-surface rounded-lg p-3">
                            <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center text-white font-bold text-sm">P</div>
                            <div class="flex-1">
                                <div class="font-semibold text-sm">{{ __('messages.physics') }}</div>
                                <div class="text-xs text-gray-500">32 {{ __('messages.tutors_count') }}</div>
                            </div>
                            <span class="text-secondary font-bold text-sm">30 {{ __('messages.hour') }}</span>
                        </div>
                        <div class="flex items-center gap-3 bg-surface rounded-lg p-3">
                            <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-white font-bold text-sm">E</div>
                            <div class="flex-1">
                                <div class="font-semibold text-sm">{{ __('messages.english') }}</div>
                                <div class="text-xs text-gray-500">45 {{ __('messages.tutors_count') }}</div>
                            </div>
                            <span class="text-secondary font-bold text-sm">20 {{ __('messages.hour') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Floating elements -->
                <div class="absolute -top-4 {{ app()->getLocale() == 'ar' ? '-left-4' : '-right-4' }} bg-white rounded-lg shadow-lg p-3 border border-accent/20 z-20">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-accent/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <div class="text-xs font-bold text-text-dark">4.9/5</div>
                    </div>
                </div>

                <div class="absolute -bottom-4 {{ app()->getLocale() == 'ar' ? '-right-4' : '-left-4' }} bg-white rounded-lg shadow-lg p-3 border border-secondary/20 z-20">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-secondary/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="text-xs font-bold text-text-dark">{{ __('messages.secure_payments') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Bar -->
<section class="bg-white border-y border-primary/10 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="flex items-center justify-center gap-3">
                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="font-bold text-text-dark text-sm">{{ __('messages.verified_tutors') }}</div>
                    <div class="text-xs text-gray-500">100% {{ __('messages.verified_tutors') }}</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3">
                <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <div class="font-bold text-text-dark text-sm">{{ __('messages.secure_payments') }}</div>
                    <div class="text-xs text-gray-500">Coin System</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3">
                <div class="w-10 h-10 bg-secondary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="font-bold text-text-dark text-sm">{{ __('messages.money_back') }}</div>
                    <div class="text-xs text-gray-500">{{ __('messages.guarantee_text') }}</div>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3">
                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
                <div>
                    <div class="font-bold text-text-dark text-sm">{{ __('messages.rated') }}</div>
                    <div class="text-xs text-gray-500">4.9/5 Average</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section id="how" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-text-dark mb-4">{{ __('messages.how_title') }}</h2>
            <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
        </div>

        <div class="grid md:grid-cols-4 gap-8 relative">
            <!-- Connecting line -->
            <div class="hidden md:block absolute top-1/2 left-0 right-0 h-0.5 bg-primary/20 -translate-y-1/2 z-0"></div>

            @php
                $steps = [
                    ['icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'title' => __('messages.step1_title'), 'desc' => __('messages.step1_desc')],
                    ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => __('messages.step2_title'), 'desc' => __('messages.step2_desc')],
                    ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => __('messages.step3_title'), 'desc' => __('messages.step3_desc')],
                    ['icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'title' => __('messages.step4_title'), 'desc' => __('messages.step4_desc')],
                ];
            @endphp

            @foreach($steps as $index => $step)
                <div class="relative z-10 text-center card-hover bg-bg-lime rounded-2xl p-6 border border-primary/10">
                    <div class="w-16 h-16 bg-secondary text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold shadow-lg">
                        {{ $index + 1 }}
                    </div>
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-text-dark mb-2">{{ $step['title'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section id="why" class="py-20 bg-bg-lime">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-text-dark mb-4">{{ __('messages.why_title') }}</h2>
            <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $features = [
                    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'primary', 'title' => __('messages.why1_title'), 'desc' => __('messages.why1_desc')],
                    ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'color' => 'accent', 'title' => __('messages.why2_title'), 'desc' => __('messages.why2_desc')],
                    ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'secondary', 'title' => __('messages.why3_title'), 'desc' => __('messages.why3_desc')],
                    ['icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3', 'color' => 'primary', 'title' => __('messages.why4_title'), 'desc' => __('messages.why4_desc')],
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'accent', 'title' => __('messages.why5_title'), 'desc' => __('messages.why5_desc')],
                    ['icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', 'color' => 'secondary', 'title' => __('messages.why6_title'), 'desc' => __('messages.why6_desc')],
                ];
            @endphp

            @foreach($features as $feature)
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition card-hover border border-primary/5">
                    <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-text-dark mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-primary text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold">{{ __('messages.stats_title') }}</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl lg:text-5xl font-extrabold text-secondary mb-2">500+</div>
                <div class="text-green-100 font-medium">{{ __('messages.tutors_count') }}</div>
            </div>
            <div>
                <div class="text-4xl lg:text-5xl font-extrabold text-secondary mb-2">2,000+</div>
                <div class="text-green-100 font-medium">{{ __('messages.students_count') }}</div>
            </div>
            <div>
                <div class="text-4xl lg:text-5xl font-extrabold text-secondary mb-2">10,000+</div>
                <div class="text-green-100 font-medium">{{ __('messages.lessons_count') }}</div>
            </div>
            <div>
                <div class="text-4xl lg:text-5xl font-extrabold text-secondary mb-2">98%</div>
                <div class="text-green-100 font-medium">{{ __('messages.satisfaction') }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Subjects -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-text-dark mb-4">{{ __('messages.subjects_title') }}</h2>
            <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @php
                $subjects = [
                    ['name' => __('messages.math'), 'icon' => '∫', 'color' => 'bg-blue-50 text-blue-600'],
                    ['name' => __('messages.physics'), 'icon' => '⚛', 'color' => 'bg-purple-50 text-purple-600'],
                    ['name' => __('messages.chemistry'), 'icon' => '⚗', 'color' => 'bg-green-50 text-green-600'],
                    ['name' => __('messages.biology'), 'icon' => '🧬', 'color' => 'bg-pink-50 text-pink-600'],
                    ['name' => __('messages.english'), 'icon' => 'A', 'color' => 'bg-red-50 text-red-600'],
                    ['name' => __('messages.arabic_lang'), 'icon' => 'ع', 'color' => 'bg-amber-50 text-amber-600'],
                    ['name' => __('messages.programming'), 'icon' => '</>', 'color' => 'bg-gray-50 text-gray-600'],
                    ['name' => __('messages.history'), 'icon' => '🏛', 'color' => 'bg-orange-50 text-orange-600'],
                    ['name' => __('messages.geography'), 'icon' => '🌍', 'color' => 'bg-teal-50 text-teal-600'],
                    ['name' => __('messages.economics'), 'icon' => '📈', 'color' => 'bg-indigo-50 text-indigo-600'],
                    ['name' => __('messages.french'), 'icon' => 'F', 'color' => 'bg-blue-50 text-blue-700'],
                    ['name' => __('messages.science'), 'icon' => '🔬', 'color' => 'bg-cyan-50 text-cyan-600'],
                ];
            @endphp

            @foreach($subjects as $subject)
                <a href="{{ url('/tutors?subject=' . urlencode($subject['name'])) }}" class="group bg-bg-lime hover:bg-primary hover:text-white rounded-xl p-4 transition-all duration-300 border border-primary/10 flex items-center gap-3 card-hover">
                    <div class="w-10 h-10 {{ $subject['color'] }} group-hover:bg-white group-hover:text-primary rounded-lg flex items-center justify-center font-bold text-sm transition">
                        {{ $subject['icon'] }}
                    </div>
                    <span class="font-semibold text-sm">{{ $subject['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Tutors -->
<section class="py-20 bg-bg-lime">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-text-dark mb-4">{{ __('messages.featured_tutors') }}</h2>
            <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
                $tutors = [
                    ['name' => 'Dr. Ahmed Hassan', 'subject' => __('messages.math'), 'price' => 30, 'rating' => 4.9, 'reviews' => 127, 'tags' => [__('messages.online'), __('messages.exam_prep')]],
                    ['name' => 'Ms. Sarah Khalil', 'subject' => __('messages.english'), 'price' => 25, 'rating' => 4.8, 'reviews' => 89, 'tags' => [__('messages.online'), __('messages.assignment_help')]],
                    ['name' => 'Dr. Omar Farouk', 'subject' => __('messages.physics'), 'price' => 35, 'rating' => 5.0, 'reviews' => 203, 'tags' => [__('messages.in_person'), __('messages.exam_prep')]],
                ];
            @endphp

            @foreach($tutors as $tutor)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden border border-primary/5 card-hover">
                    <div class="h-24 bg-gradient-to-r from-primary to-accent relative">
                        <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                            <div class="w-20 h-20 bg-white rounded-full p-1 shadow-lg">
                                <div class="w-full h-full bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold text-xl">
                                    {{ substr($tutor['name'], 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-12 pb-6 px-6 text-center">
                        <h3 class="font-bold text-text-dark text-lg">{{ $tutor['name'] }}</h3>
                        <p class="text-primary font-medium text-sm mb-3">{{ $tutor['subject'] }}</p>

                        <div class="flex items-center justify-center gap-1 mb-3">
                            <div class="flex text-amber-400">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 {{ $i < floor($tutor['rating']) ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">({{ $tutor['reviews'] }})</span>
                        </div>

                        <div class="flex flex-wrap justify-center gap-2 mb-4">
                            @foreach($tutor['tags'] as $tag)
                                <span class="px-2 py-1 bg-surface text-primary text-xs rounded-md font-medium">{{ $tag }}</span>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-primary font-bold text-lg">{{ $tutor['price'] }} <span class="text-sm text-gray-500 font-normal">/ {{ __('messages.hour') }}</span></span>
                            <div class="flex gap-2">
                                <a href="#" class="px-3 py-2 bg-surface text-primary rounded-lg text-sm font-semibold hover:bg-primary hover:text-white transition">{{ __('messages.view_profile') }}</a>
                                <a href="#" class="px-3 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-green-800 transition">{{ __('messages.book_now') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ url('/tutors') }}" class="inline-flex items-center gap-2 text-primary font-bold hover:text-green-800 transition">
                {{ __('messages.find_tutor') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-text-dark mb-4">{{ __('messages.testimonials_title') }}</h2>
            <div class="w-20 h-1 bg-secondary mx-auto rounded-full"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
                $testimonials = [
                    ['text' => __('messages.testimonial1_text'), 'author' => __('messages.testimonial1_author'), 'role' => __('messages.testimonial1_role'), 'initial' => 'A'],
                    ['text' => __('messages.testimonial2_text'), 'author' => __('messages.testimonial2_author'), 'role' => __('messages.testimonial2_role'), 'initial' => 'F'],
                    ['text' => __('messages.testimonial3_text'), 'author' => __('messages.testimonial3_author'), 'role' => __('messages.testimonial3_role'), 'initial' => 'M'],
                ];
            @endphp

            @foreach($testimonials as $t)
                <div class="bg-bg-lime rounded-2xl p-8 border border-primary/10 relative card-hover">
                    <div class="absolute -top-4 {{ app()->getLocale() == 'ar' ? 'right-6' : 'left-6' }} w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="flex text-amber-400 mb-4">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed italic">"{{ $t['text'] }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold">{{ $t['initial'] }}</div>
                        <div>
                            <div class="font-bold text-text-dark text-sm">{{ $t['author'] }}</div>
                            <div class="text-xs text-gray-500">{{ $t['role'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-primary relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0,0 L100,100 L100,0 Z" fill="white"/>
        </svg>
    </div>
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <h2 class="text-3xl lg:text-5xl font-extrabold text-white mb-6">{{ __('messages.cta_title') }}</h2>
        <p class="text-xl text-green-100 mb-10">{{ __('messages.cta_subtitle') }}</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="bg-white hover:bg-gray-100 text-secondary px-10 py-4 rounded-xl font-bold text-lg border-2 border-white shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                {{ __('messages.join_now') }}
            </a>
            <a href="{{ url('/tutors') }}" class="bg-secondary hover:bg-amber-700 text-white px-10 py-4 rounded-xl font-bold text-lg shadow-lg transition">
                {{ __('messages.find_tutor') }}
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-text-dark text-white pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8 mb-12">
            <!-- Brand -->
            <div class="md:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="OstazON" class="h-10 w-auto bg-white rounded-lg p-1">
                    <span class="text-xl font-bold">OstazON</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    {{ app()->getLocale() == 'ar' ? 'منصة التعليم الأولى في المنطقة. نربط الطلاب بأفضل المعلمين بأمان وثقة.' : 'The leading tutoring marketplace in the region. Connecting students with top tutors safely and securely.' }}
                </p>
            </div>

            <!-- For Students -->
            <div>
                <h4 class="font-bold text-lg mb-4 text-amber-300">{{ __('messages.footer_students') }}</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ url('/tutors') }}" class="hover:text-white transition">{{ __('messages.find_tutor_footer') }}</a></li>
                    <li><a href="{{ url('/#how') }}" class="hover:text-white transition">{{ __('messages.how_to_book') }}</a></li>
                    <li><a href="#" class="hover:text-white transition">{{ __('messages.safety') }}</a></li>
                </ul>
            </div>

            <!-- For Tutors -->
            <div>
                <h4 class="font-bold text-lg mb-4 text-amber-300">{{ __('messages.footer_tutors') }}</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('register') }}" class="hover:text-white transition">{{ __('messages.become_tutor_footer') }}</a></li>
                    <li><a href="#" class="hover:text-white transition">{{ __('messages.tutor_faq') }}</a></li>
                </ul>
            </div>

            <!-- Company -->
            <div>
                <h4 class="font-bold text-lg mb-4 text-amber-300">{{ __('messages.footer_company') }}</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white transition">{{ __('messages.about_us') }}</a></li>
                    <li><a href="#" class="hover:text-white transition">{{ __('messages.contact') }}</a></li>
                    <li><a href="#" class="hover:text-white transition">{{ __('messages.terms') }}</a></li>
                    <li><a href="#" class="hover:text-white transition">{{ __('messages.privacy') }}</a></li>
                    <li><a href="#" class="hover:text-white transition">{{ __('messages.arbitration_policy') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm">© {{ date('Y') }} OstazON. {{ __('messages.all_rights') }}.</p>
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-500">{{ __('messages.money_back_guarantee') }}</span>
                <span class="text-xs text-gray-500">|</span>
                <span class="text-xs text-gray-500">{{ __('messages.secure_payments') }}</span>
            </div>
        </div>
    </div>
</footer>

@endsection
