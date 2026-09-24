<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PatientPolicy
{
    /**
     * Determine whether the user can view any patient records.
     */
    public function viewAny(User $user): bool
    {
        // Patients cannot browse other patients
        if ($user->hasRole('Pasien')) {
            return false;
        }

        return $user->can('pasien.view');
    }

    /**
     * Determine whether the user can view the specific patient.
     */
    public function view(User $user, Patient $patient): Response
    {
        // 1. Super Admin & Admin Klinik
        if ($user->hasRole('Super Admin') || ($user->hasRole('Admin Klinik') && $user->can('pasien.view'))) {
            return Response::allow();
        }

        // 2. Patient can ONLY view their own record
        if ($user->hasRole('Pasien')) {
            $isOwnData = ($patient->user_id && $patient->user_id === $user->id)
                || ($patient->email && strtolower($patient->email) === strtolower($user->email))
                || ($patient->nik && $patient->nik === $user->nik);

            return $isOwnData
                ? Response::allow()
                : Response::deny('Akses Ditolak: Anda hanya diperbolehkan mengakses data medis dan identitas milik Anda sendiri.');
        }

        // 3. Clinical & Front Desk Staff (Dokter, Perawat, Petugas Pendaftaran)
        if ($user->can('pasien.view')) {
            return Response::allow();
        }

        return Response::deny('Akses Ditolak: Akun Anda tidak memiliki izin untuk melihat data pasien.');
    }

    /**
     * Determine whether the user can create patients.
     */
    public function create(User $user): bool
    {
        return $user->can('pasien.create');
    }

    /**
     * Determine whether the user can update the patient.
     */
    public function update(User $user, Patient $patient): Response
    {
        if ($user->hasRole('Super Admin')) {
            return Response::allow();
        }

        if ($user->hasRole('Pasien')) {
            $isOwnData = ($patient->user_id && $patient->user_id === $user->id)
                || ($patient->email && strtolower($patient->email) === strtolower($user->email));

            return $isOwnData
                ? Response::allow()
                : Response::deny('Anda tidak memiliki izin mengubah data pasien lain.');
        }

        return $user->can('pasien.edit')
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengedit data pasien.');
    }

    /**
     * Determine whether the user can delete the patient.
     */
    public function delete(User $user, Patient $patient): Response
    {
        return $user->can('pasien.delete')
            ? Response::allow()
            : Response::deny('Akses Ditolak: Anda tidak memiliki wewenang untuk menghapus data pasien.');
    }
}
