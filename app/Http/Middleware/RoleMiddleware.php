<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $userRole = $user->role;

        // Female-only specific check for Menstrual Health module
        if (in_array('female_only', $roles) || in_array('female_siswa', $roles)) {
            if ($user->jenis_kelamin !== 'P') {
                abort(403, 'Akses terbatas. Fitur ini khusus untuk siswi / pengguna perempuan.');
            }
            return $next($request);
        }

        // Standard role check (Allow super_admin & admin_super bypass for administration)
        if (in_array($userRole, $roles) || in_array($userRole, ['super_admin', 'admin_super'])) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki hak akses untuk membuka halaman ini.');
    }
}
