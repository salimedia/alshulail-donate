<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is set in session
        if (session()->has('locale')) {
            $locale = session('locale');
        }
        // Check if locale is in URL
        elseif ($request->segment(1) && in_array($request->segment(1), config('app.available_locales'))) {
            $locale = $request->segment(1);
            session(['locale' => $locale]);
        }
        // Check browser language
        elseif ($request->header('Accept-Language')) {
            $browserLang = substr($request->header('Accept-Language'), 0, 2);
            $locale = in_array($browserLang, config('app.available_locales')) ? $browserLang : config('app.locale');
        }
        // Fallback to default
        else {
            $locale = config('app.locale');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
