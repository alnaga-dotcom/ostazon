<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OstazON')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#166534',
                        secondary: '#D97706',
                        accent: '#10B981',
                        danger: '#DC2626',
                        surface: '#ECFDF0',
                        'bg-lime': '#F7FEE7',
                        'bg-orange-50': '#FFF7ED',
                        'text-dark': '#14532D',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #166534;
            --primary-light: #ECFDF0;
            --secondary: #D97706;
            --accent: #10B981;
            --danger: #DC2626;
            --text-light: #4b5563;
            --text-dark: #14532D;
            --bg: #FFF7ED;
            --bg-lime: #F7FEE7;
            --surface: #ECFDF0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }
        body { font-family: '{{ app()->getLocale() == 'ar' ? 'Cairo' : 'Inter' }}', sans-serif; }
        [dir="rtl"] .rtl-flip { transform: scaleX(-1); }
        .gradient-text { background: linear-gradient(135deg, #166534, #D97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-gradient { background: linear-gradient(135deg, #F7FEE7 0%, #ECFDF0 50%, #F7FEE7 100%); }
        .card-hover { transition: all 0.3s ease; }
        
        .btn-primary { background-color: #166534; }
        .btn-primary:hover { background-color: #14532d; }
        .btn-accent { background-color: #D97706; }
        .btn-accent:hover { background-color: #b45309; }
        .text-accent { color: #D97706; }
        .bg-accent { background-color: #D97706; }
        .border-accent { border-color: #D97706; }
        .btn-outline { background: transparent; border: 2px solid; padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; }

        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
    </style>
    @stack('styles')
</head>
<body class="bg-orange-50 text-text-dark min-h-screen flex flex-col">

    <!-- Navigation -->
    <nav class="bg-primary text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="OstazON" class="h-12 w-auto bg-white rounded-lg p-1">
                        <span class="text-xl font-bold tracking-tight">OstazON</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ url('/') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.home') }}</a>
                    <a href="{{ url('/tutors') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.tutors') }}</a>
                    <a href="{{ route('marketplace.index') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.marketplace') }}</a>
                    <a href="{{ url('/#how') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.how_it_works') }}</a>
                    <a href="{{ url('/#why') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.why_us') }}</a>

                    @auth
                        @php
                            $dashboardRoute = auth()->user()->isAdmin() ? 'admin.dashboard' : (auth()->user()->isTutor() ? 'tutor.dashboard' : 'student.dashboard');
                        @endphp
                        <a href="{{ route($dashboardRoute) }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.dashboard') }}</a>
                        <a href="{{ route('chat.inbox') }}" class="hover:text-amber-200 transition font-medium">💬 {{ __('messages.messages') }}</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-amber-200 transition font-medium">{{ __('messages.logout') }}</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.login') }}</a>
                        <a href="{{ route('register') }}" class="bg-secondary hover:bg-amber-600 text-white px-4 py-2 rounded-lg font-semibold transition shadow-md">{{ __('messages.register') }}</a>
                    @endauth

                    <!-- Language Toggle -->
                    <div class="flex items-center bg-white/20 rounded-lg p-1">
                        <a href="{{ url()->current() }}?locale=ar" 
                           class="px-3 py-1 rounded-md text-sm font-semibold transition {{ app()->getLocale() == 'ar' ? 'bg-white text-primary' : 'text-white hover:bg-white/10' }}">
                            {{ __('messages.arabic') }}
                        </a>
                        <a href="{{ url()->current() }}?locale=en" 
                           class="px-3 py-1 rounded-md text-sm font-semibold transition {{ app()->getLocale() == 'en' ? 'bg-white text-primary' : 'text-white hover:bg-white/10' }}">
                            {{ __('messages.english') }}
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="p-2 rounded-md hover:bg-white/10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-primary/95 border-t border-white/10">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.home') }}</a>
                <a href="{{ url('/tutors') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.tutors') }}</a>
                <a href="{{ route('marketplace.index') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.marketplace') }}</a>
                <a href="{{ url('/#how') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.how_it_works') }}</a>
                <a href="{{ url('/#why') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.why_us') }}</a>
                @auth
                    @php
                        $dashboardRoute = auth()->user()->isAdmin() ? 'admin.dashboard' : (auth()->user()->isTutor() ? 'tutor.dashboard' : 'student.dashboard');
                    @endphp
                    <a href="{{ route($dashboardRoute) }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.dashboard') }}</a>
                    <a href="{{ route('chat.inbox') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">💬 {{ __('messages.messages') }}</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.login') }}</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md bg-secondary font-medium">{{ __('messages.register') }}</a>
                @endauth
                <div class="flex px-3 py-2 gap-2">
                    <a href="{{ url()->current() }}?locale=ar" class="px-3 py-1 rounded bg-white/20 text-sm">{{ __('messages.arabic') }}</a>
                    <a href="{{ url()->current() }}?locale=en" class="px-3 py-1 rounded bg-white/20 text-sm">{{ __('messages.english') }}</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background: #14532D; color: white; padding: 32px 24px 24px; margin-top: 48px;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: 32px; justify-content: space-between;">
            <div style="flex: 1; min-width: 200px;">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 12px;">OstazON</h3>
                <p style="color: #A7F3D0; font-size: 14px; line-height: 1.6;">
                    {{ app()->getLocale() == 'ar' ? 'منصة التعلم الرقمي الأولى في العالم العربي' : 'The leading digital learning platform in the Arab world' }}
                </p>
            </div>
            <div style="flex: 1; min-width: 160px;">
                <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 12px; color: #FDE68A;">{{ app()->getLocale() == 'ar' ? 'روابط سريعة' : 'Quick Links' }}</h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <a href="{{ url('/tutors') }}" style="color: #A7F3D0; font-size: 14px; text-decoration: none;">{{ app()->getLocale() == 'ar' ? 'المعلمون' : 'Tutors' }}</a>
                    <a href="{{ route('marketplace.index') }}" style="color: #A7F3D0; font-size: 14px; text-decoration: none;">{{ app()->getLocale() == 'ar' ? 'سوق المحتوى' : 'Marketplace' }}</a>
                    <a href="{{ route('arbitration') }}" style="color: #A7F3D0; font-size: 14px; text-decoration: none;">{{ app()->getLocale() == 'ar' ? 'سياسة التحكيم' : 'Arbitration Policy' }}</a>
                    <a href="{{ route('faq') }}" style="color: #A7F3D0; font-size: 14px; text-decoration: none;">{{ app()->getLocale() == 'ar' ? 'الأسئلة الشائعة' : 'FAQ' }}</a>
                </div>
            </div>
            <div style="flex: 1; min-width: 160px;">
                <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 12px; color: #FDE68A;">{{ app()->getLocale() == 'ar' ? 'الدعم' : 'Support' }}</h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <a href="{{ route('terms') }}" style="color: #A7F3D0; font-size: 14px; text-decoration: none;">{{ app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}</a>
                    <a href="mailto:support@ostazon.com" style="color: #A7F3D0; font-size: 14px; text-decoration: none;">support@ostazon.com</a>
                    <span style="color: #A7F3D0; font-size: 14px;">{{ app()->getLocale() == 'ar' ? '© 2025 OstazON جميع الحقوق محفوظة' : '© 2025 OstazON. All rights reserved.' }}</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
