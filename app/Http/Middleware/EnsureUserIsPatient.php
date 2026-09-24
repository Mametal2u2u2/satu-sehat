<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsPatient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $adminRoles = [
            'Super Admin',
            'Admin Klinik',
            'Dokter',
            'Perawat',
            'Petugas Pendaftaran',
            'Fisioterapis',
            'Apoteker',
            'Approver',
        ];

        // Reject if user is staff/admin and does not have the Pasien role
        if ($user->hasAnyRole($adminRoles) && ! $user->hasRole('Pasien')) {
            return redirect()->route('admin.dashboard')->with('error', 'Akses Ditolak: Akun staf/admin tidak memiliki hak akses ke Portal Pasien.');
        }

        // Reject if user is not a patient
        if (! $user->hasRole('Pasien')) {
            return redirect()->route('admin.dashboard')->with('error', 'Akses Ditolak: Halaman ini khusus untuk Pasien.');
        }

        return $next($request);
    }
}
