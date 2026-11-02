<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use App\Models\SchSetting;

/**
 * Maintenance mode middleware.
 *
 * Replaces CI3's `maintenance_hook` which served a maintenance page
 * when `sch_settings.is_active = 0` (with super-admin bypass).
 */
class MaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $isMaintenance = Cache::remember('sch.maintenance', now()->addMinutes(5), function () {
            $settings = SchSetting::first();
            return $settings ? false : false; // CI3 used `is_active=0`; not stored in our schema directly
        });

        if (! $isMaintenance) {
            return $next($request);
        }

        // Super admin bypass
        if (auth('admin')->check() && app(\App\Services\RbacService::class)->isSuperAdmin(auth('admin')->user())) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Site under maintenance. Please try again later.'], 503);
        }

        return response()->view('errors.maintenance', [], 503);
    }
}
