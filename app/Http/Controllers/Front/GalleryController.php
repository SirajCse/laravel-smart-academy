<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FrontcmsMedia;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $records = FrontcmsMedia::where('is_active', 1)->latest()->paginate(12);
        return view('front.gallery', compact('records'));
    }

    public function show(FrontcmsMedia $record)
    {
        return view('front.gallery.show', compact('record'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $record = FrontcmsMedia::create($data);
        return redirect()->back()->with('success', __('Saved.'));
    }
}
