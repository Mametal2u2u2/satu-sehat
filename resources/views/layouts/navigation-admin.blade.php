@php
    $user = auth()->user();
    $roleName = $user?->roles->first()?->name ?? 'Staf Medis';
    
    // Role-based permission checks
    $canManageMaster = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik']);
    $canAccessAntrian = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Approver']);
    $canAccessJadwal = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Approver']);
    $canAccessEMR = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Fisioterapis']);
    $canAccessFarmasi = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik', 'Apoteker', 'Dokter']);
    $canBackupDb = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik']);

    // Action permissions
    $canAddObat = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik', 'Apoteker']);
    $canCreateResep = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik', 'Dokter']);
    $canAddAntrian = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik', 'Perawat']);
@endphp

<aside class="flex flex-col h-full bg-white border-r border-slate-100 select-none">
    <!-- Brand / Clinic Header with Role Tag (Matching Patient Sidebar Style) -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100 shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 min-w-0">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0">
                <x-clinic-logo class="w-10 h-10" />
            </div>
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <span class="font-extrabold text-sm tracking-tight text-slate-900 block truncate">Satu Sehat LPSK</span>
                </div>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="text-[11px] text-slate-400 font-medium block truncate">Melayani dengan Hati</span>
                    <span class="inline-flex items-center gap-1 px-1.5 py-0.2 rounded-full text-[9px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        {{ $roleName }}
                    </span>
                </div>
            </div>
        </a>

        <!-- Mobile close button -->
        <button @click="sidebarOpen = false" class="md:hidden p-2 -mr-2 text-slate-400 hover:text-slate-700 rounded-lg focus:outline-none" aria-label="Tutup Menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Menu Items -->
    <div class="flex-1 overflow-y-auto px-4 py-5 space-y-5 font-sans">
        
        <!-- Section: Menu Utama -->
        <div>
            <span class="px-3 text-[10px] font-extrabold tracking-wider text-slate-400 uppercase block mb-2">
                Menu Utama
            </span>
            <div class="space-y-1">
                <!-- Dashboard (Semua Peran Staf) -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl text-xs transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#e6f4ea] text-[#137333] font-extrabold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-semibold' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-[#137333]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1.5" />
                        <rect x="14" y="3" width="7" height="7" rx="1.5" />
                        <rect x="14" y="14" width="7" height="7" rx="1.5" />
                        <rect x="3" y="14" width="7" height="7" rx="1.5" />
                    </svg>
                    <span class="flex-1">Dashboard</span>
                </a>

                <!-- Antrian Pasien -->
                @if($canAccessAntrian)
                <a href="{{ route('admin.antrian') }}" 
                   class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl text-xs transition-all {{ request()->routeIs('admin.antrian*') || request()->routeIs('antrian.*') ? 'bg-[#e6f4ea] text-[#137333] font-extrabold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-semibold' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.antrian*') || request()->routeIs('antrian.*') ? 'text-[#137333]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="flex-1">Antrian Pasien</span>
                    <span class="px-2 py-0.5 text-[9px] font-extrabold rounded-full bg-orange-50 text-orange-700 border border-orange-200">Live</span>
                </a>
                @endif

                <!-- Jadwal Dokter & Cuti -->
                @if($canAccessJadwal)
                <a href="{{ route('admin.jadwal') }}" 
                   class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl text-xs transition-all {{ request()->routeIs('admin.jadwal*') || request()->routeIs('jadwal.*') ? 'bg-[#e6f4ea] text-[#137333] font-extrabold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-semibold' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.jadwal*') || request()->routeIs('jadwal.*') ? 'text-[#137333]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
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
                   class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl text-xs transition-all {{ request()->routeIs('admin.rekam-medis*') || request()->routeIs('rekam-medis.*') ? 'bg-[#e6f4ea] text-[#137333] font-extrabold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-semibold' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.rekam-medis*') || request()->routeIs('rekam-medis.*') ? 'text-[#137333]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
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
            <span class="px-3 text-[10px] font-extrabold tracking-wider text-slate-400 uppercase block mb-2">
                Farmasi & Apotek
            </span>
            <div class="space-y-1">
                <!-- Sediaan Obat -->
                <a href="{{ route('admin.dashboard', ['tab' => 'obat']) }}#section-content" 
                   @click.prevent="switchClinicTab('obat'); if (window.innerWidth < 768) sidebarOpen = false;"
                   class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-all cursor-pointer">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    <span class="flex-1">Sediaan Obat & Stok</span>
                </a>

                <!-- E-Resep Obat -->
                <a href="{{ route('admin.dashboard', ['tab' => 'resep']) }}#section-content" 
                   @click.prevent="switchClinicTab('resep'); if (window.innerWidth < 768) sidebarOpen = false;"
                   class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-all cursor-pointer">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="flex-1">E-Resep & Farmasi</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Section: Data Master (Khusus Super Admin & Admin Klinik) -->
        @if($canManageMaster)
        <div x-data="{ openMasterSidebar: true }">
            <div class="flex items-center justify-between px-3 mb-2">
                <span class="text-[10px] font-extrabold tracking-wider text-slate-400 uppercase">
                    Data Master
                </span>
                <button @click="openMasterSidebar = !openMasterSidebar" type="button" class="text-slate-400 hover:text-slate-600 text-[10px] font-bold focus:outline-none flex items-center gap-0.5 cursor-pointer">
                    <span x-text="openMasterSidebar ? 'Sembunyikan' : 'Tampilkan'"></span>
                    <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': !openMasterSidebar }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>
            <div x-show="openMasterSidebar" x-transition class="space-y-1">
                <!-- Data Master Klinik (Lihat Semua) -->
                <a href="{{ route('admin.dashboard', ['modal' => 'master']) }}" 
                   @click.prevent="openClinicModal('master'); if (window.innerWidth < 768) sidebarOpen = false;"
                   class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-all cursor-pointer">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16" />
                    </svg>
                    <span class="flex-1">Pusat Data Master</span>
                </a>

                <!-- Submenu: Tambah Data di dalam Data Master -->
                <div class="pl-4 pr-1 py-1 space-y-1 border-l-2 border-emerald-200 ml-4">
                    <!-- Tambah Dokter -->
                    <button type="button"
                       @click="openClinicModal('master', 'dokter', true); if (window.innerWidth < 768) sidebarOpen = false;"
                       class="w-full flex items-center justify-between px-2.5 py-1.5 rounded-xl text-[11px] font-bold text-slate-600 hover:text-emerald-800 hover:bg-emerald-50/70 transition-all cursor-pointer text-left">
                        <span class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>Tambah Dokter</span>
                        </span>
                        <span class="text-[10px] text-emerald-600 font-mono font-bold">+</span>
                    </button>

                    <!-- Tambah Poli & Ruang -->
                    <button type="button"
                       @click="openClinicModal('master', 'poli', true); if (window.innerWidth < 768) sidebarOpen = false;"
                       class="w-full flex items-center justify-between px-2.5 py-1.5 rounded-xl text-[11px] font-bold text-slate-600 hover:text-emerald-800 hover:bg-emerald-50/70 transition-all cursor-pointer text-left">
                        <span class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>Tambah Poli / Ruang</span>
                        </span>
                        <span class="text-[10px] text-emerald-600 font-mono font-bold">+</span>
                    </button>

                    <!-- Tambah Tindakan & Tarif -->
                    <button type="button"
                       @click="openClinicModal('master', 'tindakan', true); if (window.innerWidth < 768) sidebarOpen = false;"
                       class="w-full flex items-center justify-between px-2.5 py-1.5 rounded-xl text-[11px] font-bold text-slate-600 hover:text-emerald-800 hover:bg-emerald-50/70 transition-all cursor-pointer text-left">
                        <span class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>Tambah Tindakan Medis</span>
                        </span>
                        <span class="text-[10px] text-emerald-600 font-mono font-bold">+</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- Section: Aksi Cepat (Aksi Cepat Berdasarkan Role) -->
        @if($canAddObat || $canCreateResep || $canAddAntrian || $canManageMaster)
        <div x-data="{ openAksiSidebar: true }">
            <div class="flex items-center justify-between px-3 mb-2">
                <span class="text-[10px] font-extrabold tracking-wider text-slate-400 uppercase">
                    Aksi Cepat
                </span>
                <button @click="openAksiSidebar = !openAksiSidebar" type="button" class="text-slate-400 hover:text-slate-600 text-[10px] font-bold focus:outline-none flex items-center gap-0.5 cursor-pointer">
                    <span x-text="openAksiSidebar ? 'Sembunyikan' : 'Tampilkan'"></span>
                    <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': !openAksiSidebar }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>
            <div x-show="openAksiSidebar" x-transition class="space-y-1.5">
                <!-- Tambah Obat Action (Apoteker / Admin) -->
                @if($canAddObat)
                <a href="{{ route('admin.dashboard', ['modal' => 'obat']) }}"
                   @click.prevent="openClinicModal('obat'); if (window.innerWidth < 768) sidebarOpen = false;"
                   class="w-full flex items-center justify-between px-3 py-2 rounded-xl bg-slate-50 hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 font-bold text-xs border border-slate-100 hover:border-emerald-200 transition-all cursor-pointer">
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Obat
                    </span>
                    <span class="text-[10px] text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded font-mono font-bold">+</span>
                </a>
                @endif

                <!-- Buat Resep Action (Dokter / Admin) -->
                @if($canCreateResep)
                <a href="{{ route('admin.dashboard', ['modal' => 'resep']) }}"
                   @click.prevent="openClinicModal('resep'); if (window.innerWidth < 768) sidebarOpen = false;"
                   class="w-full flex items-center justify-between px-3 py-2 rounded-xl bg-slate-50 hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 font-bold text-xs border border-slate-100 hover:border-emerald-200 transition-all cursor-pointer">
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Buat E-Resep
                    </span>
                    <span class="text-[10px] text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded font-mono font-bold">+</span>
                </a>
                @endif

                <!-- Tambah Pasien Antrian Action (Perawat / Admin) -->
                @if($canAddAntrian)
                <a href="{{ route('admin.antrian', ['modal' => 'tambah']) }}"
                   @click.prevent="openClinicModal('tambah-pasien'); if (window.innerWidth < 768) sidebarOpen = false;"
                   class="w-full flex items-center justify-between px-3 py-2 rounded-xl bg-slate-50 hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 font-bold text-xs border border-slate-100 hover:border-emerald-200 transition-all cursor-pointer">
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Antrian
                    </span>
                    <span class="text-[10px] text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded font-mono font-bold">+</span>
                </a>
                @endif

                <!-- Tambah Data Master Action (Super Admin & Admin Klinik) -->
                @if($canManageMaster)
                <a href="{{ route('admin.dashboard', ['modal' => 'master', 'add' => 1]) }}"
                   @click.prevent="openClinicModal('master', 'dokter', true); if (window.innerWidth < 768) sidebarOpen = false;"
                   class="w-full flex items-center justify-between px-3 py-2 rounded-xl bg-slate-50 hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 font-bold text-xs border border-slate-100 hover:border-emerald-200 transition-all cursor-pointer">
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Data Master
                    </span>
                    <span class="text-[10px] text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded font-mono font-bold">+</span>
                </a>
                @endif
            </div>
        </div>
        @endif

        <div class="pt-2 pb-1 border-t border-slate-100 my-1"></div>

        <!-- Section: Sistem, Cadangan & Bantuan -->
        <div>
            <span class="px-3 text-[10px] font-extrabold tracking-wider text-slate-400 uppercase block mb-2">
                Sistem & Bantuan
            </span>
            <div class="space-y-1">
                <!-- Backup Database (Khusus Super Admin & Admin Klinik) -->
                @if($canBackupDb)
                <a href="{{ route('admin.backup') }}" 
                   class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl text-xs transition-all {{ request()->routeIs('admin.backup*') ? 'bg-[#e6f4ea] text-[#137333] font-extrabold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-semibold' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.backup*') ? 'text-[#137333]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16" />
                    </svg>
                    <span class="flex-1">Backup Database</span>
                    <span class="px-1.5 py-0.5 text-[9px] font-extrabold rounded-md bg-purple-50 text-purple-700 border border-purple-100">Admin</span>
                </a>
                @endif

                <!-- Panduan Singkat (Semua Peran) -->
                <a href="{{ route('admin.panduan') }}" 
                   class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl text-xs transition-all {{ request()->routeIs('admin.panduan*') ? 'bg-[#e6f4ea] text-[#137333] font-extrabold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-semibold' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.panduan*') ? 'text-[#137333]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="flex-1">Panduan Singkat</span>
                    <span class="px-1.5 py-0.5 text-[9px] font-extrabold rounded-md bg-emerald-50 text-emerald-800 border border-emerald-100">Bantuan</span>
                </a>
            </div>
        </div>

        <!-- Section: Portal Switcher & Pengaturan Akun -->
        <div>
            <span class="px-3 text-[10px] font-extrabold tracking-wider text-slate-400 uppercase block mb-2">
                Akses & Pengaturan
            </span>
            <div class="space-y-1.5">
                <!-- Portal Pasien Switch Card -->
                <a href="{{ route('patient.dashboard') }}" 
                   class="flex items-center justify-between p-3 rounded-2xl bg-emerald-50/60 border border-emerald-100 hover:border-emerald-300 hover:bg-emerald-50 transition-all"
                   title="Buka & Akses Antarmuka Portal Pasien">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-7 h-7 rounded-xl bg-[#009669] text-white flex items-center justify-center shrink-0 shadow-2xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <span class="text-xs font-black text-slate-800 block truncate">Akses Portal Pasien</span>
                            <span class="text-[10px] text-slate-500 font-medium block truncate">Buka tampilan pasien</span>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <!-- Profil Admin -->
                <a href="{{ route('profile') }}" 
                   class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-all {{ request()->routeIs('profile') ? 'bg-slate-100 text-slate-900 font-bold' : '' }}">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="flex-1">Pengaturan Profil</span>
                </a>
            </div>
        </div>

    </div>

    <!-- User Profile Footer with Role Tag & Logout (Matching Patient Sidebar Style) -->
    <div class="p-4 border-t border-slate-100 bg-slate-50/50 shrink-0">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-full bg-[#dbeafe] text-[#1d4ed8] font-black flex items-center justify-center text-xs shrink-0 shadow-2xs">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-black text-slate-800 truncate">
                        {{ auth()->user()?->name ?? 'Admin LPSK' }}
                    </p>
                    <div class="flex items-center gap-1 mt-0.5">
                        <span class="inline-block text-[10px] text-slate-400 truncate">
                            {{ $roleName }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Logout form -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        title="Keluar / Logout" 
                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
