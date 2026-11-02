<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $records = Content::where('is_active', 1)->latest()->paginate(12);
        return view('front.news', compact('records'));
    }

    public function show(Content $record)
    {
        return view('front.news.show', compact('record'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $record = Content::create($data);
        return redirect()->back()->with('success', __('Saved.'));
    }
}
