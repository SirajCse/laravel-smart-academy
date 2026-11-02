<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Student / parent authentication middleware.
 *
 * Replaces CI3's `$this->Auth::is_logged_in_user()` check that ran
 * in the constructor of `Student_Controller` and `Parent_Controller`.
 */
class AuthenticateStudent
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('student')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->guest(route('student.login'));
        }

        $user = Auth::guard('student')->user();

        if (! $user->is_active) {
            Auth::guard('student')->logout();
            return redirect()->route('student.login')
                ->withErrors(['username' => __('Your account is inactive. Please contact administrator.')]);
        }

        return $next($request);
    }
}
