<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Admin / staff authentication controller.
 *
 * Replaces CI3 controllers/Site.php::login() / logout() / forgotpassword().
 */
class AdminLoginController extends Controller
{
    public function __construct(private AuthManager $auth) {}

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'remember' => 'boolean',
        ]);

        $ok = $this->auth->attemptAdminLogin(
            $credentials['username'],
            $credentials['password'],
            (bool) ($credentials['remember'] ?? false)
        );

        if (! $ok) {
            throw ValidationException::withMessages([
                'username' => __('These credentials do not match our records.'),
            ]);
        }

        $request->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        $this->auth->logoutAdmin();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
