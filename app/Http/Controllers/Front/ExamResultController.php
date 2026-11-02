<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    public function index()
    {
        $records = ExamResult::where('is_active', 1)->latest()->paginate(12);
        return view('front.examresult', compact('records'));
    }

    public function show(ExamResult $record)
    {
        return view('front.examresult.show', compact('record'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $record = ExamResult::create($data);
        return redirect()->back()->with('success', __('Saved.'));
    }
}
