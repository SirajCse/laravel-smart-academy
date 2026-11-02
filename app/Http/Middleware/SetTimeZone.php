<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

/**
 * Timezone middleware.
 *
 * Replaces CI3's `date_default_timezone_set()` call inside
 * `MY_Controller::__construct()` which loaded `sch_settings.timezone`.
 */
class SetTimeZone
{
    public function handle(Request $request, Closure $next): Response
    {
        $timezone = config('app.timezone');

        if (Auth::guard('admin')->check()) {
            $settings = app(\App\Services\Customlib::class)->getSchoolSettings();
            if (! empty($settings->timezone)) {
                $timezone = $settings->timezone;
            }
        }

        Config::set('app.timezone', $timezone);
        date_default_timezone_set($timezone);

        return $next($request);
    }
}
