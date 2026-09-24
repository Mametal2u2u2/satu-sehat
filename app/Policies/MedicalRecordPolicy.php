<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MedicalRecordPolicy
{
    /**
     * Determine whether the user can view medical records index.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('rekam_medis.view');
    }

    /**
     * Determine whether the user can view the specific medical record.
     */
    public function view(User $user, MedicalRecord $record): Response
    {
        // 1. Super Admin & Admin Klinik
        if ($user->hasRole('Super Admin') || ($user->hasRole('Admin Klinik') && $user->can('rekam_medis.view'))) {
            return Response::allow();
        }

        // 2. Pasien can ONLY see their own medical records
        if ($user->hasRole('Pasien')) {
            $patient = $record->patient;
            $isOwn = $patient && (
                ($patient->user_id && $patient->user_id === $user->id)
                || ($patient->email && strtolower($patient->email) === strtolower($user->email))
                || ($patient->nik && $patient->nik === $user->nik)
            );

            return $isOwn
                ? Response::allow()
                : Response::deny('Akses Ditolak: Anda tidak memiliki hak akses untuk melihat rekam medis milik pasien lain.');
        }

        // 3. Clinical Staff (Dokter & Perawat with rekam_medis.view permission)
        if ($user->can('rekam_medis.view')) {
            return Response::allow();
        }

        return Response::deny('Akses Ditolak: Akun Anda tidak memiliki izin untuk mengakses rekam medis.');
    }

    /**
     * Determine whether the user can create medical records.
     */
    public function create(User $user): bool
    {
        return $user->can('rekam_medis.create');
    }

    /**
     * Determine whether the user can update the medical record.
     */
    public function update(User $user, MedicalRecord $record): Response
    {
        // Super Admin can edit
        if ($user->hasRole('Super Admin')) {
            return Response::allow();
        }

        // Dokter: must have permission AND can only edit their own examination record
        if ($user->hasRole('Dokter')) {
            $doctorProfile = $user->doctor ?? \App\Models\Doctor::where('user_id', $user->id)->first();
            $doctorId = $doctorProfile?->id;

            if ($doctorId && $record->doctor_id && $record->doctor_id != $doctorId) {
                return Response::deny('Akses Ditolak: Dokter hanya dapat memperbarui catatan medis hasil pemeriksaannya sendiri.');
            }

            return $user->can('rekam_medis.edit')
                ? Response::allow()
                : Response::deny('Akun Anda tidak memiliki izin mengedit rekam medis.');
        }

        return $user->can('rekam_medis.edit')
            ? Response::allow()
            : Response::deny('Akses Ditolak: Anda tidak memiliki izin untuk mengubah rekam medis.');
    }

    /**
     * Determine whether the user can delete the medical record.
     */
    public function delete(User $user, MedicalRecord $record): Response
    {
        return $user->can('rekam_medis.delete')
            ? Response::allow()
            : Response::deny('Akses Ditolak: Anda tidak memiliki wewenang untuk menghapus rekam medis.');
    }
}
