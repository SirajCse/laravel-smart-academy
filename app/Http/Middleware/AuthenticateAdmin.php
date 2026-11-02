<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Admin/staff authentication middleware.
 *
 * Replaces CI3's `$this->Auth::is_logged_in()` check that ran in
 * the constructor of `Admin_Controller`. Use as route middleware:
 *
 *     Route::middleware('auth.admin')...
 */
class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('admin')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->guest(route('admin.login'));
        }

        $staff = Auth::guard('admin')->user();

        if (! $staff->is_active) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                ->withErrors(['username' => __('Your account is inactive. Please contact administrator.')]);
        }

        return $next($request);
    }
}
