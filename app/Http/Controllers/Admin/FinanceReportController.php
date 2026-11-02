<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Income, Expense};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:reports.view');
    }

    public function income(Request $request)
    {
        $records = Income::with(['head'])->latest()->paginate(25);
        $total = Income::sum('amount');
        return view('admin.reports.income', compact('records', 'total'));
    }

    public function expense(Request $request)
    {
        $records = Expense::with(['head'])->latest()->paginate(25);
        $total = Expense::sum('amount');
        return view('admin.reports.expense', compact('records', 'total'));
    }

    public function balance(Request $request)
    {
        $income = Income::sum('amount');
        $expense = Expense::sum('amount');
        $balance = $income - $expense;
        return view('admin.reports.balance', compact('income', 'expense', 'balance'));
    }
}
