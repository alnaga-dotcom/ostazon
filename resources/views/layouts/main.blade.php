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
                        'text-dark': '#14532D',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
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

        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
    </style>
    @stack('styles')
</head>
<body class="bg-bg-lime text-text-dark min-h-screen flex flex-col">

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
                    <a href="{{ url('/#how') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.how_it_works') }}</a>
                    <a href="{{ url('/#why') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.why_us') }}</a>

                    @auth
                        <a href="{{ url('/dashboard') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.dashboard') }}</a>
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
                <a href="{{ url('/#how') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.how_it_works') }}</a>
                <a href="{{ url('/#why') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.why_us') }}</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.dashboard') }}</a>
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

    @stack('scripts')
</body>
</html>
