<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $adminRoles = [
            'Super Admin',
            'Admin Klinik',
            'Dokter',
            'Perawat',
            'Fisioterapis',
            'Apoteker',
            'Approver',
        ];

        if (! $user) {
            return redirect()->route('admin.login');
        }

        if (! $user->hasAnyRole($adminRoles)) {
            return redirect()->route('patient.dashboard')->with('status', 'Akses Ditolak: Anda tidak memiliki hak akses ke panel manajemen staf/admin.');
        }

        return $next($request);
    }
}
