<?php

namespace App\Listeners;

use App\Events\StudentEnrolled;
use App\Services\Customlib;

class GenerateFeeMasterForStudent
{
    public function __construct(private Customlib $customlib) {}

    public function handle(StudentEnrolled $event): void
    {
        $student = $event->student;
        $studentSession = $this->customlib->getStudentCurrentSession($student->id);

        if (! $studentSession) return;

        $feeGroups = \App\Models\FeeSessionGroup::where('session_id', $studentSession->session_id)->get();

        foreach ($feeGroups as $fg) {
            \App\Models\StudentFeesMaster::create([
                'student_session_id' => $studentSession->id,
                'fee_session_group_id' => $fg->id,
                'amount' => $fg->groupType?->amount ?? 0,
                'discount_amount' => 0,
                'is_system' => 1,
            ]);
        }
    }
}
