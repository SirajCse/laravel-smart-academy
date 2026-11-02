<?php

namespace App\Listeners;

use App\Events\HomeworkAssigned;
use App\Services\PushnotificationService;
use App\Models\StudentSession;

class NotifyStudentsAboutHomework
{
    public function __construct(private PushnotificationService $push) {}

    public function handle(HomeworkAssigned $event): void
    {
        $homework = $event->homework;

        $studentSessions = StudentSession::where('class_id', $homework->class_id)
            ->where('section_id', $homework->section_id)
            ->where('session_id', $homework->session_id)
            ->with('student.user')
            ->get();

        $tokens = $studentSessions
            ->map(fn ($ss) => $ss->student?->user?->device_token)
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (! empty($tokens)) {
            $this->push->send(
                $tokens,
                'New Homework: ' . $homework->subject?->name,
                'Due: ' . $homework->submit_date->format('d-m-Y'),
                ['type' => 'homework', 'id' => $homework->id],
            );
        }
    }
}
