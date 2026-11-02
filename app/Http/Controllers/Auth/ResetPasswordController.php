<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.admin.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function showUserResetForm(Request $request, string $token)
    {
        return view('auth.student.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $reset = \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('created_at', '>', now()->subHour())
            ->first();

        if (! $reset) {
            return back()->withErrors(['email' => __('Invalid or expired token.')]);
        }

        $staff = Staff::where('email', $request->email)->first();
        if (! $staff) {
            return back()->withErrors(['email' => __('Staff not found.')]);
        }

        $staff->password = Hash::make($request->password);
        $staff->save();

        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('admin.login')->with('success', __('Password reset. Please login.'));
    }

    public function resetUser(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $reset = \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('created_at', '>', now()->subHour())
            ->first();

        if (! $reset) {
            return back()->withErrors(['email' => __('Invalid or expired token.')]);
        }

        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => __('User not found.')]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('student.login')->with('success', __('Password reset. Please login.'));
    }
}
