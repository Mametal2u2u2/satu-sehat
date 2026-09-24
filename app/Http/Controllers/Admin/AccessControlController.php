<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AccessControlController extends Controller
{
    /**
     * Grouping definition for structured matrix UI
     */
    public static function getPermissionModules(): array
    {
        return [
            'Dashboard' => [
                'label' => 'Dashboard Utama',
                'description' => 'Akses pemantauan statistik dan ringkasan klinik',
                'permissions' => [
                    'view' => 'dashboard.view',
                ],
            ],
            'Pasien' => [
                'label' => 'Data Pasien',
                'description' => 'Pengelolaan data pasien, pendaftaran, dan informasi kontak',
                'permissions' => [
                    'view' => 'pasien.view',
                    'create' => 'pasien.create',
                    'edit' => 'pasien.edit',
                    'delete' => 'pasien.delete',
                    'export' => 'pasien.export',
                ],
            ],
            'Antrian' => [
                'label' => 'Antrian Layanan',
                'description' => 'Pemanggilan nomor antrian poli, status kehadiran, dan alur loket',
                'permissions' => [
                    'view' => 'antrian.view',
                    'create' => 'antrian.create',
                    'edit' => 'antrian.edit',
                    'delete' => 'antrian.delete',
                    'panggil' => 'antrian.panggil',
                ],
            ],
            'Jadwal' => [
                'label' => 'Jadwal Dokter & Cuti',
                'description' => 'Pengaturan jadwal praktik harian dan pengajuan cuti dokter',
                'permissions' => [
                    'view' => 'jadwal.view',
                    'create' => 'jadwal.create',
                    'edit' => 'jadwal.edit',
                    'delete' => 'jadwal.delete',
                ],
            ],
            'Pemeriksaan' => [
                'label' => 'Pemeriksaan Medis & Triage',
                'description' => 'Pencatatan tanda-tanda vital, anamnesis perawat, dan pemeriksaan fisik',
                'permissions' => [
                    'view' => 'pemeriksaan.view',
                    'create' => 'pemeriksaan.create',
                    'edit' => 'pemeriksaan.edit',
                    'delete' => 'pemeriksaan.delete',
                ],
            ],
            'Rekam Medis' => [
                'label' => 'Rekam Medis Elektronik (EMR)',
                'description' => 'Diagnosis ICD-10, riwayat medis klinis, dan resume tindakan pasien',
                'permissions' => [
                    'view' => 'rekam_medis.view',
                    'create' => 'rekam_medis.create',
                    'edit' => 'rekam_medis.edit',
                    'delete' => 'rekam_medis.delete',
                    'print' => 'rekam_medis.print',
                ],
            ],
            'Farmasi' => [
                'label' => 'Farmasi, Obat & E-Resep',
                'description' => 'Pembuatan e-resep, penyiapan obat, dan pengelolaan stok apotek',
                'permissions' => [
                    'view' => 'resep.view',
                    'create' => 'resep.create',
                    'edit' => 'resep.edit',
                    'process' => 'resep.process',
                    'obat_view' => 'obat.view',
                    'obat_create' => 'obat.create',
                    'obat_edit' => 'obat.edit',
                    'obat_delete' => 'obat.delete',
                ],
            ],
            'Data Master' => [
                'label' => 'Pusat Data Master',
                'description' => 'Master poli, ruangan, dokter, tarif tindakan, dan cabang',
                'permissions' => [
                    'view' => 'master.view',
                    'create' => 'master.create',
                    'edit' => 'master.edit',
                    'delete' => 'master.delete',
                ],
            ],
            'Manajemen User' => [
                'label' => 'Manajemen Pengguna',
                'description' => 'Kelola akun staf, reset password, dan status aktif/nonaktif',
                'permissions' => [
                    'view' => 'user.view',
                    'create' => 'user.create',
                    'edit' => 'user.edit',
                    'delete' => 'user.delete',
                ],
            ],
            'Hak Akses' => [
                'label' => 'Role & Permission',
                'description' => 'Konfigurasi matriks hak akses dan pembuatan role baru',
                'permissions' => [
                    'view' => 'role.view',
                    'create' => 'role.create',
                    'edit' => 'role.edit',
                    'delete' => 'role.delete',
                    'permission_view' => 'permission.view',
                    'permission_edit' => 'permission.edit',
                    'audit_log_view' => 'audit_log.view',
                ],
            ],
            'Sistem & Backup' => [
                'label' => 'Cadangan & Pemeliharaan',
                'description' => 'Pencadangan database otomatis dan pemeliharaan arsip sistem',
                'permissions' => [
                    'view' => 'backup.view',
                    'create' => 'backup.create',
                    'delete' => 'backup.delete',
                ],
            ],
            'Laporan & Panduan' => [
                'label' => 'Laporan & Panduan',
                'description' => 'Laporan operasional klinik dan dokumentasi panduan kerja',
                'permissions' => [
                    'view' => 'laporan.view',
                    'panduan' => 'panduan.view',
                ],
            ],
        ];
    }

    /**
     * Display unified Access Control Interface
     */
    public function index(Request $request): View
    {
        $roles = Role::withCount(['permissions', 'users'])->get();

        // Selected Role for Permission Matrix
        $selectedRoleId = $request->query('role_id', $roles->where('name', 'Dokter')->first()?->id ?? $roles->first()?->id);
        $selectedRole = Role::with('permissions')->find($selectedRoleId) ?? $roles->first();

        $activeRolePermissionNames = $selectedRole ? $selectedRole->permissions->pluck('name')->toArray() : [];

        $modules = self::getPermissionModules();

        // Users List for User & Role Tab
        $search = $request->query('search');
        $filterRole = $request->query('filter_role');

        $usersQuery = User::with('roles')->latest();
        if ($search) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }
        if ($filterRole) {
            $usersQuery->whereHas('roles', fn ($q) => $q->where('name', $filterRole));
        }
        $users = $usersQuery->paginate(15)->withQueryString();

        // Audit Logs Tab
        $auditLogs = AuditLog::with('user')->latest()->paginate(20, ['*'], 'audit_page')->withQueryString();

        // Summary stats
        $stats = [
            'total_roles' => $roles->count(),
            'total_permissions' => Permission::count(),
            'total_users' => User::count(),
            'total_audits' => AuditLog::count(),
        ];

        return view('admin.access-control.index', compact(
            'roles',
            'selectedRole',
            'activeRolePermissionNames',
            'modules',
            'users',
            'auditLogs',
            'stats',
            'search',
            'filterRole'
        ));
    }

    /**
     * Update Permissions for a Specific Role
     */
    public function updateRolePermissions(Request $request, Role $role): RedirectResponse
    {
        // Safety check: Cannot downgrade Super Admin role from outside CLI
        if ($role->name === 'Super Admin' && !auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Anda tidak memiliki wewenang untuk mengubah hak akses Super Admin.');
        }

        $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $newPermissions = $request->input('permissions', []);

        // Super Admin must always retain all permissions
        if ($role->name === 'Super Admin') {
            $newPermissions = Permission::pluck('name')->toArray();
        }

        $oldPermissions = $role->permissions->pluck('name')->toArray();

        // Calculate differences for granular audit log
        $added = array_values(array_diff($newPermissions, $oldPermissions));
        $removed = array_values(array_diff($oldPermissions, $newPermissions));

        // Sync permissions
        $role->syncPermissions($newPermissions);

        // Reset Spatie cache immediately
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create detailed Audit Log
        if (!empty($added) || !empty($removed)) {
            $descParts = [];
            if (!empty($added)) {
                $descParts[] = 'Menambahkan: ' . implode(', ', $added);
            }
            if (!empty($removed)) {
                $descParts[] = 'Menghapus: ' . implode(', ', $removed);
            }

            AuditLog::create([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'user_role' => auth()->user()->roles->first()?->name ?? 'Admin',
                'action' => 'update_role_permissions',
                'target_type' => 'Role',
                'target_id' => $role->id,
                'target_name' => $role->name,
                'old_values' => ['permissions' => $oldPermissions],
                'new_values' => ['permissions' => $newPermissions],
                'description' => "Mengubah Hak Akses Role {$role->name}. " . implode(' | ', $descParts),
                'ip_address' => $request->ip(),
            ]);
        }

        return redirect()->route('admin.access-control.index', [
            'tab' => 'matrix',
            'role_id' => $role->id,
        ])->with('success', 'Tidak ada masalah, hak akses berhasil diperbarui.');
    }

    /**
     * Create a new custom role
     */
    public function storeRole(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:roles,name'],
        ]);

        $role = Role::create([
            'name' => trim($validated['name']),
            'guard_name' => 'web',
        ]);

        // Default: give basic dashboard view
        $role->givePermissionTo('dashboard.view');

        // Audit Log
        AuditLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'user_role' => auth()->user()->roles->first()?->name ?? 'Admin',
            'action' => 'create_role',
            'target_type' => 'Role',
            'target_id' => $role->id,
            'target_name' => $role->name,
            'new_values' => ['name' => $role->name],
            'description' => "Membuat Role Baru: {$role->name}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.access-control.index', [
            'tab' => 'roles',
            'role_id' => $role->id,
        ])->with('success', "Role '{$role->name}' berhasil dibuat.");
    }

    /**
     * Update an existing role's name
     */
    public function updateRole(Request $request, Role $role): RedirectResponse
    {
        // System roles cannot be renamed
        $systemRoles = ['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Petugas Pendaftaran', 'Pasien'];
        if (in_array($role->name, $systemRoles)) {
            return back()->with('error', "Role sistem '{$role->name}' tidak boleh diubah namanya.");
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:roles,name,' . $role->id],
        ]);

        $oldName = $role->name;
        $role->update(['name' => trim($validated['name'])]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'user_role' => auth()->user()->roles->first()?->name ?? 'Admin',
            'action' => 'update_role',
            'target_type' => 'Role',
            'target_id' => $role->id,
            'target_name' => $role->name,
            'old_values' => ['name' => $oldName],
            'new_values' => ['name' => $role->name],
            'description' => "Mengubah Nama Role dari '{$oldName}' menjadi '{$role->name}'",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.access-control.index', [
            'tab' => 'roles',
            'role_id' => $role->id,
        ])->with('success', "Nama role berhasil diperbarui menjadi '{$role->name}'.");
    }

    /**
     * Delete a custom role with safety guards
     */
    public function deleteRole(Request $request, Role $role): RedirectResponse
    {
        // Safety guard: System roles cannot be deleted
        $systemRoles = ['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Petugas Pendaftaran', 'Pasien'];
        if (in_array($role->name, $systemRoles)) {
            return back()->with('error', "Role sistem inti '{$role->name}' tidak boleh dihapus.");
        }

        // Safety guard: Cannot delete role if assigned to active users
        if ($role->users()->count() > 0) {
            return back()->with('error', "Role '{$role->name}' tidak dapat dihapus karena masih digunakan oleh {$role->users()->count()} pengguna.");
        }

        $roleName = $role->name;
        $role->delete();

        // Clear Spatie cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        AuditLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'user_role' => auth()->user()->roles->first()?->name ?? 'Admin',
            'action' => 'delete_role',
            'target_type' => 'Role',
            'target_id' => null,
            'target_name' => $roleName,
            'description' => "Menghapus Custom Role: '{$roleName}'",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.access-control.index', ['tab' => 'roles'])
            ->with('success', "Role '{$roleName}' berhasil dihapus.");
    }

    /**
     * Update user role assignment
     */
    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        $newRole = $request->input('role');
        $oldRoles = $user->roles->pluck('name')->toArray();

        // Safety check: Cannot demote the last Super Admin
        if (in_array('Super Admin', $oldRoles) && $newRole !== 'Super Admin') {
            $superAdminCount = User::role('Super Admin')->where('status', true)->count();
            if ($superAdminCount <= 1) {
                return back()->with('error', 'Gagal: Akun ini adalah satu-satunya Super Admin aktif. Tidak dapat mengubah role.');
            }
        }

        $user->syncRoles([$newRole]);

        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        AuditLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'user_role' => auth()->user()->roles->first()?->name ?? 'Admin',
            'action' => 'update_user_role',
            'target_type' => 'User',
            'target_id' => $user->id,
            'target_name' => $user->name,
            'old_values' => ['roles' => $oldRoles],
            'new_values' => ['roles' => [$newRole]],
            'description' => "Mengubah Role User {$user->name} ({$user->email}) dari [" . implode(', ', $oldRoles) . "] menjadi [{$newRole}]",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.access-control.index', ['tab' => 'users'])
            ->with('success', "Role pengguna {$user->name} berhasil diperbarui menjadi {$newRole}.");
    }

    /**
     * Toggle User Active/Inactive Status
     */
    public function toggleUserStatus(Request $request, User $user): RedirectResponse
    {
        // Cannot deactivate self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        // Cannot deactivate last active Super Admin
        if ($user->hasRole('Super Admin') && $user->status) {
            $activeSuperAdmins = User::role('Super Admin')->where('status', true)->count();
            if ($activeSuperAdmins <= 1) {
                return back()->with('error', 'Tidak dapat menonaktifkan Super Admin terakhir di sistem.');
            }
        }

        $oldStatus = $user->status;
        $user->status = ! $user->status;
        $user->save();

        $statusText = $user->status ? 'Mengaktifkan' : 'Menonaktifkan';

        AuditLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'user_role' => auth()->user()->roles->first()?->name ?? 'Admin',
            'action' => 'toggle_user_status',
            'target_type' => 'User',
            'target_id' => $user->id,
            'target_name' => $user->name,
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $user->status],
            'description' => "{$statusText} Akun Pengguna: {$user->name} ({$user->email})",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.access-control.index', ['tab' => 'users'])
            ->with('success', "Status akun {$user->name} berhasil diubah menjadi " . ($user->status ? 'Aktif' : 'Nonaktif') . '.');
    }
}
