<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\MultiBranch;

/**
 * Multi-branch DB switcher middleware.
 *
 * Replaces CI3's `MY_Controller::multibranch_config()` which loaded
 * the correct DB group from the `multi_branch` table based on the
 * current request hostname.
 *
 * Only active when `MULTI_BRANCH_ENABLED=true` in `.env`.
 */
class MultiBranchSwitcher
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('app.multi_branch_enabled', env('MULTI_BRANCH_ENABLED', false))) {
            return $next($request);
        }

        $hostname = $request->getHost();

        $branch = cache()->remember("branch.{$hostname}", now()->addMinutes(5), function () use ($hostname) {
            return MultiBranch::where('hostname', $hostname)->where('is_active', 1)->first();
        });

        if ($branch) {
            Config::set('database.connections.mysql.database', $branch->database);
            Config::set('database.connections.mysql.username', $branch->username ?: config('database.connections.mysql.username'));
            Config::set('database.connections.mysql.password', $branch->password ?: config('database.connections.mysql.password'));
            DB::purge('mysql');
            DB::reconnect('mysql');
        }

        return $next($request);
    }
}
