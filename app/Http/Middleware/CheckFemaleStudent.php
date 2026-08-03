<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFemaleStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Super admin (role super_admin / admin_super) bisa akses tanpa cek gender
        if (in_array($user->role, ['super_admin', 'admin_super'])) {
            return $next($request);
        }

        // Siswa dan Admin UKS / Petugas UKS wajib berjenis kelamin P (Perempuan)
        if (in_array($user->role, ['siswa', 'admin_uks', 'petugas_uks']) && $user->jenis_kelamin === 'P') {
            return $next($request);
        }

        abort(403, 'Akses Ditolak. Halaman ini khusus privasi siswi dan pengelola UKS putri.');
    }
}
