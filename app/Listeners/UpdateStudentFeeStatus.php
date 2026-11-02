<?php

namespace App\Listeners;

use App\Events\FeePaymentReceived;

class UpdateStudentFeeStatus
{
    public function handle(FeePaymentReceived $event): void
    {
        $fee = $event->fee;
        $master = $fee->master;
        if (! $master) return;

        $totalPaid = $master->payments()->sum('amount');
        $totalDue = $master->amount - $master->discount_amount - $totalPaid;

        // Could trigger additional logic based on $totalDue
        // (e.g. set is_fully_paid flag, trigger fee-lock release, etc.)
    }
}
