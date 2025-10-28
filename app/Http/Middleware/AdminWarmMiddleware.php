<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminWarmMiddleware
{
    /**
     * If admin build artifacts are missing (vite manifest) show a lightweight
     * "preparing admin" page that will poll for readiness. This avoids
     * long server-side exceptions and gives the user immediate feedback.
     */
    public function handle(Request $request, Closure $next)
    {
        // Allow readiness endpoint to work
        if ($request->is('admin/ready')) {
            return $next($request);
        }

        // Only protect admin routes
        if (! $request->is('admin') && ! $request->is('admin/*')) {
            return $next($request);
        }

        // If the Vite manifest is missing, consider the admin not ready.
        // public/build/manifest.json is where Laravel's Vite expects the build.
        $manifestPath = public_path('build/manifest.json');

        if (! file_exists($manifestPath)) {
            Log::info('AdminWarm: manifest missing, showing warming page', ['manifest' => $manifestPath]);
            return response()->view('admin.warming');
        }

        return $next($request);
    }
}
