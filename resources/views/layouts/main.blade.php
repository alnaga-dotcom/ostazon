<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'OstazON is the premier tutoring marketplace connecting students with expert tutors across all subjects online.')">
    <meta property="og:title" content="@yield('title', 'OstazON')">
    <meta property="og:description" content="@yield('meta_description', 'OstazON is the premier tutoring marketplace connecting students with expert tutors across all subjects online.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.png'))">
    <meta name="twitter:card" content="summary_large_image">
    <title>@yield('title', 'OstazON')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
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
            --shadow-lg: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
        }
        body { font-family: '{{ app()->getLocale() == 'ar' ? 'Cairo' : 'Inter' }}', sans-serif; }
        [dir="rtl"] .rtl-flip { transform: scaleX(-1); }
        .gradient-text { background: linear-gradient(135deg, #166534, #D97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-gradient { background: linear-gradient(135deg, #F7FEE7 0%, #ECFDF0 50%, #F7FEE7 100%); }

        /* ===== Buttons ===== */
        .btn { display: inline-block; padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; border: none; text-decoration: none; }
        .btn-primary { background-color: #166534; color: #fff; }
        .btn-primary:hover { background-color: #14532d; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(22,101,52,0.3); }
        .btn-accent { background-color: #D97706; color: #fff; }
        .btn-accent:hover { background-color: #b45309; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(217,119,6,0.3); }
        .btn-secondary { background-color: #6B7280; color: #fff; }
        .btn-secondary:hover { background-color: #4B5563; color: #fff; transform: translateY(-1px); }
        .btn-outline { background: transparent; border: 2px solid #D1D5DB; color: var(--text-dark); padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; text-decoration: none; display: inline-block; }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); transform: translateY(-1px); }

        /* ===== Forms ===== */
        .input, .form-input { width: 100%; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; transition: border-color 0.2s, box-shadow 0.2s; background: white; }
        .input:focus, .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(22,101,52,0.1); outline: none; }
        .input-error { border-color: var(--danger); }
        textarea.input { resize: vertical; min-height: 100px; }
        select.input { appearance: auto; }

        /* ===== Cards ===== */
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .tutor-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .tutor-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,0.15), 0 8px 20px -8px rgba(0,0,0,0.1); border-color: var(--primary) !important; }

        /* ===== Admin Tables ===== */
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th { text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; padding: 14px 20px; font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; background: #F9FAFB; border-bottom: 2px solid #E5E7EB; position: sticky; top: 0; z-index: 1; }
        .admin-table td { padding: 14px 20px; font-size: 14px; border-bottom: 1px solid #F3F4F6; }
        .admin-table tbody tr:nth-child(even) td { background: #F9FAFB; }
        .admin-table tbody tr:hover td { background: #ECFDF0; }

        /* ===== Mobile Nav ===== */
        .mobile-nav { transition: max-height 0.35s ease, opacity 0.25s ease, visibility 0.25s ease; max-height: 0; opacity: 0; visibility: hidden; overflow: hidden; }
        .mobile-nav.open { max-height: 500px; opacity: 1; visibility: visible; }

        /* ===== RTL Helpers ===== */
        [dir="rtl"] .admin-table th, [dir="rtl"] .admin-table td { text-align: right; }
        [dir="rtl"] .flex-row-reverse-rtl { flex-direction: row-reverse; }
        [dir="rtl"] .tutor-card .rtl-avatar-fix { transform: translateX(50%); }

        /* ===== Responsive Admin Grid ===== */
        @media (max-width: 768px) { .action-grid-responsive { grid-template-columns: 1fr 1fr !important; } }
        @media (max-width: 480px) { .action-grid-responsive { grid-template-columns: 1fr !important; } }

        /* ===== Smooth Scrollbar ===== */
        .table-wrap { overflow-x: auto; border-radius: 12px; }

        .text-accent { color: #D97706; }
        .bg-accent { background-color: #D97706; }
        .border-accent { border-color: #D97706; }

        /* ===== Notification Dropdown ===== */
        .notification-dropdown { position: relative; }
        #notif-dropdown { position: absolute; right: 0; top: 100%; margin-top: 8px; }
        #notif-dropdown::-webkit-scrollbar { width: 6px; }
        #notif-dropdown::-webkit-scrollbar-thumb { background: #ccc; border-radius: 3px; }
    </style>
    @stack('styles')
</head>
<body class="bg-orange-50 text-text-dark min-h-screen flex flex-col">

    <!-- Navigation -->
    <nav class="bg-primary text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="OstazON" class="h-12 w-auto bg-white rounded-lg p-1">
                        <span class="text-xl font-bold tracking-tight">OstazON</span>
                    </a>
                    @auth
                        <span class="hidden md:inline text-amber-200 text-sm font-medium border-s border-white/30 ps-3">{{ auth()->user()->name }}</span>
                    @endauth
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ url('/') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.home') }}</a>
                    <a href="{{ url('/tutors') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.tutors') }}</a>
                    <a href="{{ route('marketplace.index') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.marketplace') }}</a>

                    @auth
                        @php
                            $dashboardRoute = auth()->user()->isAdmin() ? 'admin.dashboard' : (auth()->user()->isTutor() ? 'tutor.dashboard' : 'student.dashboard');
                            $unreadNotifications = auth()->user()->unreadNotifications->count();
                        @endphp
                        <a href="{{ route($dashboardRoute) }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.dashboard') }}</a>
                        <div class="relative notification-dropdown">
                            <button onclick="toggleNotifications()" class="hover:text-amber-200 transition font-medium relative">
                                <svg class="inline-block w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                @if($unreadNotifications > 0)
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold" style="font-size: 10px;">{{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}</span>
                                @endif
                            </button>
                            <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-200 z-50" style="max-height: 400px; overflow-y: auto;">
                                <div class="p-3 border-b border-gray-100 flex justify-between items-center">
                                    <span class="font-bold text-gray-800 text-sm">{{ app()->getLocale() == 'ar' ? 'الإشعارات' : 'Notifications' }}</span>
                                    @if($unreadNotifications > 0)
                                        <a href="{{ route('notifications.read') }}" class="text-xs text-primary hover:text-secondary font-medium">{{ app()->getLocale() == 'ar' ? 'تحديد الكل كمقروء' : 'Mark all as read' }}</a>
                                    @endif
                                </div>
                                @php $recentNotifs = auth()->user()->notifications()->take(5)->get(); @endphp
                                @forelse($recentNotifs as $notif)
                                    @php $data = $notif->data; @endphp
                                    <a href="{{ $data['action_url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 {{ $notif->read_at ? '' : 'bg-blue-50' }}" onclick="event.preventDefault(); markAsRead('{{ $notif->id }}', '{{ $data['action_url'] ?? '#' }}')">
                                        <div class="font-semibold text-sm text-gray-800">{{ $data['title'] ?? 'Notification' }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $data['message'] ?? '' }}</div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</div>
                                    </a>
                                @empty
                                    <div class="p-6 text-center text-gray-400 text-sm">{{ app()->getLocale() == 'ar' ? 'لا توجد إشعارات' : 'No notifications' }}</div>
                                @endforelse
                                @if($recentNotifs->count() > 0)
                                    <a href="{{ route('notifications.all') }}" class="block p-3 text-center text-primary text-sm font-medium hover:bg-gray-50 rounded-b-xl">{{ app()->getLocale() == 'ar' ? 'عرض الكل' : 'View all' }}</a>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('chat.inbox') }}" class="hover:text-amber-200 transition font-medium">{{ __('messages.messages') }}</a>
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
                    <button onclick="document.getElementById('mobile-menu').classList.toggle('open')" class="p-2 rounded-md hover:bg-white/10 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-nav md:hidden bg-primary/95 border-t border-white/10">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.home') }}</a>
                <a href="{{ url('/tutors') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.tutors') }}</a>
                <a href="{{ route('marketplace.index') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.marketplace') }}</a>
                @auth
                    @php
                        $dashboardRoute = auth()->user()->isAdmin() ? 'admin.dashboard' : (auth()->user()->isTutor() ? 'tutor.dashboard' : 'student.dashboard');
                    @endphp
                    <div class="px-3 py-2 text-amber-200 text-sm font-medium">{{ auth()->user()->name }}</div>
                    <a href="{{ route($dashboardRoute) }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.dashboard') }}</a>
                    <a href="{{ route('notifications.all') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ app()->getLocale() == 'ar' ? 'الإشعارات' : 'Notifications' }}</a>
                    <a href="{{ route('chat.inbox') }}" class="block px-3 py-2 rounded-md hover:bg-white/10 font-medium">{{ __('messages.messages') }}</a>
                    <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">
                        @csrf
                        <button type="submit" class="text-left w-full hover:text-amber-200 font-medium">{{ __('messages.logout') }}</button>
                    </form>
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
                    <a href="{{ route('privacy') }}" style="color: #A7F3D0; font-size: 14px; text-decoration: none;">{{ app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}</a>
                    <a href="mailto:support@ostazon.com" style="color: #A7F3D0; font-size: 14px; text-decoration: none;">support@ostazon.com</a>
                    <span style="color: #A7F3D0; font-size: 14px;">{{ app()->getLocale() == 'ar' ? '© 2025 OstazON جميع الحقوق محفوظة' : '© 2025 OstazON. All rights reserved.' }}</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleNotifications() {
            document.getElementById('notif-dropdown').classList.toggle('hidden');
        }
        document.addEventListener('click', function(e) {
            var dd = document.getElementById('notif-dropdown');
            if (dd && !dd.parentElement.contains(e.target)) {
                dd.classList.add('hidden');
            }
        });
        function markAsRead(id, url) {
            fetch('/notifications/' + id + '/read', { method: 'GET', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (url && url !== '#') { window.location.href = url; }
        }
    </script>
    @stack('scripts')
</body>
</html>
