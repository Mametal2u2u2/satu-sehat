@php
    $user = auth()->user();
    $roleName = $user?->roles->first()?->name ?? 'Staf Medis';
    
    // Dynamic permission-based access checks (USER -> ROLE -> PERMISSION)
    $canAccessDashboard = $user && $user->can('dashboard.view');
    $canAccessAntrian = $user && $user->can('antrian.view');
    $canAccessJadwal = $user && $user->can('jadwal.view');
    $canAccessEMR = $user && $user->can('rekam_medis.view');
    $canAccessFarmasi = $user && ($user->can('obat.view') || $user->can('resep.view'));
    $canAccessMaster = $user && $user->can('master.view');
    $canAccessHakAkses = $user && ($user->can('role.view') || $user->can('permission.view') || $user->can('audit_log.view') || $user->hasRole('Super Admin'));
    $canBackupDb = $user && $user->can('backup.view');
    $canAccessPanduan = $user && $user->can('panduan.view');

    // Granular Action Permissions
    $canAddObat = $user && $user->can('obat.create');
    $canCreateResep = $user && $user->can('resep.create');
    $canAddAntrian = $user && $user->can('antrian.create');
@endphp

<aside class="flex flex-col h-full bg-white border-r border-slate-200 select-none">
    <!-- Brand / Clinic Header with Role Tag -->
    <div class="h-14 flex items-center justify-between px-4 border-b border-slate-200 shrink-0 bg-white">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 min-w-0">
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0">
                <x-clinic-logo class="w-8 h-8" />
            </div>
            <div class="min-w-0">
                <div class="flex items-center gap-1.5">
                    <span class="font-bold text-xs tracking-tight text-slate-900 block truncate">Satu Sehat LPSK</span>
                    <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[9px] font-semibold bg-teal-50 text-teal-800 border border-teal-200">
                        {{ $roleName }}
                    </span>
                </div>
                <span class="text-[10px] text-slate-400 block truncate">Sistem Informasi e-Klinik</span>
            </div>
        </a>

        <!-- Mobile close button -->
        <button @click="sidebarOpen = false" class="md:hidden p-1.5 text-slate-400 hover:text-slate-700 rounded-md focus:outline-none" aria-label="Tutup Menu">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Menu Items -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-4 font-sans text-xs">
        
        <!-- Section: Layanan Utama -->
        <div>
            <span class="px-2 text-[10px] font-semibold tracking-wider text-slate-400 uppercase block mb-1.5">
                Layanan Utama
            </span>
            <div class="space-y-0.5">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                    </svg>
                    <span class="flex-1">Dashboard</span>
                </a>

                <!-- Antrian Pasien -->
                @if($canAccessAntrian)
                <a href="{{ route('admin.antrian') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('admin.antrian*') || request()->routeIs('antrian.*') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.antrian*') || request()->routeIs('antrian.*') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="flex-1">Antrean Pasien</span>
                </a>
                @endif

                <!-- Jadwal Dokter & Cuti -->
                @if($canAccessJadwal)
                <a href="{{ route('admin.jadwal') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('admin.jadwal*') || request()->routeIs('jadwal.*') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.jadwal*') || request()->routeIs('jadwal.*') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    <span class="flex-1">Jadwal & Cuti Dokter</span>
                </a>
                @endif

                <!-- Rekam Medis Pasien (EMR) -->
                @if($canAccessEMR)
                <a href="{{ route('admin.rekam-medis') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('admin.rekam-medis*') || request()->routeIs('rekam-medis.*') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.rekam-medis*') || request()->routeIs('rekam-medis.*') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="flex-1">Rekam Medis (EMR)</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Section: Farmasi & Apotek -->
        @if($canAccessFarmasi)
        <div>
            <span class="px-2 text-[10px] font-semibold tracking-wider text-slate-400 uppercase block mb-1.5">
                Farmasi & Apotek
            </span>
            <div class="space-y-0.5">
                <!-- Sediaan Obat -->
                <a href="{{ route('admin.dashboard', ['tab' => 'obat']) }}#section-content" 
                   @click.prevent="switchClinicTab('obat'); if (window.innerWidth < 768) sidebarOpen = false;"
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium transition-colors cursor-pointer">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    <span class="flex-1">Stok Obat & Sediaan</span>
                </a>

                <!-- E-Resep Obat -->
                <a href="{{ route('admin.dashboard', ['tab' => 'resep']) }}#section-content" 
                   @click.prevent="switchClinicTab('resep'); if (window.innerWidth < 768) sidebarOpen = false;"
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium transition-colors cursor-pointer">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="flex-1">E-Resep Farmasi</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Section: Data Master -->
        @if($canAccessMaster)
        <div x-data="{ openMasterSidebar: true }">
            <div class="flex items-center justify-between px-2 mb-1.5">
                <span class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">
                    Data Master
                </span>
                <button @click="openMasterSidebar = !openMasterSidebar" type="button" class="text-slate-400 hover:text-slate-600 text-[10px] font-medium focus:outline-none flex items-center gap-0.5 cursor-pointer">
                    <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': !openMasterSidebar }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>
            <div x-show="openMasterSidebar" x-transition class="space-y-0.5">
                <!-- Data Master Klinik (Lihat Semua) -->
                <a href="{{ route('admin.dashboard', ['modal' => 'master']) }}" 
                   @click.prevent="openClinicModal('master'); if (window.innerWidth < 768) sidebarOpen = false;"
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium transition-colors cursor-pointer">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16" />
                    </svg>
                    <span class="flex-1">Pusat Data Master</span>
                </a>

                <!-- Submenu: Tambah Data di dalam Data Master -->
                <div class="pl-4 space-y-0.5 border-l border-slate-200 ml-4 py-0.5">
                    <button type="button"
                       @click="openClinicModal('master', 'dokter', true); if (window.innerWidth < 768) sidebarOpen = false;"
                       class="w-full flex items-center justify-between px-2 py-1.5 rounded text-[11px] text-slate-600 hover:text-teal-900 hover:bg-slate-100 transition-colors cursor-pointer text-left font-medium">
                        <span>Master Dokter</span>
                        <span class="text-[10px] text-slate-400">+</span>
                    </button>

                    <button type="button"
                       @click="openClinicModal('master', 'poli', true); if (window.innerWidth < 768) sidebarOpen = false;"
                       class="w-full flex items-center justify-between px-2 py-1.5 rounded text-[11px] text-slate-600 hover:text-teal-900 hover:bg-slate-100 transition-colors cursor-pointer text-left font-medium">
                        <span>Master Poliklinik</span>
                        <span class="text-[10px] text-slate-400">+</span>
                    </button>

                    <button type="button"
                       @click="openClinicModal('master', 'tindakan', true); if (window.innerWidth < 768) sidebarOpen = false;"
                       class="w-full flex items-center justify-between px-2 py-1.5 rounded text-[11px] text-slate-600 hover:text-teal-900 hover:bg-slate-100 transition-colors cursor-pointer text-left font-medium">
                        <span>Master Tindakan Medis</span>
                        <span class="text-[10px] text-slate-400">+</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <div class="pt-2 border-t border-slate-200"></div>

        <!-- Section: Administrasi & Sistem -->
        <div>
            <span class="px-2 text-[10px] font-semibold tracking-wider text-slate-400 uppercase block mb-1.5">
                Administrasi & Sistem
            </span>
            <div class="space-y-0.5">
                <!-- Manajemen Hak Akses (Khusus yang memiliki permission) -->
                @if($canAccessHakAkses)
                <a href="{{ route('admin.access-control.index') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('admin.access-control*') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.access-control*') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span class="flex-1">Manajemen Hak Akses</span>
                    <span class="px-1.5 py-0.2 text-[9px] font-medium rounded bg-purple-50 text-purple-700 border border-purple-200">RBAC</span>
                </a>
                @endif

                <!-- Backup Database (Khusus Super Admin & Admin Klinik) -->
                @if($canBackupDb)
                <a href="{{ route('admin.backup') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('admin.backup*') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.backup*') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16" />
                    </svg>
                    <span class="flex-1">Backup Database</span>
                </a>
                @endif

                <!-- Panduan Singkat -->
                @if($canAccessPanduan)
                <a href="{{ route('admin.panduan') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('admin.panduan*') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('admin.panduan*') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="flex-1">Panduan Singkat</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Section: Portal Pasien Switcher -->
        <div>
            <span class="px-2 text-[10px] font-semibold tracking-wider text-slate-400 uppercase block mb-1.5">
                Tampilan Pasien
            </span>
            <a href="{{ route('patient.dashboard') }}" 
               class="flex items-center justify-between p-2 rounded-md bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-700 transition-colors"
               title="Buka & Akses Antarmuka Portal Pasien">
                <span class="text-xs font-medium">Buka Portal Pasien</span>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

    </div>

    <!-- User Profile Footer with Role Tag & Logout -->
    <div class="p-3 border-t border-slate-200 bg-slate-50 shrink-0">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 min-w-0">
                <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs shrink-0">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-slate-800 truncate">
                        {{ auth()->user()?->name ?? 'Admin LPSK' }}
                    </p>
                    <p class="text-[10px] text-slate-500 truncate">
                        {{ $roleName }}
                    </p>
                </div>
            </div>

            <!-- Logout form -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        title="Keluar / Logout" 
                        class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
