<?php

declare(strict_types=1);

use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\EnsureUserIsNotSuspended;
use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // In production the app is only reachable through Laravel Cloud's
        // load balancer and edge network, so forwarded headers (notably
        // X-Forwarded-Proto for HTTPS detection) can be trusted.
        $middleware->trustProxies(at: '*');

        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            // Runs on every web request so a suspended account cannot keep a
            // session open by any route, including a remember-me cookie.
            EnsureUserIsNotSuspended::class,
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'verified' => EnsureEmailIsVerified::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function (Response $response, Throwable $e, Request $request) {
            // Maintenance mode gets a bare standalone page (no site layout).
            if ($response->status() === 503) {
                return Inertia::render('maintenance')
                    ->toResponse($request)
                    ->setStatusCode(503);
            }

            if (in_array($response->status(), [403, 404, 503])) {
                return Inertia::render('error', [
                    'status' => $response->status(),
                    'path' => '/'.ltrim($request->path(), '/'),
                ])
                    ->toResponse($request)
                    ->setStatusCode($response->status());
            }

            if (! app()->environment(['local', 'testing']) && $response->status() >= 500) {
                return Inertia::render('error', [
                    'status' => $response->status(),
                    'path' => '/'.ltrim($request->path(), '/'),
                ])
                    ->toResponse($request)
                    ->setStatusCode($response->status());
            }

            return $response;
        });
    })->create();
