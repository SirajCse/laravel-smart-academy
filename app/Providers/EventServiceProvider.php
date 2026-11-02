<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event-to-listener mappings for the application.
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\StudentEnrolled::class => [
            \App\Listeners\NotifyParentsOnEnrollment::class,
            \App\Listeners\GenerateFeeMasterForStudent::class,
        ],
        \App\Events\FeePaymentReceived::class => [
            \App\Listeners\SendFeeReceipt::class,
            \App\Listeners\UpdateStudentFeeStatus::class,
        ],
        \App\Events\AttendanceMarked::class => [
            \App\Listeners\NotifyParentsOnAbsence::class,
        ],
        \App\Events\HomeworkAssigned::class => [
            \App\Listeners\NotifyStudentsAboutHomework::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be auto-discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}
