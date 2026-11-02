<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Student / parent authentication controller.
 *
 * Replaces CI3 controllers/Site.php::userlogin() / userlogout().
 */
class StudentLoginController extends Controller
{
    public function __construct(private AuthManager $auth) {}

    public function showLoginForm()
    {
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }
        return view('auth.student.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'remember' => 'boolean',
        ]);

        $ok = $this->auth->attemptStudentLogin(
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
        return redirect()->intended(route('student.dashboard'));
    }

    public function logout(Request $request)
    {
        $this->auth->logoutStudent();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('student.login');
    }
}
