<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeworkEvaluation;
use Illuminate\Http\Request;

class HomeworkEvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:homework-evaluation.view');
    }

    public function index(Request $request)
    {
        $records = HomeworkEvaluation::with(['homework.subject', 'studentSession.student'])->latest()->paginate(25);
        return view('admin.homework-evaluation.index', compact('records'));
    }

    public function show(HomeworkEvaluation $homework_evaluation)
    {
        $record = $homework_evaluation;
        $record->load(['homework', 'studentSession.student']);
        return view('admin.homework-evaluation.show', compact('record'));
    }
}
