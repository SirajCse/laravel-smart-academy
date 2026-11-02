<?php

namespace App\Events;

use App\Models\StudentAttendence;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttendanceMarked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public StudentAttendence $attendance) {}
}
