<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\RbacService;

/**
 * RBAC permission check middleware.
 *
 * Replaces CI3's `$this->rbac->hasPrivilege($category, $permission)`
 * per-method check that ran inside every admin controller method.
 *
 * Usage:
 *   // As a route-group middleware (no args): super-admins pass through;
 *   // other users get 403 only if no per-method middleware fires.
 *   Route::group(['middleware' => ['rbac']], function () { ... });
 *
 *   // As a per-method middleware (with permission):
 *   Route::get('/student', [StudentController::class, 'index'])
 *        ->middleware('rbac:student.view');
 */
class CheckPermission
{
    public function __construct(private RbacService $rbac) {}

    public function handle(Request $request, Closure $next, ?string $permission = null): Response
    {
        $user = auth('admin')->user();

        // No user → let AuthenticateAdmin redirect to login
        if (! $user) {
            return $next($request);
        }

        // Super-admin bypasses all permission checks
        if ($this->rbac->isSuperAdmin($user)) {
            return $next($request);
        }

        // When called as a route-group middleware with no permission arg,
        // let the request through; per-method middleware will enforce.
        if ($permission === null) {
            return $next($request);
        }

        if (! $this->rbac->hasPermission($permission, $user)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Insufficient permissions.'], 403);
            }
            abort(403, 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
