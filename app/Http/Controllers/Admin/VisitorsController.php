<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry; // Reuse Enquiry as visitor log placeholder
use Illuminate\Http\Request;

class VisitorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:front_office.view');
    }

    public function index(Request $request)
    {
        $records = Enquiry::latest()->paginate(25);
        return view('admin.visitors.index', compact('records'));
    }
}
