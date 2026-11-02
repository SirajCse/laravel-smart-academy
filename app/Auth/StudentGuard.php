<?php

namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Custom session-based guard for students/parents (replaces CI3's
 * `$this->session->userdata('student')` blob).
 */
class StudentGuard implements Guard
{
    use GuardHelpers;

    public function __construct(
        UserProvider $provider,
        protected Request $request,
        protected Session $session,
        protected string $name = 'student',
    ) {
        $this->provider = $provider;
    }

    public function user()
    {
        if (! is_null($this->user)) return $this->user;

        $id = $this->session->get('login_student_id');

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

        $user = $this->provider->retrieveByCredentials(['username' => $credentials['username']]);
        if (! $user) {
            $user = $this->provider->retrieveByCredentials(['email' => $credentials['username']]);
        }

        if (! $user) return false;

        return Hash::check($credentials['password'], $user->getAuthPassword());
    }

    public function attempt(array $credentials = [], $remember = false): bool
    {
        $user = $this->provider->retrieveByCredentials(['username' => $credentials['username']]);
        if (! $user) {
            $user = $this->provider->retrieveByCredentials(['email' => $credentials['username']]);
        }

        if (! $user) return false;

        // Support auto-upgrade of legacy plain-text passwords.
        if (Hash::needsRehash($user->getAuthPassword())) {
            if ($user->getAuthPassword() !== $credentials['password']) {
                return false;
            }
            $user->password = Hash::make($credentials['password']);
            $user->save();
        } elseif (! Hash::check($credentials['password'], $user->getAuthPassword())) {
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
        $this->session->put('login_student_id', $user->getAuthIdentifier());
        $this->setUser($user);
    }

    public function logout(): void
    {
        $this->session->remove('login_student_id');
        $this->user = null;
    }


}
