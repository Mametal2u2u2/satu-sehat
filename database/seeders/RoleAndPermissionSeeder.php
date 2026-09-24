<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Roles Definition
        $roles = [
            'Super Admin',
            'Admin Klinik',
            'Dokter',
            'Perawat',
            'Petugas Pendaftaran',
            'Pasien',
            'Apoteker',
            'Fisioterapis',
            'Approver',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2. Granular Permissions List
        $permissions = [
            // Dashboard
            'dashboard.view',

            // Pasien
            'pasien.view',
            'pasien.create',
            'pasien.edit',
            'pasien.delete',
            'pasien.export',

            // Antrian
            'antrian.view',
            'antrian.create',
            'antrian.edit',
            'antrian.delete',
            'antrian.panggil',

            // Jadwal Dokter & Praktik
            'jadwal.view',
            'jadwal.create',
            'jadwal.edit',
            'jadwal.delete',

            // Pemeriksaan & Tindakan
            'pemeriksaan.view',
            'pemeriksaan.create',
            'pemeriksaan.edit',
            'pemeriksaan.delete',

            // Rekam Medis (EMR)
            'rekam_medis.view',
            'rekam_medis.create',
            'rekam_medis.edit',
            'rekam_medis.delete',
            'rekam_medis.print',

            // Farmasi & Resep
            'resep.view',
            'resep.create',
            'resep.edit',
            'resep.process',
            'obat.view',
            'obat.create',
            'obat.edit',
            'obat.delete',

            // Data Master
            'master.view',
            'master.create',
            'master.edit',
            'master.delete',

            // Manajemen User
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // Manajemen Hak Akses (Role & Permission)
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',
            'permission.view',
            'permission.edit',
            'audit_log.view',

            // Sistem & Backup
            'backup.view',
            'backup.create',
            'backup.delete',

            // Laporan & Panduan
            'laporan.view',
            'panduan.view',

            // Portal Pasien
            'pasien.portal',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // 3. Assign Default Permissions to Roles

        // A. Super Admin: ALL Permissions
        $superAdmin = Role::findByName('Super Admin', 'web');
        $superAdmin->syncPermissions(Permission::all());

        // B. Admin Klinik: Operational Admin (all except core security & role editing)
        $adminKlinik = Role::findByName('Admin Klinik', 'web');
        $adminKlinik->syncPermissions([
            'dashboard.view',
            'pasien.view', 'pasien.create', 'pasien.edit', 'pasien.export',
            'antrian.view', 'antrian.create', 'antrian.edit', 'antrian.panggil',
            'jadwal.view', 'jadwal.create', 'jadwal.edit',
            'pemeriksaan.view',
            'rekam_medis.view',
            'resep.view', 'obat.view', 'obat.create', 'obat.edit',
            'master.view', 'master.create', 'master.edit',
            'backup.view', 'backup.create',
            'laporan.view',
            'panduan.view',
        ]);

        // C. Dokter: Clinical & EMR Authority
        $dokter = Role::findByName('Dokter', 'web');
        $dokter->syncPermissions([
            'dashboard.view',
            'pasien.view',
            'antrian.view', 'antrian.panggil',
            'jadwal.view',
            'pemeriksaan.view', 'pemeriksaan.create', 'pemeriksaan.edit',
            'rekam_medis.view', 'rekam_medis.create', 'rekam_medis.edit', 'rekam_medis.print',
            'resep.view', 'resep.create',
            'panduan.view',
        ]);

        // D. Perawat: Triage & Initial Checkups
        $perawat = Role::findByName('Perawat', 'web');
        $perawat->syncPermissions([
            'dashboard.view',
            'pasien.view', 'pasien.create',
            'antrian.view', 'antrian.create', 'antrian.edit',
            'jadwal.view',
            'pemeriksaan.view', 'pemeriksaan.create',
            'rekam_medis.view',
            'panduan.view',
        ]);

        // E. Petugas Pendaftaran: Front Desk & Registration
        $pendaftaran = Role::findByName('Petugas Pendaftaran', 'web');
        $pendaftaran->syncPermissions([
            'dashboard.view',
            'pasien.view', 'pasien.create', 'pasien.edit',
            'antrian.view', 'antrian.create', 'antrian.edit',
            'jadwal.view',
            'panduan.view',
        ]);

        // F. Pasien: Patient Portal Only
        $pasien = Role::findByName('Pasien', 'web');
        $pasien->syncPermissions([
            'pasien.portal',
        ]);

        // G. Apoteker: Pharmacy Specialist
        $apoteker = Role::findByName('Apoteker', 'web');
        $apoteker->syncPermissions([
            'dashboard.view',
            'resep.view', 'resep.process',
            'obat.view', 'obat.create', 'obat.edit',
            'panduan.view',
        ]);

        // H. Fisioterapis: Therapy
        $fisioterapis = Role::findByName('Fisioterapis', 'web');
        $fisioterapis->syncPermissions([
            'dashboard.view',
            'pasien.view',
            'pemeriksaan.view', 'pemeriksaan.create',
            'rekam_medis.view',
            'panduan.view',
        ]);

        // I. Approver: Administrative Approvals
        $approver = Role::findByName('Approver', 'web');
        $approver->syncPermissions([
            'dashboard.view',
            'panduan.view',
        ]);
    }
}
