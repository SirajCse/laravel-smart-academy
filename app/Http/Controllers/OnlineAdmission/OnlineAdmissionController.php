<?php

namespace App\Http\Controllers\OnlineAdmission;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class OnlineAdmissionController extends Controller
{
    public function index()
    {
        return view('online-admission.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['page_type'] = 'online_admission';
        $record = Content::create($data);
        return redirect()->route('online_admission.review', ['reference' => $record->id])
                         ->with('success', __('Application submitted.'));
    }
}
