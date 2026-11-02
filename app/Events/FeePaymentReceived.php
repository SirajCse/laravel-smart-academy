<?php

namespace App\Events;

use App\Models\StudentFees;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FeePaymentReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public StudentFees $fee) {}
}
