<?php

namespace Tests\Feature\Auth;

use App\Models\AuditLog;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $adminKlinik;
    protected User $dokter;
    protected User $perawat;
    protected User $pendaftaran;
    protected User $pasien;

    protected function setUp(): void
    {
        parent::setUp();

        // Run seeders to set up roles and permissions
        $this->seed(RoleAndPermissionSeeder::class);

        // Reset Spatie cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create users for each role
        $this->superAdmin = User::factory()->create(['username' => 'superadmin_test', 'status' => 'active']);
        $this->superAdmin->assignRole('Super Admin');

        $this->adminKlinik = User::factory()->create(['username' => 'adminklinik_test', 'status' => 'active']);
        $this->adminKlinik->assignRole('Admin Klinik');

        $this->dokter = User::factory()->create(['username' => 'dokter_test', 'status' => 'active']);
        $this->dokter->assignRole('Dokter');

        $this->perawat = User::factory()->create(['username' => 'perawat_test', 'status' => 'active']);
        $this->perawat->assignRole('Perawat');

        $this->pendaftaran = User::factory()->create(['username' => 'pendaftaran_test', 'status' => 'active']);
        $this->pendaftaran->assignRole('Petugas Pendaftaran');

        $this->pasien = User::factory()->create(['username' => 'pasien_test', 'status' => 'active']);
        $this->pasien->assignRole('Pasien');
    }

    /**
     * 1. Super Admin can view /admin/hak-akses and its components.
     */
    public function test_super_admin_can_access_hak_akses_page(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('admin.access-control.index'));

        $response->assertOk();
        $response->assertSee('Manajemen Hak Akses');
        $response->assertSee('Matriks Hak Akses');
        $response->assertSee('Manajemen Role');
        $response->assertSee('Audit Log');
    }

    /**
     * 2. Non-Super Admin roles (Dokter, Perawat, Pendaftaran, Pasien) receive 403 Forbidden.
     */
    public function test_non_authorized_roles_receive_403_on_hak_akses(): void
    {
        // Dokter
        $response = $this->actingAs($this->dokter)->get(route('admin.access-control.index'));
        $response->assertStatus(403);

        // Perawat
        $response = $this->actingAs($this->perawat)->get(route('admin.access-control.index'));
        $response->assertStatus(403);

        // Petugas Pendaftaran
        $response = $this->actingAs($this->pendaftaran)->get(route('admin.access-control.index'));
        $response->assertStatus(403);

        // Admin Klinik (by default cannot access system permissions unless granted)
        $response = $this->actingAs($this->adminKlinik)->get(route('admin.access-control.index'));
        $response->assertStatus(403);
    }

    /**
     * 3. Super Admin can update role permissions, produces audit log and confirmation toast.
     */
    public function test_super_admin_can_update_role_permissions_and_creates_audit_log(): void
    {
        $roleDokter = Role::findByName('Dokter');
        $initialPermissions = $roleDokter->permissions->pluck('name')->toArray();

        // Update Dokter permissions: give only dashboard.view and rekam_medis.view
        $newPermissions = ['dashboard.view', 'rekam_medis.view'];

        $response = $this->actingAs($this->superAdmin)->put(
            route('admin.access-control.permissions.update', $roleDokter->id),
            ['permissions' => $newPermissions]
        );

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Tidak ada masalah, hak akses berhasil diperbarui.');

        // Refresh role and verify
        $roleDokter->refresh();
        $updatedPermissions = $roleDokter->permissions->pluck('name')->toArray();
        sort($newPermissions);
        sort($updatedPermissions);
        $this->assertEquals($newPermissions, $updatedPermissions);

        // Verify Audit Log is created
        $audit = AuditLog::where('target_id', $roleDokter->id)->latest()->first();
        $this->assertNotNull($audit);
        $this->assertEquals($this->superAdmin->id, $audit->user_id);
        $this->assertEquals('update_role_permissions', $audit->action);
        $this->assertStringContainsString('Mengubah Hak Akses Role Dokter', $audit->description);
    }

    /**
     * 4. Super Admin role permissions are protected from being stripped.
     */
    public function test_super_admin_role_cannot_be_stripped(): void
    {
        $roleSuperAdmin = Role::findByName('Super Admin');

        $response = $this->actingAs($this->superAdmin)->put(
            route('admin.access-control.permissions.update', $roleSuperAdmin->id),
            ['permissions' => []]
        );

        $response->assertRedirect();
        // Super Admin keeps all permissions
        $roleSuperAdmin->refresh();
        $this->assertGreaterThan(0, $roleSuperAdmin->permissions()->count());
    }

    /**
     * 5. Granular route enforcement: Dokter can access rekam-medis but blocked on backup (403).
     */
    public function test_granular_route_protection_by_permission(): void
    {
        // Dokter has rekam_medis.view -> should be 200 OK
        $response = $this->actingAs($this->dokter)->get('/admin/rekam-medis');
        $response->assertOk();

        // Dokter does NOT have backup.view -> should be 403 Forbidden
        $responseBackup = $this->actingAs($this->dokter)->get('/admin/backup');
        $responseBackup->assertStatus(403);
    }

    /**
     * 6. Dynamic permission revocation takes effect immediately.
     */
    public function test_dynamic_permission_revocation_takes_immediate_effect(): void
    {
        // 1. Initially Dokter has antrian.view -> 200 OK
        $response1 = $this->actingAs($this->dokter)->get('/admin/antrian');
        $response1->assertOk();

        // 2. Super Admin revokes antrian.view from Dokter
        $roleDokter = Role::findByName('Dokter');
        $remainingPermissions = $roleDokter->permissions
            ->pluck('name')
            ->reject(fn($p) => str_starts_with($p, 'antrian.'))
            ->toArray();

        $this->actingAs($this->superAdmin)->put(
            route('admin.access-control.permissions.update', $roleDokter->id),
            ['permissions' => $remainingPermissions]
        );

        // 3. Dokter immediately tries to access /admin/antrian again -> now 403 Forbidden
        $response2 = $this->actingAs($this->dokter)->get('/admin/antrian');
        $response2->assertStatus(403);
    }

    /**
     * 7. Super Admin can create a new role and assign permissions to it.
     */
    public function test_super_admin_can_create_new_role(): void
    {
        $response = $this->actingAs($this->superAdmin)->post(
            route('admin.access-control.roles.store'),
            [
                'name' => 'Laboran Khusus',
            ]
        );

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('roles', ['name' => 'Laboran Khusus']);

        $role = Role::findByName('Laboran Khusus');
        $this->assertTrue($role->hasPermissionTo('dashboard.view'));

        // Check audit log
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'create_role',
            'target_name' => 'Laboran Khusus',
        ]);
    }

    /**
     * 8. Cannot delete system-critical roles.
     */
    public function test_cannot_delete_system_critical_role(): void
    {
        $roleDokter = Role::findByName('Dokter');

        $response = $this->actingAs($this->superAdmin)->delete(
            route('admin.access-control.roles.delete', $roleDokter->id)
        );

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('roles', ['name' => 'Dokter']);
    }

    /**
     * 9. Super Admin can assign a new role to an existing user.
     */
    public function test_super_admin_can_assign_role_to_user(): void
    {
        $testUser = User::factory()->create(['status' => 'active']);
        $testUser->assignRole('Perawat');

        $this->assertTrue($testUser->hasRole('Perawat'));
        $this->assertFalse($testUser->hasRole('Dokter'));

        $response = $this->actingAs($this->superAdmin)->put(
            route('admin.access-control.users.role.update', $testUser->id),
            ['role' => 'Dokter']
        );

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $testUser->refresh();
        $this->assertTrue($testUser->hasRole('Dokter'));
        $this->assertFalse($testUser->hasRole('Perawat'));

        // Verify audit log
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'update_user_role',
            'target_id' => $testUser->id,
        ]);
    }
}
