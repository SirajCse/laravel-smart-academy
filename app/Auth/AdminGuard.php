<?php

namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Custom session-based guard for staff/admin (replaces CI3's
 * `$this->session->userdata('admin')` blob).
 *
 * This guard implements `Illuminate\Contracts\Auth\Guard` so it plugs
 * into Laravel's auth system without needing to override too much.
 */
class AdminGuard implements Guard
{
    use GuardHelpers;

    public function __construct(
        protected UserProvider $provider,
        protected Request $request,
        protected Session $session,
        string $name = 'admin',
    ) {
        $this->name = $name;
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

        $user = $this->provider->retrieveByCredentials($credentials);
        if (! $user) return false;

        return Hash::check($credentials['password'], $user->getAuthPassword());
    }

    public function attempt(array $credentials = [], $remember = false): bool
    {
        $user = $this->provider->retrieveByCredentials($credentials);

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
