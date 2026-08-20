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

        $roles = [
            'Super Admin',
            'Admin Klinik',
            'Dokter',
            'Perawat',
            'Fisioterapis',
            'Apoteker',
            'Approver',
            'Pasien',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $permissions = [
            'view patients', 'create patients', 'update patients', 'delete patients',
            'view doctors', 'create doctors', 'update doctors', 'delete doctors',
            'view medical records', 'create medical records', 'update medical records',
            'view prescriptions', 'create prescriptions', 'process prescriptions',
            'view queues', 'call queues', 'manage queues',
            'view inventory', 'manage inventory',
            'approve submissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::findByName('Super Admin');
        $superAdmin->givePermissionTo(Permission::all());
    }
}
