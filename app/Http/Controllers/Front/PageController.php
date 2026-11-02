<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FrontcmsPage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $records = FrontcmsPage::where('is_active', 1)->latest()->paginate(12);
        return view('front.page', compact('records'));
    }

    public function show(FrontcmsPage $record)
    {
        return view('front.page.show', compact('record'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $record = FrontcmsPage::create($data);
        return redirect()->back()->with('success', __('Saved.'));
    }
}
