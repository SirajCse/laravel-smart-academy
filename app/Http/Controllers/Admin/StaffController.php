<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Role;
use App\Models\Department;
use App\Models\Designation;
use App\Services\MediaStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function __construct(private MediaStorageService $media)
    {
        $this->middleware('rbac:staff.view')->only(['index', 'show']);
        $this->middleware('rbac:staff.create')->only(['create', 'store']);
        $this->middleware('rbac:staff.edit')->only(['edit', 'update']);
        $this->middleware('rbac:staff.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = Staff::with(['department', 'designation', 'roles']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('staff_id', 'like', "%{$search}%");
            });
        }

        $records = $query->latest()->paginate(25);
        return view('admin.staff.index', compact('records'));
    }

    public function create()
    {
        $roles = Role::where('is_active', 1)->pluck('name', 'id');
        $departments = Department::where('is_active', 1)->pluck('department_name', 'id');
        $designations = Designation::where('is_active', 1)->pluck('designation', 'id');
        return view('admin.staff.create', compact('roles', 'departments', 'designations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id'         => 'nullable|string|max:50',
            'role'             => 'nullable|string',
            'department_id'    => 'nullable|integer',
            'designation_id'   => 'nullable|integer',
            'name'             => 'required|string|max:100',
            'email'            => 'nullable|email|max:100|unique:staff,email',
            'phone'            => 'nullable|string|max:20',
            'emergency_phone'  => 'nullable|string|max:20',
            'gender'           => 'nullable|in:male,female,other',
            'image'            => 'nullable|image|max:2048',
            'dob'              => 'nullable|date',
            'joining_date'     => 'nullable|date',
            'leaving_date'     => 'nullable|date',
            'address'          => 'nullable|string',
            'qualification'    => 'nullable|string|max:200',
            'work_experience'  => 'nullable|string|max:200',
            'note'             => 'nullable|string',
            'facebook'         => 'nullable|url',
            'twitter'          => 'nullable|url',
            'linkedin'         => 'nullable|url',
            'instagram'        => 'nullable|url',
            'resume'           => 'nullable|file|max:5120',
            'joining_letter'   => 'nullable|file|max:5120',
            'documents'        => 'nullable|file|max:5120',
            'signature'        => 'nullable|image|max:512',
            'salary'           => 'nullable|numeric',
            'account_number'   => 'nullable|string|max:50',
            'bank_name'        => 'nullable|string|max:100',
            'ifsc_code'        => 'nullable|string|max:20',
            'bank_branch'      => 'nullable|string|max:100',
            'epf_number'       => 'nullable|string|max:50',
            'basic_salary'     => 'nullable|numeric',
            'work_shift'       => 'nullable|string|max:50',
            'work_location'    => 'nullable|string|max:100',
            'is_active'        => 'boolean',
            'password'         => 'required|string|min:6',
            'language_id'      => 'nullable|integer',
            'role_id'           => 'nullable|integer',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $validated['image'] = $this->media->upload($request->file('image'), 'staff_images', 'STF');
            }
            if ($request->hasFile('resume')) {
                $validated['resume'] = $this->media->upload($request->file('resume'), 'staff_documents', 'RSM');
            }
            if ($request->hasFile('joining_letter')) {
                $validated['joining_letter'] = $this->media->upload($request->file('joining_letter'), 'staff_documents', 'JNL');
            }
            if ($request->hasFile('documents')) {
                $validated['documents'] = $this->media->upload($request->file('documents'), 'staff_documents', 'DOC');
            }
            if ($request->hasFile('signature')) {
                $validated['signature'] = $this->media->upload($request->file('signature'), 'staff_images', 'SIG');
            }

            $validated['password'] = Hash::make($validated['password']);
            $validated['is_active'] = (bool) ($validated['is_active'] ?? true);

            $staff = Staff::create($validated);

            // Assign role if provided
            if (! empty($validated['role_id'])) {
                DB::table('staff_roles')->insert([
                    'staff_id' => $staff->id,
                    'role_id'  => $validated['role_id'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.staff.index')
                ->with('success', __('Staff created successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Staff create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create staff.') . ' ' . $e->getMessage());
        }
    }

    public function show(Staff $staff)
    {
        $record = $staff;
        $record->load(['department', 'designation', 'roles']);
        return view('admin.staff.show', compact('record'));
    }

    public function edit(Staff $staff)
    {
        $record = $staff;
        $roles = Role::where('is_active', 1)->pluck('name', 'id');
        $departments = Department::where('is_active', 1)->pluck('department_name', 'id');
        $designations = Designation::where('is_active', 1)->pluck('designation', 'id');
        return view('admin.staff.edit', compact('record', 'roles', 'departments', 'designations'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'staff_id'         => 'nullable|string|max:50',
            'role'             => 'nullable|string',
            'department_id'    => 'nullable|integer',
            'designation_id'   => 'nullable|integer',
            'name'             => 'required|string|max:100',
            'email'            => ['nullable', 'email', Rule::unique('staff', 'email')->ignore($staff->id)],
            'phone'            => 'nullable|string|max:20',
            'emergency_phone'  => 'nullable|string|max:20',
            'gender'           => 'nullable|in:male,female,other',
            'image'            => 'nullable|image|max:2048',
            'dob'              => 'nullable|date',
            'joining_date'     => 'nullable|date',
            'leaving_date'     => 'nullable|date',
            'address'          => 'nullable|string',
            'qualification'    => 'nullable|string|max:200',
            'work_experience'  => 'nullable|string|max:200',
            'note'             => 'nullable|string',
            'salary'           => 'nullable|numeric',
            'account_number'   => 'nullable|string|max:50',
            'bank_name'        => 'nullable|string|max:100',
            'ifsc_code'        => 'nullable|string|max:20',
            'bank_branch'      => 'nullable|string|max:100',
            'epf_number'       => 'nullable|string|max:50',
            'basic_salary'     => 'nullable|numeric',
            'work_shift'       => 'nullable|string|max:50',
            'work_location'    => 'nullable|string|max:100',
            'is_active'        => 'boolean',
            'password'         => 'nullable|string|min:6',
            'language_id'      => 'nullable|integer',
            'role_id'           => 'nullable|integer',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                if ($staff->image) $this->media->delete($staff->image);
                $validated['image'] = $this->media->upload($request->file('image'), 'staff_images', 'STF');
            }

            // Only update password if provided
            if (! empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $validated['is_active'] = (bool) ($validated['is_active'] ?? $staff->is_active);

            $staff->update($validated);

            if (! empty($validated['role_id'])) {
                DB::table('staff_roles')->updateOrInsert(
                    ['staff_id' => $staff->id],
                    ['role_id'  => $validated['role_id']]
                );
            }

            DB::commit();
            return redirect()->route('admin.staff.index')
                ->with('success', __('Staff updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Staff update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update staff.'));
        }
    }

    public function destroy(Staff $staff)
    {
        try {
            if ($staff->image) $this->media->delete($staff->image);
            $staff->delete();
            return redirect()->route('admin.staff.index')
                ->with('success', __('Staff deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Staff delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete staff.'));
        }
    }
}
