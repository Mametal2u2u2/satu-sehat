<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Satu Sehat LPSK') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <script>
            window.openClinicModal = function(name, tab, add) {
                const path = window.location.pathname;
                const isDashboard = path.includes('/admin/dashboard') || path.endsWith('/admin') || path === '/admin';
                const isAntrian = path.includes('/admin/antrian');
                const isJadwal = path.includes('/admin/jadwal');
                const isRM = path.includes('/admin/rekam-medis');

                if (name === 'obat' || name === 'resep' || name === 'master') {
                    if (isDashboard) {
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: { name: name, tab: tab, add: !!add } }));
                        return;
                    }
                    window.location.href = "{{ route('admin.dashboard') }}?modal=" + name + (tab ? '&masterTab=' + tab : '') + (add ? '&add=1' : '');
                } else if (name === 'tambah-pasien' || name === 'panggil-antrian' || name === 'tambah') {
                    if (isAntrian) {
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: { name: name } }));
                        return;
                    }
                    window.location.href = "{{ route('admin.antrian') }}?modal=" + (name === 'panggil-antrian' ? 'panggil' : 'tambah');
                } else if (name === 'tambah-jadwal') {
                    if (isJadwal) {
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: { name: name } }));
                        return;
                    }
                    window.location.href = "{{ route('admin.jadwal') }}?modal=tambah";
                } else if (name === 'tambah-rm' || name === 'cetak') {
                    if (isRM) {
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: { name: name } }));
                        return;
                    }
                    window.location.href = "{{ route('admin.rekam-medis') }}?modal=" + name;
                }
            };

            window.switchClinicTab = function(tab) {
                const path = window.location.pathname;
                const isDashboard = path.includes('/admin/dashboard') || path.endsWith('/admin') || path === '/admin';
                if (isDashboard) {
                    window.dispatchEvent(new CustomEvent('switch-tab', { detail: { tab: tab } }));
                    document.getElementById('section-content')?.scrollIntoView({ behavior: 'smooth' });
                } else {
                    window.location.href = "{{ route('admin.dashboard') }}?tab=" + tab + "#section-content";
                }
            };
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen">
        <!-- Global Toast Notification System -->
        <x-toast-notification />

        @php
            $user = auth()->user();
            $adminRoles = ['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Fisioterapis', 'Apoteker', 'Approver'];
            $isStaffOrAdmin = $user && $user->hasAnyRole($adminRoles);
            // Staff/admin users use admin layout, unless explicitly viewing patient portal
            $isAdmin = $isStaffOrAdmin && !request()->routeIs('patient.*') && !request()->is('pasien*');
        @endphp

        @if($isAdmin)
            <!-- =========================================================================
                 ADMIN & CLINICAL STAFF LAYOUT: ENTERPRISE SIDEBAR & TOPBAR
                 ========================================================================= -->
            <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-slate-50 flex flex-col md:flex-row font-sans">
                
                <!-- Mobile Backdrop Overlay -->
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition-opacity ease-linear duration-150"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="sidebarOpen = false" 
                     class="fixed inset-0 bg-slate-900/50 z-50 md:hidden"
                     style="display: none;">
                </div>

                <!-- Mobile Drawer Sidebar -->
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition ease-in-out duration-200 transform"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-200 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="fixed inset-y-0 left-0 w-64 max-w-[85vw] bg-white z-50 md:hidden shadow-lg border-r border-slate-200 flex flex-col"
                     style="display: none;">
                    @include('layouts.navigation-admin')
                </div>

                <!-- Desktop Left Sidebar (Fixed, Enterprise Style) -->
                <div class="hidden md:flex md:w-60 lg:w-64 md:flex-col md:fixed md:inset-y-0 z-40 bg-white border-r border-slate-200">
                    @include('layouts.navigation-admin')
                </div>

                <!-- Admin Main Content Area -->
                <div class="md:pl-60 lg:pl-64 flex-1 flex flex-col min-w-0 bg-slate-50">
                    
                    <!-- Enterprise Top Header Bar for Admin -->
                    <header class="sticky top-0 z-30 bg-white border-b border-slate-200">
                        <div class="px-4 sm:px-6 h-14 flex items-center justify-between gap-4">
                            
                            <!-- Left: Mobile Menu Trigger + Search Bar -->
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <!-- Mobile Hamburger -->
                                <button @click="sidebarOpen = true" 
                                        type="button"
                                        class="md:hidden p-1.5 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-md focus:outline-none shrink-0" 
                                        aria-label="Buka Menu Navigasi">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>

                                <!-- Clean Search Input -->
                                <div class="w-full max-w-sm">
                                    <div class="relative flex items-center">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" 
                                               placeholder="Cari pasien, antrean, resep, atau EMR..." 
                                               class="w-full pl-9 pr-3 py-1.5 bg-slate-50 text-xs font-normal text-slate-800 placeholder-slate-400 rounded-md border border-slate-300 focus:bg-white focus:border-teal-600 focus:ring-1 focus:ring-teal-600 transition-colors">
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Operational Date + Aksi Cepat + Notification Bell + User Profile -->
                            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                                
                                <!-- Operational Date Badge -->
                                <div class="hidden xl:flex items-center gap-1.5 px-2.5 py-1 rounded border border-slate-200 bg-slate-50 text-[11px] text-slate-600 font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-600"></span>
                                    <span>{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                                </div>

                                <!-- Quick Action Dropdown ("Aksi Cepat") -->
                                <div class="relative" x-data="{ openAksiHeader: false }">
                                    <button @click="openAksiHeader = !openAksiHeader" 
                                            @click.away="openAksiHeader = false"
                                            type="button"
                                            id="btn-aksi-header"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-700 hover:bg-teal-800 active:bg-teal-900 text-white text-xs font-semibold rounded-md shadow-2xs transition-colors cursor-pointer"
                                            title="Menu Aksi Cepat Operasional">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span class="hidden sm:inline">Aksi Cepat</span>
                                        <svg class="w-3 h-3 text-teal-200 transition-transform duration-150" :class="{ 'rotate-180': openAksiHeader }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div x-show="openAksiHeader" 
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         class="absolute right-0 mt-1.5 w-52 bg-white rounded-lg shadow-lg border border-slate-200 py-1.5 z-50 text-xs font-medium"
                                         style="display: none;">
                                        <div class="px-3 py-1 text-[10px] uppercase font-bold text-slate-400 tracking-wider">
                                            Tindakan Operasional
                                        </div>
                                        <!-- Tambah Obat -->
                                        <a href="{{ route('admin.dashboard', ['modal' => 'obat']) }}"
                                           @click.prevent="openClinicModal('obat'); openAksiHeader = false;"
                                           class="flex items-center gap-2 px-3 py-1.5 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors cursor-pointer">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                            <span>Tambah Obat Baru</span>
                                        </a>
                                        <!-- Buat E-Resep -->
                                        <a href="{{ route('admin.dashboard', ['modal' => 'resep']) }}"
                                           @click.prevent="openClinicModal('resep'); openAksiHeader = false;"
                                           class="flex items-center gap-2 px-3 py-1.5 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors cursor-pointer">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <span>Buat E-Resep</span>
                                        </a>
                                        <!-- Tambah Pasien Antrian -->
                                        <a href="{{ route('admin.antrian', ['modal' => 'tambah']) }}"
                                           @click.prevent="openClinicModal('tambah-pasien'); openAksiHeader = false;"
                                           class="flex items-center gap-2 px-3 py-1.5 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors cursor-pointer">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span>Tambah Antrean</span>
                                        </a>
                                        <!-- Data Master -->
                                        <a href="{{ route('admin.dashboard', ['modal' => 'master']) }}"
                                           @click.prevent="openClinicModal('master'); openAksiHeader = false;"
                                           class="flex items-center gap-2 px-3 py-1.5 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors cursor-pointer border-t border-slate-100 mt-1 pt-1">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16"/></svg>
                                            <span>Data Master Klinik</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Notification Bell -->
                                <button type="button" 
                                        class="relative p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-md transition-colors focus:outline-none"
                                        title="Notifikasi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                </button>

                                <div class="h-4 w-px bg-slate-200"></div>

                                <!-- User Profile Menu -->
                                <a href="{{ route('profile') }}" class="flex items-center gap-2 pl-1 pr-1.5 py-1 hover:bg-slate-50 rounded-md transition-colors" title="Profil Pengguna">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 border border-slate-200 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 2)) }}
                                    </div>
                                    <div class="hidden md:block text-left min-w-0">
                                        <span class="text-xs font-semibold text-slate-800 leading-tight block truncate max-w-[120px]">
                                            {{ auth()->user()?->name ?? 'Administrator' }}
                                        </span>
                                        <span class="text-[10px] text-slate-500 font-normal leading-none block">
                                            {{ auth()->user()?->roles->first()?->name ?? 'Staf' }}
                                        </span>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </header>

                    <!-- Main Admin Content Area -->
                    <main class="flex-1 p-4 sm:p-6 w-full max-w-[1440px] mx-auto">
                        {{ $slot }}
                    </main>

                </div>

            </div>

        @else
            <!-- =========================================================================
                 PATIENT / GENERAL LAYOUT: ENTERPRISE SIDEBAR & TOPBAR
                 ========================================================================= -->
            <div x-data="{ patientSidebarOpen: false }" class="min-h-screen bg-slate-50 flex flex-col md:flex-row font-sans">
                
                <!-- Mobile Backdrop Overlay -->
                <div x-show="patientSidebarOpen" 
                     x-transition:enter="transition-opacity ease-linear duration-150"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="patientSidebarOpen = false" 
                     class="fixed inset-0 bg-slate-900/50 z-50 md:hidden"
                     style="display: none;">
                </div>

                <!-- Mobile Drawer Sidebar -->
                <div x-show="patientSidebarOpen" 
                     x-transition:enter="transition ease-in-out duration-200 transform"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-200 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="fixed inset-y-0 left-0 w-64 max-w-[85vw] bg-white z-50 md:hidden shadow-lg border-r border-slate-200 flex flex-col"
                     style="display: none;">
                    @include('layouts.navigation-patient')
                </div>

                <!-- Desktop Left Sidebar (Fixed, Enterprise Style) -->
                <div class="hidden md:flex md:w-60 lg:w-64 md:flex-col md:fixed md:inset-y-0 z-40 bg-white border-r border-slate-200">
                    @include('layouts.navigation-patient')
                </div>

                <!-- Patient Main Content Area -->
                <div class="md:pl-60 lg:pl-64 flex-1 flex flex-col min-w-0 bg-slate-50">
                    
                    <!-- Clean Top Header Bar -->
                    <header class="sticky top-0 z-30 bg-white border-b border-slate-200">
                        <div class="px-4 sm:px-6 h-14 flex items-center justify-between gap-4">
                            
                            <!-- Left: Mobile Menu Trigger + Search Bar -->
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <!-- Mobile Hamburger -->
                                <button @click="patientSidebarOpen = true" 
                                        type="button"
                                        class="md:hidden p-1.5 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-md focus:outline-none shrink-0" 
                                        aria-label="Buka Menu">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>

                                <!-- Clean Search Input -->
                                <div class="w-full max-w-sm">
                                    <div class="relative flex items-center">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" 
                                               placeholder="Cari jadwal dokter atau informasi layanan..." 
                                               class="w-full pl-9 pr-3 py-1.5 bg-slate-50 text-xs font-normal text-slate-800 placeholder-slate-400 rounded-md border border-slate-300 focus:bg-white focus:border-teal-600 focus:ring-1 focus:ring-teal-600 transition-colors">
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Notification Bell + User Profile -->
                            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                                
                                <!-- Notification Bell -->
                                <button type="button" 
                                        @click="window.dispatchEvent(new CustomEvent('open-patient-modal', {detail: {name: 'reminder'}}))"
                                        class="relative p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-md transition-colors focus:outline-none cursor-pointer"
                                        title="Notifikasi & Pengingat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                </button>

                                <div class="h-4 w-px bg-slate-200"></div>

                                <!-- User Profile Menu -->
                                <a href="{{ route('profile') }}" class="flex items-center gap-2 pl-1 pr-1.5 py-1 hover:bg-slate-50 rounded-md transition-colors" title="Profil Pengguna">
                                    <div class="w-7 h-7 rounded-full bg-teal-50 text-teal-800 border border-teal-200 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ strtoupper(substr(auth()->user()?->name ?? 'P', 0, 2)) }}
                                    </div>
                                    <div class="hidden sm:block text-left min-w-0">
                                        <span class="text-xs font-semibold text-slate-800 leading-tight block truncate max-w-[120px]">
                                            {{ auth()->user()?->name ?? 'Pasien' }}
                                        </span>
                                        <span class="text-[10px] text-slate-500 font-normal leading-none block">
                                            Portal Pasien
                                        </span>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </header>

                    <!-- Main Content Wrapper -->
                    <main class="flex-1 p-4 sm:p-6 w-full max-w-[1320px] mx-auto pb-20 md:pb-8">
                        {{ $slot }}
                    </main>

                    <!-- Mobile Bottom Navigation -->
                    <div class="md:hidden">
                        <livewire:layout.navigation />
                    </div>

                </div>
            </div>
        @endif

        @livewireScripts
    </body>
</html>
