<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', 'ar'); // Default Arabic

        if ($request->has('locale')) {
            $locale = $request->get('locale');
            session(['locale' => $locale]);
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
