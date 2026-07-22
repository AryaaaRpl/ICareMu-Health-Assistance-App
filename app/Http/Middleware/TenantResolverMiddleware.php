<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Core\Tenant\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantResolverMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            if ($user->role === 'admin_super' || $user->hasRole('Super Admin')) {
                TenantContext::setSuperAdmin(true);

                // Optional header override for Super Admin context switching
                if ($request->hasHeader('X-Tenant-ID')) {
                    TenantContext::setTenantId((int) $request->header('X-Tenant-ID'));
                }
            } else {
                TenantContext::setTenantId($user->sekolah_id);
                TenantContext::setSuperAdmin(false);
            }
        }

        return $next($request);
    }
}
