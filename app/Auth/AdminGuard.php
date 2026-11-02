<?php

namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Custom session-based guard for staff/admin (replaces CI3's
 * `$this->session->userdata('admin')` blob).
 *
 * NOTE: GuardHelpers declares `protected $user` and `protected $provider`.
 * We must NOT re-declare them with different types in this subclass.
 */
class AdminGuard implements Guard
{
    use GuardHelpers;

    public function __construct(
        UserProvider $provider,
        protected Request $request,
        protected Session $session,
        protected string $name = 'admin',
    ) {
        // Assign to the inherited $provider property (no redeclaration).
        $this->provider = $provider;
    }

    public function user()
    {
        if (! is_null($this->user)) {
            return $this->user;
        }

        $id = $this->session->get('login_admin_id');

        if (! is_null($id) && ($user = $this->provider->retrieveById($id))) {
            $this->user = $user;
        }

        return $this->user;
    }

    public function validate(array $credentials = []): bool
    {
        if (empty($credentials['username']) || empty($credentials['password'])) {
            return false;
        }

        $user = $this->provider->retrieveByCredentials([
            'email' => $credentials['username'],
        ]);

        // Try by email first; fall back to phone/staff_id (handled by EloquentUserProvider
        // via findForPassport on Staff model — but that requires overriding the provider).
        if (! $user) {
            $user = $this->provider->retrieveByCredentials($credentials);
        }

        if (! $user) return false;

        return Hash::check($credentials['password'], $user->getAuthPassword());
    }

    public function attempt(array $credentials = [], $remember = false): bool
    {
        $user = $this->provider->retrieveByCredentials(['email' => $credentials['username']]);

        // Fall back to username/phone/staff_id lookup via the model's findForPassport().
        if (! $user && ($model = $this->provider->getModel()) && method_exists($model, 'findForPassport')) {
            $user = ($model)::findForPassport($credentials['username']);
        }

        if (! $user || ! Hash::check($credentials['password'], $user->getAuthPassword())) {
            return false;
        }

        if (! ($user->is_active ?? true)) {
            return false;
        }

        $this->login($user, $remember);
        return true;
    }

    public function login($user, $remember = false): void
    {
        $this->session->regenerate(true);
        $this->session->put('login_admin_id', $user->getAuthIdentifier());
        $this->setUser($user);
    }

    public function logout(): void
    {
        $this->session->remove('login_admin_id');
        $this->user = null;
    }

    public function logoutEverywhere(): void
    {
        $this->logout();
    }


}
