<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Core\Tenant\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TenantResolverMiddleware
 *
 * Intercepts incoming HTTP requests to resolve and set the tenant context (sekolah_id)
 * based on the authenticated user's profile and roles. Allows super admins to explicitly
 * scope their requests using the X-Tenant-ID header.
 *
 * @package App\Http\Middleware
 */
class TenantResolverMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user !== null) {
            // If the user has super admin privileges, we allow them to bypass or switch contexts.
            if ($user->hasRole('admin_super')) {
                if ($request->hasHeader('X-Tenant-ID')) {
                    // Context switching: switch context to the requested tenant ID.
                    $headerValue = $request->header('X-Tenant-ID');
                    $tenantId = is_array($headerValue) ? (int) reset($headerValue) : (int) $headerValue;
                    
                    TenantContext::setTenantId($tenantId);
                    TenantContext::setSuperAdmin(false);
                } else {
                    // Global view: bypass all tenant scopes.
                    TenantContext::setSuperAdmin(true);
                }
            } else {
                // For normal scoped tenants, bind the request permanently to their associated school.
                if (isset($user->sekolah_id)) {
                    TenantContext::setTenantId((int) $user->sekolah_id);
                }
            }
        }

        return $next($request);
    }
}
