<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Services\Customlib;
use Illuminate\Support\Facades\Auth;

class StudentLayoutComposer
{
    public function __construct(private Customlib $customlib) {}

    public function compose(View $view): void
    {
        $user     = Auth::guard('student')->user();
        $settings = $this->customlib->getSchoolSettings();

        $view->with([
            'schoolName'    => $settings->school_name ?? config('app.name'),
            'schoolLogo'    => $this->customlib->getSchoolLogo(),
            'sidebarImage'  => $this->customlib->getSidebarImage(),
            'currencySymbol' => $settings->currency_symbol ?? '$',
            'dateFormat'    => $settings->date_format ?? 'd-m-Y',
            'isRtl'         => (bool) ($settings->is_rtl ?? false),
            'currentUser'  => $user,
            'studentName'  => $user?->name,
            'studentImage' => $user?->image,
            'activeSession' => $this->customlib->getActiveSession(),
        ]);
    }
}
