<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{StudentFeesMaster, StudentFees, Student};
use App\Services\Customlib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentfeeController extends Controller
{
    public function __construct(private Customlib $customlib)
    {
        $this->middleware('rbac:student-fee.view');
    }

    public function index(Request $request)
    {
        $query = StudentFeesMaster::with(['studentSession.student', 'feeSessionGroup.groupType.type']);

        if ($request->has('student_id')) {
            $query->whereHas('studentSession', function ($q) use ($request) {
                $q->where('student_id', $request->student_id);
            });
        }

        $records = $query->latest()->paginate(25);
        return view('admin.student-fee.index', compact('records'));
    }

    public function create()
    {
        $students = Student::where('is_active', 1)->orderBy('firstname')->get();
        return view('admin.student-fee.create', compact('students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_session_id'   => 'required|integer',
            'fee_session_group_id' => 'required|integer',
            'amount'                => 'required|numeric',
            'discount_amount'      => 'nullable|numeric',
        ]);
        $record = StudentFeesMaster::create($data);
        return redirect()->route('admin.student-fee.index')
            ->with('success', __('Fee record created.'));
    }

    public function show(StudentFeesMaster $student_fee)
    {
        $record = $student_fee;
        $record->load(['payments', 'studentSession.student']);
        return view('admin.student-fee.show', compact('record'));
    }

    public function edit(StudentFeesMaster $student_fee)
    {
        $record = $student_fee;
        return view('admin.student-fee.edit', compact('record'));
    }

    public function update(Request $request, StudentFeesMaster $student_fee)
    {
        $student_fee->update($request->all());
        return redirect()->route('admin.student-fee.index')
            ->with('success', __('Fee record updated.'));
    }

    public function destroy(StudentFeesMaster $student_fee)
    {
        $student_fee->delete();
        return redirect()->route('admin.student-fee.index')
            ->with('success', __('Fee record deleted.'));
    }

    public function collect(Request $request, int $id)
    {
        $data = $request->validate([
            'amount'           => 'required|numeric|min:0.01',
            'payment_mode'     => 'required|string',
            'description'      => 'nullable|string',
            'date'             => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $master = StudentFeesMaster::findOrFail($id);
            $fee = StudentFees::create([
                'student_fees_master_id' => $master->id,
                'amount'                  => $data['amount'],
                'amount_discount'        => 0,
                'amount_fine'            => 0,
                'payment_mode'           => $data['payment_mode'],
                'description'             => $data['description'] ?? null,
                'date'                    => $data['date'],
                'received_by'            => auth('admin')->id(),
                'invoice_no'              => $this->customlib->generateInvoiceNumber('INV'),
            ]);

            event(new \App\Events\FeePaymentReceived($fee));

            DB::commit();
            return back()->with('success', __('Fee collected successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Fee collection failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to collect fee.'));
        }
    }

    public function refund(Request $request, int $id)
    {
        $fee = StudentFees::findOrFail($id);
        $fee->delete();
        return back()->with('success', __('Payment refunded (record removed).'));
    }

    public function receipt(int $id)
    {
        $fee = StudentFees::with(['master.studentSession.student'])->findOrFail($id);
        return view('admin.student-fee.receipt', compact('fee'));
    }
}
