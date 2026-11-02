<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\RbacService;

class CheckPermission
{
    public function __construct(private RbacService $rbac) {}

    public function handle(Request $request, Closure $next, ?string $permission = null): Response
    {
        $user = auth('admin')->user();
        if (! $user) return $next($request);
        if ($this->rbac->isSuperAdmin($user)) return $next($request);
        if ($permission === null) return $next($request);

        if (! $this->rbac->hasPermission($permission, $user)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Insufficient permissions.'], 403);
            }
            abort(403, 'You do not have permission to perform this action.');
        }
        return $next($request);
    }
}
