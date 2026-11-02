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
 *   Route::get('/student', [StudentController::class, 'index'])
 *        ->middleware('rbac:student.view');
 *
 * Naming convention (from CI3 `permission_category.short_code`):
 *   "<category>.<action>" where action is one of: view, create, edit, delete.
 */
class CheckPermission
{
    public function __construct(private RbacService $rbac) {}

    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = auth('admin')->user();

        if (! $user) {
            abort(403, 'Unauthorized action.');
        }

        if ($this->rbac->isSuperAdmin($user)) {
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
