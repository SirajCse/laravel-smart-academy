<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Customlib;

/**
 * Fee-lock middleware.
 *
 * Replaces CI3's `Student_Controller::__construct()` check that
 * redirected to the fee-collection screen when `sch_settings.fee_lock = 1`.
 *
 * Currently a no-op pass-through; enable by setting `school.fee_lock = true`.
 */
class FeeLockMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $settings = app(Customlib::class)->getSchoolSettings();

        if (! empty($settings->fee_lock) && ! $request->is('admin/student-fee*')) {
            return redirect()->route('admin.student-fee.index')
                ->with('warning', __('Please clear pending fees before continuing.'));
        }

        return $next($request);
    }
}
