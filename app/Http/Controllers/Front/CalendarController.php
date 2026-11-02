<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $records = Holiday::where('is_active', 1)->latest()->paginate(12);
        return view('front.calendar', compact('records'));
    }

    public function show(Holiday $record)
    {
        return view('front.calendar.show', compact('record'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $record = Holiday::create($data);
        return redirect()->back()->with('success', __('Saved.'));
    }
}
