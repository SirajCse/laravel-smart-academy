<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ─── Global middleware ─────────────────────────────────────
        $middleware->append(\App\Http\Middleware\SetAppLocale::class);
        $middleware->append(\App\Http\Middleware\SetTimeZone::class);
        $middleware->append(\App\Http\Middleware\MaintenanceMode::class);
        $middleware->append(\App\Http\Middleware\MultiBranchSwitcher::class);

        // ─── Aliases (replacements for old CI3 libraries) ──────────
        $middleware->alias([
            'auth.admin'        => \App\Http\Middleware\AuthenticateAdmin::class,
            'auth.student'      => \App\Http\Middleware\AuthenticateStudent::class,
            'rbac'              => \App\Http\Middleware\CheckPermission::class,
            'role'              => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'        => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission'=> \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'fee.lock'          => \App\Http\Middleware\FeeLockMiddleware::class,
            'throttle.online'   => \App\Http\Middleware\ThrottleOnlineAdmission::class,
        ]);

        // ─── Web middleware groups (excluded paths) ────────────────
        $middleware->validateCsrfTokens(except: [
            'gateway/*',
            'webhooks/*',
            'cron/*',
            'api/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
