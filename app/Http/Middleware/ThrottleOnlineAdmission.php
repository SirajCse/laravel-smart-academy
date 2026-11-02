<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Online admission throttling.
 *
 * Replaces CI3's manual `if (time() - $last_submit < 60) die()` check
 * in `OnlineAdmission_Controller::__construct()`.
 *
 * Default: 5 submissions per minute per IP.
 */
class ThrottleOnlineAdmission
{
    public function handle(Request $request, Closure $next): Response
    {
        return app(\Illuminate\Routing\Middleware\ThrottleRequests::class)
            ->handle($request, $next, '5,1', 'online-admission');
    }
}
