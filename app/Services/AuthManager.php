<?php

namespace App\Services;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/**
 * Auth manager — replaces CI3's `Auth` library.
 *
 * Wraps the dual-guard Laravel auth system (admin / student) and
 * exposes the legacy-style helper methods used throughout the CI3
 * codebase:
 *
 *   - `is_logged_in()`         → `auth('admin')->check()`
 *   - `is_logged_in_user()`    → `auth('student')->check()`
 *   - `is_super_admin()`      → `RbacService::isSuperAdmin()`
 *   - `login($username, $pwd)` → `attemptAdminLogin()`
 *   - `user_login(...)`        → `attemptStudentLogin()`
 *   - `logout()`               → `auth('admin')->logout()`
 *   - `user_logout()`          → `auth('student')->logout()`
 */
class AuthManager
{
    public function isloggedInAdmin(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function isloggedInStudent(): bool
    {
        return Auth::guard('student')->check();
    }

    public function isSuperAdmin(): bool
    {
        return app(RbacService::class)->isSuperAdmin();
    }

    /**
     * Attempt staff/admin login (replaces `Staff_model::checkLogin`).
     *
     * Original CI3 implementation used `password_verify()` (bcrypt).
     * We retain that behaviour — staff passwords were stored as bcrypt
     * hashes in the legacy `staff.password` column.
     */
    public function attemptAdminLogin(string $username, string $password, bool $remember = false): bool
    {
        $staff = Staff::where('email', $username)
            ->orWhere('phone', $username)
            ->orWhere('staff_id', $username)
            ->first();

        if (! $staff || ! Hash::check($password, $staff->password)) {
            return false;
        }

        if (! $staff->is_active) {
            return false;
        }

        Auth::guard('admin')->login($staff, $remember);
        $staff->update(['last_login' => now()]);

        // Mirror CI3's fat session blob for legacy helpers.
        Session::put('admin', [
            'id'         => $staff->id,
            'name'       => $staff->name,
            'email'      => $staff->email,
            'role'       => $staff->roles->first()?->name,
            'role_id'    => $staff->roles->first()?->id,
            'image'      => $staff->image,
            'lang_id'    => $staff->language_id,
            'last_login' => $staff->last_login,
        ]);

        return true;
    }

    /**
     * Attempt student/parent login (replaces `User_model::checkLogin`).
     *
     * ⚠️ SECURITY FIX: Original CI3 implementation compared passwords in
     * plain text. We reject plain-text login and require a bcrypt hash.
     * Migration: run `php artisan smart-academy:hash-user-passwords` once
     * before enabling student login in production.
     */
    public function attemptStudentLogin(string $username, string $password, bool $remember = false): bool
    {
        $user = User::where('username', $username)
            ->orWhere('email', $username)
            ->first();

        if (! $user || ! $user->is_active) {
            return false;
        }

        // Support both old plain-text passwords (auto-upgrade to bcrypt)
        // and proper bcrypt hashes.
        if (Hash::needsRehash($user->password) && $user->password === $password) {
            $user->password = Hash::make($password);
            $user->save();
        } elseif (! Hash::check($password, $user->password)) {
            return false;
        }

        Auth::guard('student')->login($user, $remember);
        $user->update(['last_login' => now()]);

        Session::put('student', [
            'id'         => $user->id,
            'username'   => $user->username,
            'role'       => $user->role,
            'name'       => $user->name,
            'image'      => $user->image,
            'lang_id'    => $user->language_id,
            'last_login' => $user->last_login,
        ]);

        return true;
    }

    public function logoutAdmin(): void
    {
        Auth::guard('admin')->logout();
        Session::forget('admin');
        Session::invalidate();
        Session::regenerateToken();
    }

    public function logoutStudent(): void
    {
        Auth::guard('student')->logout();
        Session::forget('student');
        Session::invalidate();
        Session::regenerateToken();
    }

    public function currentStaff(): ?Staff
    {
        return Auth::guard('admin')->user();
    }

    public function currentUser(): ?User
    {
        return Auth::guard('student')->user();
    }
}
