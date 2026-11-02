<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BiometricController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:biometric.view');
    }

    public function index(Request $request)
    {
        $records = collect([]);
        return view('admin.biometric.index', ['records' => $records]);
    }

    public function sync(Request $request)
    {
        return back()->with('success', __('Biometric sync initiated.'));
    }
}
