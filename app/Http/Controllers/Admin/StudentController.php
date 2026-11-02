<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentSession;
use App\Services\Customlib;
use App\Services\MediaStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * Student controller.
 *
 * Replaces CI3 controllers/admin/Student.php (~2000 lines, 30+ methods).
 */
class StudentController extends Controller
{
    public function __construct(
        private Customlib $customlib,
        private MediaStorageService $media,
    ) {
        $this->middleware('rbac:student.view')->only(['index', 'show', 'profile', 'fees', 'attendance', 'examResult']);
        $this->middleware('rbac:student.create')->only(['create', 'store', 'import', 'sampleImport']);
        $this->middleware('rbac:student.edit')->only(['edit', 'update', 'uploadPhoto', 'updateGuardian', 'enable', 'disable']);
        $this->middleware('rbac:student.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = Student::with(['sessions.class', 'sessions.section']);

        if ($classId = $request->get('class_id')) {
            $query->whereHas('sessions', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        if ($sectionId = $request->get('section_id')) {
            $query->whereHas('sessions', function ($q) use ($sectionId) {
                $q->where('section_id', $sectionId);
            });
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('admission_no', 'like', "%{$search}%")
                  ->orWhere('firstname', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('mobileno', 'like', "%{$search}%");
            });
        }

        $students = $query->latest()->paginate(25);

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create', [
            'admissionNo' => $this->customlib->generateAdmissionNo(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_no'    => 'required|string|unique:students,admission_no',
            'roll_no'         => 'nullable|string',
            'admission_date'  => 'nullable|date',
            'firstname'       => 'required|string|max:100',
            'middlename'      => 'nullable|string|max:100',
            'lastname'         => 'required|string|max:100',
            'class_id'        => 'required|integer',
            'section_id'      => 'required|integer',
            'category_id'     => 'nullable|integer',
            'dob'             => 'nullable|date',
            'gender'          => 'nullable|in:male,female,other',
            'blood_group'    => 'nullable|string',
            'mobileno'        => 'nullable|string|max:20',
            'email'           => 'nullable|email|max:100',
            'image'           => 'nullable|image|max:2048',
            'current_address' => 'nullable|string',
            'permanent_address'=> 'nullable|string',
            'guardian_name'   => 'nullable|string|max:100',
            'guardian_phone'  => 'nullable|string|max:20',
            'guardian_email'  => 'nullable|email|max:100',
            'father_name'     => 'nullable|string|max:100',
            'father_phone'    => 'nullable|string|max:20',
            'father_occupation'=> 'nullable|string|max:100',
            'mother_name'     => 'nullable|string|max:100',
            'mother_phone'    => 'nullable|string|max:20',
            'mother_occupation'=> 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $validated['image'] = $this->media->upload($request->file('image'), 'student_images', 'STU');
            }

            $student = Student::create($validated);

            // Enroll in the active session
            $sessionId = $this->customlib->getActiveSessionId();
            StudentSession::create([
                'student_id' => $student->id,
                'class_id'   => $validated['class_id'],
                'section_id' => $validated['section_id'],
                'session_id' => $sessionId,
            ]);

            // Create login account for student
            \App\Models\User::create([
                'role'       => 'student',
                'username'   => $student->admission_no,
                'password'   => Hash::make('student123'),
                'user_id'    => $student->id,
                'name'       => $student->firstname . ' ' . $student->lastname,
                'email'      => $student->email,
                'phone'      => $student->mobileno,
                'image'      => $student->image,
                'is_active'  => 1,
                'is_verified'=> 1,
            ]);

            DB::commit();

            return redirect()->route('admin.student.index')
                ->with('success', __('Student created successfully. Default password: student123'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Student create failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to create student.') . ' ' . $e->getMessage());
        }
    }

    public function show(Student $student)
    {
        $student->load(['sessions.class', 'sessions.section', 'category', 'fees']);
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $student->load('sessions');
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'admission_no'    => ['required','string', Rule::unique('students', 'admission_no')->ignore($student->id)],
            'roll_no'         => 'nullable|string',
            'admission_date'  => 'nullable|date',
            'firstname'       => 'required|string|max:100',
            'middlename'      => 'nullable|string|max:100',
            'lastname'         => 'required|string|max:100',
            'category_id'     => 'nullable|integer',
            'dob'             => 'nullable|date',
            'gender'          => 'nullable|in:male,female,other',
            'blood_group'    => 'nullable|string',
            'mobileno'        => 'nullable|string|max:20',
            'email'           => 'nullable|email|max:100',
            'image'           => 'nullable|image|max:2048',
            'current_address' => 'nullable|string',
            'permanent_address'=> 'nullable|string',
            'guardian_name'   => 'nullable|string|max:100',
            'guardian_phone'  => 'nullable|string|max:20',
            'guardian_email'  => 'nullable|email|max:100',
            'father_name'     => 'nullable|string|max:100',
            'father_phone'    => 'nullable|string|max:20',
            'father_occupation'=> 'nullable|string|max:100',
            'mother_name'     => 'nullable|string|max:100',
            'mother_phone'    => 'nullable|string|max:20',
            'mother_occupation'=> 'nullable|string|max:100',
            'is_active'       => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                if ($student->image) $this->media->delete($student->image);
                $validated['image'] = $this->media->upload($request->file('image'), 'student_images', 'STU');
            }

            $student->update($validated);

            DB::commit();
            return redirect()->route('admin.student.index')
                ->with('success', __('Student updated successfully.'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Student update failed', ['err' => $e->getMessage()]);
            return back()->withInput()->with('error', __('Failed to update student.'));
        }
    }

    public function destroy(Student $student)
    {
        try {
            if ($student->image) $this->media->delete($student->image);
            $student->delete();
            return redirect()->route('admin.student.index')
                ->with('success', __('Student deleted successfully.'));
        } catch (\Throwable $e) {
            Log::error('Student delete failed', ['err' => $e->getMessage()]);
            return back()->with('error', __('Failed to delete student.'));
        }
    }

    public function uploadPhoto(Request $request, Student $student)
    {
        $request->validate(['photo' => 'required|image|max:2048']);
        if ($student->image) $this->media->delete($student->image);
        $path = $this->media->upload($request->file('photo'), 'student_images', 'STU');
        $student->update(['image' => $path]);
        return response()->json(['success' => true, 'path' => Storage::disk('public')->url($path)]);
    }

    public function disable(Request $request, Student $student)
    {
        $request->validate(['disable_reason_id' => 'required', 'disable_note' => 'nullable|string']);
        $student->update([
            'is_active'         => 0,
            'disable_reason_id' => $request->disable_reason_id,
            'disable_date'      => today(),
            'disable_note'      => $request->disable_note,
        ]);
        return back()->with('success', __('Student disabled.'));
    }

    public function enable(Student $student)
    {
        $student->update([
            'is_active'         => 1,
            'disable_reason_id' => null,
            'disable_date'      => null,
            'disable_note'      => null,
        ]);
        return back()->with('success', __('Student enabled.'));
    }

    public function profile(Student $student)
    {
        $student->load(['sessions.class', 'sessions.section', 'fees', 'attendances.type']);
        return view('admin.students.show', compact('student'));
    }

    public function print(Student $student)
    {
        $student->load(['sessions.class', 'sessions.section']);
        return view('admin.students.print', compact('student'));
    }

    public function fees(Student $student)
    {
        $student->load(['fees.payments']);
        return view('admin.students.fees', compact('student'));
    }

    public function attendance(Student $student)
    {
        $student->load(['attendances.type']);
        return view('admin.students.attendance', compact('student'));
    }

    public function examResult(Student $student)
    {
        $student->load(['examResults.schedule.subject']);
        return view('admin.students.exam-result', compact('student'));
    }

    public function updateGuardian(Request $request, Student $student)
    {
        $validated = $request->validate([
            'guardian_name'   => 'nullable|string|max:100',
            'guardian_phone'  => 'nullable|string|max:20',
            'guardian_email'  => 'nullable|email|max:100',
            'guardian_occupation' => 'nullable|string|max:100',
            'guardian_address'=> 'nullable|string',
        ]);
        $student->update($validated);
        return back()->with('success', __('Guardian information updated.'));
    }

    public function sampleImport()
    {
        $filename = 'students_import_sample.csv';
        $path = storage_path('app/public/' . $filename);
        if (! file_exists(dirname($path))) mkdir(dirname($path), 0775, true);
        file_put_contents($path, "admission_no,firstname,lastname,gender,dob,mobileno,email,class_id,section_id\nSTU001,John,Doe,male,2010-05-15,9876543210,john@example.com,1,1\n");
        return response()->download($path);
    }

    public function import(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt|max:5120']);
        $rows = parseCsv($request->file('csv_file')->getRealPath());

        $imported = 0;
        $errors = [];
        $sessionId = $this->customlib->getActiveSessionId();

        foreach ($rows as $i => $row) {
            try {
                DB::beginTransaction();
                $student = Student::create([
                    'admission_no' => $row['admission_no'],
                    'firstname'    => $row['firstname'],
                    'lastname'     => $row['lastname'],
                    'gender'       => $row['gender'] ?? null,
                    'dob'          => $row['dob'] ?? null,
                    'mobileno'     => $row['mobileno'] ?? null,
                    'email'        => $row['email'] ?? null,
                    'is_active'    => 1,
                ]);
                StudentSession::create([
                    'student_id' => $student->id,
                    'class_id'   => $row['class_id'],
                    'section_id' => $row['section_id'],
                    'session_id' => $sessionId,
                ]);
                DB::commit();
                $imported++;
            } catch (\Throwable $e) {
                DB::rollBack();
                $errors[] = "Row " . ($i + 2) . ": " . $e->getMessage();
            }
        }

        return back()->with('success', __('Imported :n students.', ['n' => $imported]))
                     ->with('error', $errors ? implode('<br>', $errors) : null);
    }
}
