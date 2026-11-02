<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Services\RbacService;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    public array $policies = [
        // \App\Models\Student::class => \App\Policies\StudentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // ─── Implicit blade @can super-admin bypass ───────────────
        // Mirrors CI3 behaviour: Super Admin (role id 7) short-circuits
        // every permission check to true.
        Gate::before(function ($user, string $ability) {
            if (app(RbacService::class)->isSuperAdmin($user)) {
                return true;
            }
            return null;
        });

        // ─── Custom guard definitions ─────────────────────────────
        Auth::extend('admin', function ($app, string $name, array $config) {
            return new \App\Auth\AdminGuard(
                Auth::createUserProvider($config['provider'] ?? 'users'),
                $app['request'],
                $app['session.store']
            );
        });

        Auth::extend('student', function ($app, string $name, array $config) {
            return new \App\Auth\StudentGuard(
                Auth::createUserProvider($config['provider'] ?? 'students'),
                $app['request'],
                $app['session.store']
            );
        });
    }
}
