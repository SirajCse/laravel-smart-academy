<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Forgot password controller.
 *
 * Replaces CI3 controllers/Site.php::forgotpassword() / resetpassword().
 *
 * Handles BOTH staff (admin) and student/parent password resets via
 * separate routes:
 *   - admin.password.request / admin.password.email
 *   - student.password.request / student.password.email
 */
class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.admin.forgot');
    }

    public function showUserLinkRequestForm()
    {
        return view('auth.student.forgot');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $staff = Staff::where('email', $request->email)->first();

        if (! $staff) {
            return back()->withErrors(['email' => __('We could not find that email in our records.')]);
        }

        $token = Str::random(60);
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $staff->email],
            ['token' => $token, 'created_at' => now()]
        );

        Mail::to($staff->email)->send(new \App\Mail\StaffPasswordReset($staff, $token));

        return back()->with('success', __('Password reset link sent to your email.'));
    }

    public function sendUserResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => __('We could not find that email in our records.')]);
        }

        $token = Str::random(60);
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        Mail::to($user->email)->send(new \App\Mail\UserPasswordReset($user, $token));

        return back()->with('success', __('Password reset link sent to your email.'));
    }
}
