<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeSessionGroup;
use Illuminate\Http\Request;

class FeesessiongroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('rbac:feesessiongroup.view')->only(['index', 'show']);
        $this->middleware('rbac:feesessiongroup.create')->only(['create', 'store']);
        $this->middleware('rbac:feesessiongroup.edit')->only(['edit', 'update']);
        $this->middleware('rbac:feesessiongroup.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $records = FeeSessionGroup::with(['session', 'groupType.group', 'groupType.type'])->latest()->paginate(25);
        return view('admin.feesessiongroup.index', compact('records'));
    }

    public function create()
    {
        return view('admin.feesessiongroup.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'session_id' => 'required|integer',
            'fee_groups_feetype_id' => 'required|integer',
        ]);
        FeeSessionGroup::create($data);
        return redirect()->route('admin.feesessiongroup.index')->with('success', __('Created.'));
    }

    public function show(FeeSessionGroup $feesessiongroup)
    {
        $record = $feesessiongroup;
        return view('admin.feesessiongroup.show', compact('record'));
    }

    public function edit(FeeSessionGroup $feesessiongroup)
    {
        $record = $feesessiongroup;
        return view('admin.feesessiongroup.edit', compact('record'));
    }

    public function update(Request $request, FeeSessionGroup $feesessiongroup)
    {
        $feesessiongroup->update($request->all());
        return redirect()->route('admin.feesessiongroup.index')->with('success', __('Updated.'));
    }

    public function destroy(FeeSessionGroup $feesessiongroup)
    {
        $feesessiongroup->delete();
        return redirect()->route('admin.feesessiongroup.index')->with('success', __('Deleted.'));
    }
}
