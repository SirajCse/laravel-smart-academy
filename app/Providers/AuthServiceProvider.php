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
	protected $policies = [
		// \App\Models\Student::class => \App\Policies\StudentPolicy::class,
	];

	public function boot(): void
	{
		$this->registerPolicies();

		// Super Admin (role id 7) bypasses every permission check.
		Gate::before(function (?Authenticatable $user, string $ability) {
			return $user && app(RbacService::class)->isSuperAdmin($user) ? true : null;
		});

		Auth::extend('admin', fn ($app, string $name, array $config) => new AdminGuard(
			$name,
			Auth::createUserProvider($config['provider'] ?? 'users'),
			$app['session.store'],
			$app['request']
		));

		Auth::extend('student', fn ($app, string $name, array $config) => new StudentGuard(
			$name,
			Auth::createUserProvider($config['provider'] ?? 'students'),
			$app['session.store'],
			$app['request']
		));
	}
}