<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function login() { return redirect()->route('admin.login'); }
    public function userlogin() { return redirect()->route('student.login'); }
    public function logout() { return redirect()->route('admin.logout'); }
    public function userlogout() { return redirect()->route('student.logout'); }
}
