<?php

namespace App\Providers;

use App\Auth\AdminGuard;
use App\Auth\StudentGuard;
use App\Services\RbacService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function (?Authenticatable $user, string $ability) {
            if ($user instanceof \App\Models\Staff && app(RbacService::class)->isSuperAdmin($user)) {
                return true;
            }
            $staff = Auth::guard('admin')->user();
            if ($staff instanceof \App\Models\Staff && app(RbacService::class)->isSuperAdmin($staff)) {
                return true;
            }
            return null;
        });

        Auth::extend('admin', function ($app, string $name, array $config) {
            return new AdminGuard(
                Auth::createUserProvider($config['provider'] ?? 'staff'),
                $app->make('request'),
                $app->make('session.store'),
                $name,
            );
        });

        Auth::extend('student', function ($app, string $name, array $config) {
            return new StudentGuard(
                Auth::createUserProvider($config['provider'] ?? 'users'),
                $app->make('request'),
                $app->make('session.store'),
                $name,
            );
        });
    }
}
