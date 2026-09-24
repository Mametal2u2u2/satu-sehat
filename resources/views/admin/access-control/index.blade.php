<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        Keamanan & Otorisasi
                    </span>
                    <span class="text-xs text-slate-300">•</span>
                    <span class="text-xs font-medium text-slate-500">SIMRS e-Klinik</span>
                </div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight mt-1">
                    Manajemen Hak Akses (RBAC)
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Konfigurasi hak akses berbasis peran: Pengguna &rarr; Role &rarr; Granular Permission &rarr; Modul Klinik
                </p>
            </div>

            <!-- Role Badge -->
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-xs font-medium bg-white border border-slate-200 text-slate-700 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Operator: <strong class="text-slate-900 font-semibold">{{ auth()->user()->name }}</strong> ({{ auth()->user()->roles->first()?->name ?? 'Staff' }})</span>
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5" x-data="{ 
        activeTab: '{{ request()->query('tab', 'matrix') }}',
        showConfirmModal: false,
        showNewRoleModal: false,
        showEditRoleModal: false,
        showUserRoleModal: false,
        editRoleData: { id: null, name: '' },
        editUserData: { id: null, name: '', email: '', role: '' },
        toggleAll(state) {
            document.querySelectorAll('.matrix-checkbox').forEach(cb => {
                if (!cb.disabled) cb.checked = state;
            });
        }
    }">

        <!-- Quick Stats Overview -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-2xs">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Total Role</span>
                <div class="flex items-baseline justify-between mt-1.5">
                    <span class="text-2xl font-bold text-slate-900">{{ $stats['total_roles'] }}</span>
                    <span class="text-[11px] font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded">Aktif</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-2xs">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Total Permission</span>
                <div class="flex items-baseline justify-between mt-1.5">
                    <span class="text-2xl font-bold text-slate-900">{{ $stats['total_permissions'] }}</span>
                    <span class="text-[11px] font-medium text-teal-700 bg-teal-50 border border-teal-200 px-2 py-0.5 rounded">Granular</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-2xs">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Pengguna Terdaftar</span>
                <div class="flex items-baseline justify-between mt-1.5">
                    <span class="text-2xl font-bold text-slate-900">{{ $stats['total_users'] }}</span>
                    <span class="text-[11px] font-medium text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded">Akun</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-2xs">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Audit Log Tercatat</span>
                <div class="flex items-baseline justify-between mt-1.5">
                    <span class="text-2xl font-bold text-slate-900">{{ $stats['total_audits'] }}</span>
                    <span class="text-[11px] font-medium text-slate-600 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded">Log Aktivitas</span>
                </div>
            </div>
        </div>

        <!-- Clean Tab Navigation -->
        <div class="bg-white p-1 rounded-lg border border-slate-200 shadow-2xs flex flex-wrap gap-1">
            <button @click="activeTab = 'matrix'" 
                    :class="activeTab === 'matrix' ? 'bg-teal-700 text-white font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium'"
                    class="flex items-center gap-2 px-3.5 py-2 rounded-md text-xs transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                <span>1. Matriks Hak Akses</span>
            </button>

            <button @click="activeTab = 'roles'" 
                    :class="activeTab === 'roles' ? 'bg-teal-700 text-white font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium'"
                    class="flex items-center gap-2 px-3.5 py-2 rounded-md text-xs transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                <span>2. Manajemen Role</span>
            </button>

            <button @click="activeTab = 'users'" 
                    :class="activeTab === 'users' ? 'bg-teal-700 text-white font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium'"
                    class="flex items-center gap-2 px-3.5 py-2 rounded-md text-xs transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <span>3. Pengguna & Role</span>
            </button>

            <button @click="activeTab = 'audit'" 
                    :class="activeTab === 'audit' ? 'bg-teal-700 text-white font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium'"
                    class="flex items-center gap-2 px-3.5 py-2 rounded-md text-xs transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>4. Audit Log Perubahan</span>
            </button>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 1: PERMISSION MATRIX -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'matrix'" x-transition class="space-y-4">
            
            <!-- Role Selector Bar -->
            <div class="bg-white p-4 rounded-lg border border-slate-200 shadow-2xs">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <div>
                            <span class="text-[11px] font-semibold tracking-wider text-slate-500 uppercase block mb-1">
                                Pilih Role Konfigurasi:
                            </span>
                            <form method="GET" action="{{ route('admin.access-control.index') }}" class="flex items-center gap-2">
                                <input type="hidden" name="tab" value="matrix">
                                <select name="role_id" onchange="this.form.submit()" class="py-2 pl-3 pr-8 bg-slate-50 border border-slate-300 rounded-md text-xs font-semibold text-slate-800 focus:ring-1 focus:ring-teal-600 focus:border-teal-600 cursor-pointer shadow-2xs">
                                    @foreach($roles as $r)
                                        <option value="{{ $r->id }}" {{ $selectedRole && $selectedRole->id == $r->id ? 'selected' : '' }}>
                                            Role: {{ $r->name }} ({{ $r->permissions_count }} permission)
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <div class="sm:pt-4 flex items-center gap-2">
                            @if($selectedRole->name === 'Super Admin')
                                <span class="px-2.5 py-1 rounded text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                    Super Admin • Hak Akses Penuh
                                </span>
                            @elseif($selectedRole->name === 'Pasien')
                                <span class="px-2.5 py-1 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Pasien • Portal Eksternal
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                    Staf Klinis / Operasional
                                </span>
                            @endif
                            <span class="text-xs text-slate-500 font-normal">
                                Digunakan {{ $selectedRole->users_count }} pengguna
                            </span>
                        </div>
                    </div>

                    <!-- Quick Tools -->
                    <div class="flex items-center gap-2">
                        <button type="button" @click="toggleAll(true)" class="px-3 py-1.5 text-xs font-medium text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 rounded-md transition-colors cursor-pointer">
                            Centang Semua
                        </button>
                        <button type="button" @click="toggleAll(false)" class="px-3 py-1.5 text-xs font-medium text-slate-600 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-md transition-colors cursor-pointer">
                            Hapus Semua
                        </button>
                    </div>
                </div>
            </div>

            <!-- Permission Form & Matrix Table -->
            <form id="matrixForm" method="POST" action="{{ route('admin.access-control.permissions.update', $selectedRole->id) }}">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-lg border border-slate-200 shadow-2xs overflow-hidden">
                    <div class="p-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                                Matriks Izin: Role <span class="text-teal-700 font-extrabold">{{ $selectedRole->name }}</span>
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Tentukan izin akses per modul dengan mencentang kotak relevan di bawah ini.
                            </p>
                        </div>
                        <span class="text-xs font-mono font-medium text-slate-600 bg-white border border-slate-200 px-2.5 py-1 rounded">
                            {{ count($activeRolePermissionNames) }} Aktif
                        </span>
                    </div>

                    <!-- Table Matrix -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-semibold uppercase tracking-wider text-slate-600">
                                    <th class="py-3 px-4">Modul / Menu Layanan</th>
                                    <th class="py-3 px-3 text-center w-28">View (Lihat)</th>
                                    <th class="py-3 px-3 text-center w-28">Create (Tambah)</th>
                                    <th class="py-3 px-3 text-center w-28">Edit (Ubah)</th>
                                    <th class="py-3 px-3 text-center w-28">Delete (Hapus)</th>
                                    <th class="py-3 px-4 text-center">Aksi Spesifik</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @foreach($modules as $moduleKey => $module)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-slate-900">{{ $module['label'] }}</div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">{{ $module['description'] }}</div>
                                    </td>

                                    <!-- VIEW -->
                                    <td class="py-3 px-3 text-center">
                                        @if(isset($module['permissions']['view']))
                                            @php $pName = $module['permissions']['view']; @endphp
                                            <label class="inline-flex items-center justify-center p-1 rounded hover:bg-slate-100 cursor-pointer">
                                                <input type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $pName }}" 
                                                       class="matrix-checkbox rounded border-slate-300 text-teal-700 shadow-2xs focus:ring-teal-600 w-4 h-4 cursor-pointer"
                                                       {{ in_array($pName, $activeRolePermissionNames) ? 'checked' : '' }}
                                                       {{ $selectedRole->name === 'Super Admin' ? 'checked disabled' : '' }}>
                                            </label>
                                        @else
                                            <span class="text-slate-300 font-mono text-sm">&mdash;</span>
                                        @endif
                                    </td>

                                    <!-- CREATE -->
                                    <td class="py-3 px-3 text-center">
                                        @if(isset($module['permissions']['create']))
                                            @php $pName = $module['permissions']['create']; @endphp
                                            <label class="inline-flex items-center justify-center p-1 rounded hover:bg-slate-100 cursor-pointer">
                                                <input type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $pName }}" 
                                                       class="matrix-checkbox rounded border-slate-300 text-teal-700 shadow-2xs focus:ring-teal-600 w-4 h-4 cursor-pointer"
                                                       {{ in_array($pName, $activeRolePermissionNames) ? 'checked' : '' }}
                                                       {{ $selectedRole->name === 'Super Admin' ? 'checked disabled' : '' }}>
                                            </label>
                                        @else
                                            <span class="text-slate-300 font-mono text-sm">&mdash;</span>
                                        @endif
                                    </td>

                                    <!-- EDIT -->
                                    <td class="py-3 px-3 text-center">
                                        @if(isset($module['permissions']['edit']))
                                            @php $pName = $module['permissions']['edit']; @endphp
                                            <label class="inline-flex items-center justify-center p-1 rounded hover:bg-slate-100 cursor-pointer">
                                                <input type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $pName }}" 
                                                       class="matrix-checkbox rounded border-slate-300 text-teal-700 shadow-2xs focus:ring-teal-600 w-4 h-4 cursor-pointer"
                                                       {{ in_array($pName, $activeRolePermissionNames) ? 'checked' : '' }}
                                                       {{ $selectedRole->name === 'Super Admin' ? 'checked disabled' : '' }}>
                                            </label>
                                        @else
                                            <span class="text-slate-300 font-mono text-sm">&mdash;</span>
                                        @endif
                                    </td>

                                    <!-- DELETE -->
                                    <td class="py-3 px-3 text-center">
                                        @if(isset($module['permissions']['delete']))
                                            @php $pName = $module['permissions']['delete']; @endphp
                                            <label class="inline-flex items-center justify-center p-1 rounded hover:bg-slate-100 cursor-pointer">
                                                <input type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $pName }}" 
                                                       class="matrix-checkbox rounded border-slate-300 text-rose-600 shadow-2xs focus:ring-rose-500 w-4 h-4 cursor-pointer"
                                                       {{ in_array($pName, $activeRolePermissionNames) ? 'checked' : '' }}
                                                       {{ $selectedRole->name === 'Super Admin' ? 'checked disabled' : '' }}>
                                            </label>
                                        @else
                                            <span class="text-slate-300 font-mono text-sm">&mdash;</span>
                                        @endif
                                    </td>

                                    <!-- FITUR KHUSUS -->
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex flex-wrap items-center justify-center gap-1.5">
                                            @foreach($module['permissions'] as $act => $pName)
                                                @if(!in_array($act, ['view', 'create', 'edit', 'delete']))
                                                    <label class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded border border-slate-200 bg-slate-50 hover:bg-slate-100 cursor-pointer text-[11px] font-medium text-slate-700">
                                                        <input type="checkbox" 
                                                               name="permissions[]" 
                                                               value="{{ $pName }}" 
                                                               class="matrix-checkbox rounded border-slate-300 text-teal-700 shadow-2xs focus:ring-teal-600 w-3.5 h-3.5 cursor-pointer"
                                                               {{ in_array($pName, $activeRolePermissionNames) ? 'checked' : '' }}
                                                               {{ $selectedRole->name === 'Super Admin' ? 'checked disabled' : '' }}>
                                                        <span>{{ ucfirst(str_replace('_', ' ', $act)) }}</span>
                                                    </label>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Action Bar -->
                    <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-xs text-slate-500">
                            Perubahan matriks izin akan langsung aktif secara realtime dan tercatat dalam sistem audit trail.
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <button type="button" 
                                    @click="showConfirmModal = true"
                                    class="w-full sm:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white font-medium text-xs rounded-md transition-colors shadow-2xs cursor-pointer">
                                Simpan Hak Akses
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 2: MANAJEMEN ROLE -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'roles'" x-transition class="space-y-4">
            <div class="bg-white rounded-lg border border-slate-200 shadow-2xs overflow-hidden">
                <div class="p-4 border-b border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Daftar Peran Sistem e-Klinik</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola role yang tersedia untuk pengelompokan hak akses staf klinis dan pasien.</p>
                    </div>
                    <button type="button" 
                            @click="showNewRoleModal = true"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-700 hover:bg-teal-800 text-white font-medium text-xs rounded-md shadow-2xs transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Role Baru</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-semibold uppercase tracking-wider text-slate-600">
                                <th class="py-3 px-4">Nama Role</th>
                                <th class="py-3 px-4">Kategori Peran</th>
                                <th class="py-3 px-4 text-center">Jumlah Permission</th>
                                <th class="py-3 px-4 text-center">Jumlah Pengguna</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @foreach($roles as $roleItem)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3.5 px-4 font-semibold text-slate-900 flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-700 font-bold text-xs">
                                        {{ strtoupper(substr($roleItem->name, 0, 2)) }}
                                    </div>
                                    <span>{{ $roleItem->name }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if(in_array($roleItem->name, ['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Petugas Pendaftaran', 'Pasien']))
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                            Role Sistem Baku
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            Role Tambahan (Custom)
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center font-medium text-slate-800">
                                    {{ $roleItem->permissions_count }} izin
                                </td>
                                <td class="py-3.5 px-4 text-center font-medium text-slate-800">
                                    {{ $roleItem->users_count }} user
                                </td>
                                <td class="py-3.5 px-4 text-right space-x-1.5">
                                    <a href="{{ route('admin.access-control.index', ['tab' => 'matrix', 'role_id' => $roleItem->id]) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1 bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 rounded text-xs font-medium transition-colors">
                                        Matriks Izin
                                    </a>

                                    @if(!in_array($roleItem->name, ['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Petugas Pendaftaran', 'Pasien']))
                                        <button type="button" 
                                                @click="editRoleData = { id: {{ $roleItem->id }}, name: '{{ $roleItem->name }}' }; showEditRoleModal = true"
                                                class="px-2.5 py-1 text-xs font-medium text-slate-700 hover:text-slate-900 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded transition-colors cursor-pointer">
                                            Edit
                                        </button>

                                        <form method="POST" action="{{ route('admin.access-control.roles.delete', $roleItem->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus role \'{{ $roleItem->name }}\'?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 text-xs font-medium text-rose-700 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded transition-colors cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 3: PENGGUNA & ROLE -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'users'" x-transition class="space-y-4">
            <div class="bg-white rounded-lg border border-slate-200 shadow-2xs overflow-hidden">
                <div class="p-4 border-b border-slate-200 bg-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Daftar Pengguna & Penugasan Peran</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Atur hak akses individu dengan menetapkan role dan status keaktifan akun.</p>
                    </div>

                    <!-- Filter & Search -->
                    <form method="GET" action="{{ route('admin.access-control.index') }}" class="flex flex-wrap items-center gap-2">
                        <input type="hidden" name="tab" value="users">
                        
                        <select name="filter_role" onchange="this.form.submit()" class="py-1.5 px-3 bg-white border border-slate-300 rounded-md text-xs font-medium text-slate-700">
                            <option value="">Semua Role</option>
                            @foreach($roles as $r)
                                <option value="{{ $r->name }}" {{ $filterRole === $r->name ? 'selected' : '' }}>{{ $r->name }}</option>
                            @endforeach
                        </select>

                        <div class="relative">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, email, username..." class="py-1.5 pl-3 pr-8 bg-white border border-slate-300 rounded-md text-xs text-slate-800 w-52 focus:ring-1 focus:ring-teal-600 focus:border-teal-600">
                            <button type="submit" class="absolute right-2.5 top-2 text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-semibold uppercase tracking-wider text-slate-600">
                                <th class="py-3 px-4">Nama Lengkap</th>
                                <th class="py-3 px-4">Username / Email</th>
                                <th class="py-3 px-4">Role Aktif</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @foreach($users as $userItem)
                            @php $uRole = $userItem->roles->first()?->name ?? 'Belum Ada Role'; @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-900">{{ $userItem->name }}</div>
                                    <div class="text-[11px] text-slate-500">Terdaftar: {{ $userItem->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="py-3 px-4 font-mono text-[11px] text-slate-600">
                                    <div>{{ $userItem->username ?: '-' }}</div>
                                    <div class="text-slate-400">{{ $userItem->email }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium {{ $uRole === 'Super Admin' ? 'bg-purple-50 text-purple-700 border border-purple-200' : ($uRole === 'Pasien' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-blue-50 text-blue-700 border border-blue-200') }}">
                                        {{ $uRole }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($userItem->status)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right space-x-1.5">
                                    <!-- Edit Role Button -->
                                    <button type="button" 
                                            @click="editUserData = { id: {{ $userItem->id }}, name: '{{ $userItem->name }}', email: '{{ $userItem->email }}', role: '{{ $uRole }}' }; showUserRoleModal = true"
                                            class="px-2.5 py-1 text-xs font-medium text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded transition-colors cursor-pointer">
                                        Ubah Role
                                    </button>

                                    <!-- Toggle Status Button -->
                                    @if($userItem->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.access-control.users.toggle-status', $userItem->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="px-2.5 py-1 text-xs font-medium rounded border transition-colors cursor-pointer {{ $userItem->status ? 'text-rose-700 hover:text-rose-900 bg-rose-50 border-rose-200' : 'text-emerald-700 hover:text-emerald-900 bg-emerald-50 border-emerald-200' }}"
                                                title="{{ $userItem->status ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                            {{ $userItem->status ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                <div class="p-3 border-t border-slate-200 bg-slate-50">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 4: AUDIT LOG -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'audit'" x-transition class="space-y-4">
            <div class="bg-white rounded-lg border border-slate-200 shadow-2xs overflow-hidden">
                <div class="p-4 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Audit Log Perubahan Hak Akses & Pengguna</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Catatan aktivitas tercatat mengenai perubahan wewenang, role, dan akun operator.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-semibold uppercase tracking-wider text-slate-600">
                                <th class="py-3 px-4">Waktu Kejadian</th>
                                <th class="py-3 px-4">Pelaksana (Operator)</th>
                                <th class="py-3 px-4">Aktivitas</th>
                                <th class="py-3 px-4">Objek Target</th>
                                <th class="py-3 px-4">Deskripsi Modifikasi</th>
                                <th class="py-3 px-4 text-right">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($auditLogs as $log)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 px-4 whitespace-nowrap text-slate-600 font-mono text-[11px]">
                                    {{ $log->created_at->format('d-m-Y H:i:s') }}
                                    <span class="block text-[10px] text-slate-400 font-sans">{{ $log->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-900">{{ $log->user_name ?: 'Sistem' }}</div>
                                    <div class="text-[10px] text-slate-500">Role: {{ $log->user_role ?: '-' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-medium text-slate-800">
                                    {{ $log->target_type }}: <span class="text-teal-700 font-semibold">{{ $log->target_name }}</span>
                                </td>
                                <td class="py-3 px-4 text-slate-600 max-w-md">
                                    <p class="leading-relaxed">{{ $log->description }}</p>
                                </td>
                                <td class="py-3 px-4 text-right font-mono text-[11px] text-slate-400">
                                    {{ $log->ip_address ?: '127.0.0.1' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                                    Belum ada catatan audit trail perubahan hak akses.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($auditLogs->hasPages())
                <div class="p-3 border-t border-slate-200 bg-slate-50">
                    {{ $auditLogs->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- MODALS -->
        <!-- ============================================================== -->

        <!-- 1. Modal Konfirmasi Simpan Matrix -->
        <div x-show="showConfirmModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60">
            <div @click.away="showConfirmModal = false" class="bg-white rounded-lg p-5 max-w-md w-full shadow-xl border border-slate-200">
                <div class="w-10 h-10 rounded bg-teal-50 border border-teal-200 text-teal-700 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-slate-900 mb-1">Konfirmasi Pembaruan Hak Akses</h3>
                <p class="text-xs text-slate-600 leading-relaxed mb-5">
                    Anda akan menyimpan konfigurasi permission untuk role <strong class="text-slate-900 font-semibold">{{ $selectedRole->name }}</strong>. Perubahan ini akan segera berlaku saat pengguna dengan role ini mengakses sistem.
                </p>
                <div class="flex items-center justify-end gap-2">
                    <button type="button" @click="showConfirmModal = false" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-xs rounded-md transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="button" @click="document.getElementById('matrixForm').submit()" class="px-4 py-1.5 bg-teal-700 hover:bg-teal-800 text-white font-medium text-xs rounded-md transition-colors shadow-2xs cursor-pointer">
                        Ya, Terapkan Sekarang
                    </button>
                </div>
            </div>
        </div>

        <!-- 2. Modal Tambah Role Baru -->
        <div x-show="showNewRoleModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60">
            <div @click.away="showNewRoleModal = false" class="bg-white rounded-lg p-5 max-w-md w-full shadow-xl border border-slate-200">
                <h3 class="text-sm font-bold text-slate-900 mb-1">Buat Role Baru</h3>
                <p class="text-xs text-slate-500 mb-4">Tambahkan role kustom baru untuk kebutuhan operasional klinik.</p>
                <form method="POST" action="{{ route('admin.access-control.roles.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Role Baru:</label>
                        <input type="text" name="name" placeholder="Misal: Staf Kasir / Radiografer" required class="w-full py-2 px-3 rounded-md border border-slate-300 text-xs font-medium focus:ring-1 focus:ring-teal-600 focus:border-teal-600">
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" @click="showNewRoleModal = false" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-xs rounded-md transition-colors cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-1.5 bg-teal-700 hover:bg-teal-800 text-white font-medium text-xs rounded-md transition-colors shadow-2xs cursor-pointer">
                            Simpan Role
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 3. Modal Edit Nama Role -->
        <div x-show="showEditRoleModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60">
            <div @click.away="showEditRoleModal = false" class="bg-white rounded-lg p-5 max-w-md w-full shadow-xl border border-slate-200">
                <h3 class="text-sm font-bold text-slate-900 mb-1">Ubah Nama Role</h3>
                <p class="text-xs text-slate-500 mb-4">Perbarui nama identitas role.</p>
                <form :action="'{{ url('admin/hak-akses/roles') }}/' + editRoleData.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Role:</label>
                        <input type="text" name="name" x-model="editRoleData.name" required class="w-full py-2 px-3 rounded-md border border-slate-300 text-xs font-medium focus:ring-1 focus:ring-teal-600 focus:border-teal-600">
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" @click="showEditRoleModal = false" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-xs rounded-md transition-colors cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-1.5 bg-teal-700 hover:bg-teal-800 text-white font-medium text-xs rounded-md transition-colors shadow-2xs cursor-pointer">
                            Perbarui Nama
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 4. Modal Ubah Role Pengguna -->
        <div x-show="showUserRoleModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60">
            <div @click.away="showUserRoleModal = false" class="bg-white rounded-lg p-5 max-w-md w-full shadow-xl border border-slate-200">
                <h3 class="text-sm font-bold text-slate-900 mb-1">Penugasan Role Pengguna</h3>
                <p class="text-xs text-slate-500 mb-4">
                    Pengguna: <strong class="text-slate-800" x-text="editUserData.name"></strong> (<span x-text="editUserData.email"></span>)
                </p>
                <form :action="'{{ url('admin/hak-akses/users') }}/' + editUserData.id + '/role'" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Role Baru:</label>
                        <select name="role" x-model="editUserData.role" required class="w-full py-2 px-3 rounded-md border border-slate-300 text-xs font-semibold text-slate-800 focus:ring-1 focus:ring-teal-600 focus:border-teal-600">
                            @foreach($roles as $r)
                                <option value="{{ $r->name }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" @click="showUserRoleModal = false" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-xs rounded-md transition-colors cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-1.5 bg-teal-700 hover:bg-teal-800 text-white font-medium text-xs rounded-md transition-colors shadow-2xs cursor-pointer">
                            Perbarui Role Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
