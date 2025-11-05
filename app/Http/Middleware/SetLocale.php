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
        $browserLocale = explode('_', (string) $request->getPreferredLanguage())[0];
        $activeLocale = session()->get('locale');
        $supportedLocales = config('app.available_locales');

        if (! $activeLocale && in_array($browserLocale, $supportedLocales)) {
            app()->setLocale($browserLocale);
        } else {
            app()->setLocale($activeLocale);
        }

        return $next($request);
    }
}
