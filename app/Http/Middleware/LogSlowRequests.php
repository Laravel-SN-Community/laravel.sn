<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogSlowRequests
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Only enable in debug to avoid overhead in production
        if (!config('app.debug')) {
            return $next($request);
        }

        $queries = [];

        DB::listen(function ($query) use (&$queries) {
            $queries[] = [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time, // milliseconds
            ];
        });

        $start = microtime(true);

        $response = $next($request);

        $duration = (microtime(true) - $start) * 1000; // ms

        // Only log admin panel requests to keep logs focused
        if ($request->is('admin') || $request->is('admin/*')) {
            $summary = [
                'path' => $request->path(),
                'method' => $request->method(),
                'duration_ms' => round($duration, 1),
                'query_count' => count($queries),
                'queries_sample' => array_slice($queries, 0, 20),
            ];

            // Use warning for slow requests (> 1000ms), debug otherwise
            if ($duration > 1000 || count($queries) > 50) {
                Log::warning('Slow admin request detected', $summary);
            } else {
                Log::debug('Admin request summary', $summary);
            }
        }

        return $response;
    }
}
