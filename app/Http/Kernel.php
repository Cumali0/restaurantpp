<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware stack.
     * Uygulama genelinde her istek için çalışır.
     */
    protected $middleware = [
        // Proxies handling
        \App\Http\Middleware\TrustProxies::class,

        // CORS handling
        \Fruitcake\Cors\HandleCors::class,

        // Site maintenance mode
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // Limit post size
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // Trim string inputs
        \App\Http\Middleware\TrimStrings::class,

        // Convert empty strings to null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Middleware groups.
     * Route gruplarında kullanılan middleware setleri.
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,

            // Oturumdaki hataları view ile paylaşır
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            // CSRF koruması
            \App\Http\Middleware\VerifyCsrfToken::class,

            // Route model binding
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // API isteklerini throttle eder
            'throttle:api',

            // Route model binding
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Route middleware.
     * Belirli rotalara tek tek atanabilen middleware'ler.
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];

    /**
     * Middleware priority.
     * Belirli middleware'lerin sırasını belirler.
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ];
}
