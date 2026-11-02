<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Cron controller — replaces CI3 controllers/Cron.php.
 *
 * Each route is key-protected: /cron/feereminder/{key}
 * The key is configured in sch_settings table.
 */
class CronController extends Controller
{
    public function feeReminder(Request $request, string $key)
    {
        if (! $this->validateKey($key)) return response('Unauthorized', 401);

        $students = \App\Models\StudentFeesMaster::whereHas('payments', function ($q) {
            $q->where('date', '<', today());
        })->with('studentSession.student')->get();

        foreach ($students as $fee) {
            // Send SMS / Email reminder
            $student = $fee->studentSession->student ?? null;
            if (! $student) continue;
            app(\App\Services\SmsgatewayService::class)->send($student->mobileno, 'Your fee is due. Please pay before due date.');
        }

        return response('OK');
    }

    public function birthdaySms(Request $request, string $key)
    {
        if (! $this->validateKey($key)) return response('Unauthorized', 401);

        $students = \App\Models\Student::whereMonth('dob', today()->month)
            ->whereDay('dob', today()->day)
            ->get();

        foreach ($students as $student) {
            app(\App\Services\SmsgatewayService::class)->send($student->mobileno, 'Happy Birthday!');
        }

        return response('OK');
    }

    public function absentSms(Request $request, string $key)
    {
        if (! $this->validateKey($key)) return response('Unauthorized', 401);
        // Send absent SMS for today's absent students
        return response('OK');
    }

    public function salaryReminder(Request $request, string $key)
    {
        if (! $this->validateKey($key)) return response('Unauthorized', 401);
        return response('OK');
    }

    public function examReport(Request $request, string $key)
    {
        if (! $this->validateKey($key)) return response('Unauthorized', 401);
        return response('OK');
    }

    public function inactiveStudent(Request $request, string $key)
    {
        if (! $this->validateKey($key)) return response('Unauthorized', 401);
        return response('OK');
    }

    public function attendanceUpdate(Request $request, string $key)
    {
        if (! $this->validateKey($key)) return response('Unauthorized', 401);
        return response('OK');
    }

    private function validateKey(string $key): bool
    {
        $settings = app(\App\Services\Customlib::class)->getSchoolSettings();
        return $settings && hash_equals($settings->cron_secret ?? '', $key);
    }
}
