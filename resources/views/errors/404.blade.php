<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found - OstazON</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#166534',
                        secondary: '#D97706',
                        accent: '#10B981',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-bg-lime min-h-screen flex items-center justify-center p-4">
    <div class="text-center max-w-md">
        <div class="text-8xl font-extrabold text-primary/20 mb-4">404</div>
        <h1 class="text-3xl font-extrabold text-text-dark mb-3">Page Not Found</h1>
        <p class="text-gray-600 mb-8">The page you're looking for doesn't exist or has been moved.</p>
        <a href="{{ url('/') }}" class="btn btn-primary text-base px-8 py-3">Go Home</a>
    </div>
</body>
</html>