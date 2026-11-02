<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $records = Holiday::where('is_active', 1)->latest()->paginate(12);
        return view('front.events', compact('records'));
    }

    public function show(Holiday $record)
    {
        return view('front.events.show', compact('record'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $record = Holiday::create($data);
        return redirect()->back()->with('success', __('Saved.'));
    }
}
