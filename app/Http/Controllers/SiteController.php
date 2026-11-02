<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Site controller — back-compat shim for routes/web.php references.
 *
 * The original CI3 controllers/Site.php contained login/logout/forgot logic.
 * Those have been split into Auth\AdminLoginController / StudentLoginController
 * / ForgotPasswordController / ResetPasswordController. This stub exists only
 * to satisfy the use statement in routes/web.php and redirects to the proper
 * auth routes.
 */
class SiteController extends Controller
{
    public function login()
    {
        return redirect()->route('admin.login');
    }

    public function userlogin()
    {
        return redirect()->route('student.login');
    }

    public function logout()
    {
        return redirect()->route('admin.logout');
    }

    public function userlogout()
    {
        return redirect()->route('student.logout');
    }
}
