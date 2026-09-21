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
            $isAdmin = request()->routeIs('admin.*') || request()->is('admin*') || request()->routeIs('admin.dashboard') || request()->is('admin-dashboard*');
        @endphp

        @if($isAdmin)
            <!-- =========================================================================
                 ADMIN LAYOUT: SIDEBAR NAVIGATION (Matching Design System)
                 ========================================================================= -->
            <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-[#f8fafc] flex flex-col md:flex-row font-sans">
                
                <!-- Mobile Backdrop Overlay -->
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition-opacity ease-linear duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="sidebarOpen = false" 
                     class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 md:hidden"
                     style="display: none;">
                </div>

                <!-- Mobile Drawer Sidebar -->
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="fixed inset-y-0 left-0 w-64 max-w-[85vw] bg-white z-50 md:hidden shadow-2xl flex flex-col"
                     style="display: none;">
                    @include('layouts.navigation-admin')
                </div>

                <!-- Desktop Left Sidebar (Fixed on the side) -->
                <div class="hidden md:flex md:w-60 lg:w-64 md:flex-col md:fixed md:inset-y-0 z-40 bg-white border-r border-slate-100 shadow-[1px_0_10px_rgba(0,0,0,0.02)]">
                    @include('layouts.navigation-admin')
                </div>

                <!-- Admin Main Content Area -->
                <div class="md:pl-60 lg:pl-64 flex-1 flex flex-col min-w-0 bg-[#f8fafc]">
                    
                    <!-- Top App Header Bar for Admin -->
                    <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
                        <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
                            
                            <!-- Left: Mobile Menu Trigger + Search Bar -->
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <!-- Mobile Hamburger -->
                                <button @click="sidebarOpen = true" 
                                        type="button"
                                        class="md:hidden p-2 -ml-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl focus:outline-none shrink-0" 
                                        aria-label="Buka Menu Navigasi">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>

                                <!-- Search Pill Input (Matching Patient Header) -->
                                <div class="w-full max-w-md">
                                    <div class="relative flex items-center">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" 
                                               placeholder="Cari pasien, antrian, resep, atau data klinik..." 
                                               class="w-full pl-10 pr-4 py-2 bg-[#f1f5f9] text-xs font-medium text-slate-700 placeholder-slate-400 rounded-2xl border-0 focus:ring-2 focus:ring-emerald-500 transition-all">
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Operational Date + Aksi-Aksi + Notification Bell + User Profile Pill -->
                            <div class="flex items-center gap-2.5 sm:gap-3 shrink-0">
                                
                                <!-- Live Operational Time -->
                                <div class="hidden xl:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-100 text-xs text-slate-600 font-medium">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                                </div>

                                <!-- Quick Action Dropdown ("Aksi-Aksi") in Top Header -->
                                <div class="relative" x-data="{ openAksiHeader: false }">
                                    <button @click="openAksiHeader = !openAksiHeader" 
                                            @click.away="openAksiHeader = false"
                                            type="button"
                                            id="btn-aksi-header"
                                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-[#009669] hover:bg-[#007a55] active:scale-95 text-white text-xs font-bold rounded-xl shadow-xs transition-all cursor-pointer"
                                            title="Menu Aksi Cepat Operasional">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        <span class="hidden sm:inline">Aksi Cepat</span>
                                        <svg class="w-3 h-3 text-emerald-100 transition-transform duration-200" :class="{ 'rotate-180': openAksiHeader }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div x-show="openAksiHeader" 
                                         x-transition:enter="transition ease-out duration-150"
                                         x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-100"
                                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                                         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 divide-y divide-slate-100 text-xs font-semibold"
                                         style="display: none;">
                                        <div class="px-3.5 py-1.5 text-[10px] uppercase font-extrabold text-slate-400 tracking-wider">
                                            Tindakan Cepat Klinik
                                        </div>
                                        <div class="py-1">
                                            <!-- Tambah Obat -->
                                            <a href="{{ route('admin.dashboard', ['modal' => 'obat']) }}"
                                               @click.prevent="openClinicModal('obat'); openAksiHeader = false;"
                                               class="flex items-center gap-2.5 px-3.5 py-2 text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-colors cursor-pointer">
                                                <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                                </div>
                                                <span class="flex-1">Tambah Obat Baru</span>
                                            </a>
                                            <!-- Buat E-Resep -->
                                            <a href="{{ route('admin.dashboard', ['modal' => 'resep']) }}"
                                               @click.prevent="openClinicModal('resep'); openAksiHeader = false;"
                                               class="flex items-center gap-2.5 px-3.5 py-2 text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-colors cursor-pointer">
                                                <div class="w-6 h-6 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                </div>
                                                <span class="flex-1">Buat E-Resep</span>
                                            </a>
                                            <!-- Tambah Pasien Antrian -->
                                            <a href="{{ route('admin.antrian', ['modal' => 'tambah']) }}"
                                               @click.prevent="openClinicModal('tambah-pasien'); openAksiHeader = false;"
                                               class="flex items-center gap-2.5 px-3.5 py-2 text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-colors cursor-pointer">
                                                <div class="w-6 h-6 rounded-lg bg-orange-100 text-orange-700 flex items-center justify-center shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                </div>
                                                <span class="flex-1">Tambah Antrian</span>
                                            </a>
                                            <!-- Data Master -->
                                            <a href="{{ route('admin.dashboard', ['modal' => 'master']) }}"
                                               @click.prevent="openClinicModal('master'); openAksiHeader = false;"
                                               class="flex items-center gap-2.5 px-3.5 py-2 text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-colors cursor-pointer">
                                                <div class="w-6 h-6 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16"/></svg>
                                                </div>
                                                <span class="flex-1">Data Master Klinik</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notification Bell with Red Dot (Matching Patient Header) -->
                                <button type="button" 
                                        class="relative p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-colors focus:outline-none"
                                        title="Notifikasi">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                                </button>

                                <!-- User Profile Pill (Matching Patient Header Style) -->
                                <a href="{{ route('profile') }}" class="flex items-center gap-2.5 pl-2 py-1 pr-1 hover:bg-slate-50 rounded-2xl transition-all" title="Profil Pengguna">
                                    <div class="w-9 h-9 rounded-full bg-[#dbeafe] text-[#1d4ed8] flex items-center justify-center font-extrabold text-xs shrink-0 shadow-2xs">
                                        {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 2)) }}
                                    </div>
                                    <div class="hidden md:block text-left min-w-0">
                                        <span class="text-[10px] text-slate-400 font-medium leading-none block">Hello,</span>
                                        <span class="text-xs font-black text-slate-800 leading-tight block truncate max-w-[140px]">
                                            {{ auth()->user()?->name ?? 'Administrator' }}
                                        </span>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </header>

                    <!-- Main Admin Content Area -->
                    <main class="flex-1 p-4 sm:p-6 lg:p-8 w-full max-w-[1400px] mx-auto">
                        {{ $slot }}
                    </main>

                </div>

            </div>

        @else
            <!-- =========================================================================
                 PATIENT / GENERAL LAYOUT: LEFT SIDEBAR + TOP HEADER (Matching Reference)
                 ========================================================================= -->
            <div x-data="{ patientSidebarOpen: false }" class="min-h-screen bg-[#f8fafc] flex flex-col md:flex-row">
                
                <!-- Mobile Backdrop Overlay -->
                <div x-show="patientSidebarOpen" 
                     x-transition:enter="transition-opacity ease-linear duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="patientSidebarOpen = false" 
                     class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 md:hidden"
                     style="display: none;">
                </div>

                <!-- Mobile Drawer Sidebar -->
                <div x-show="patientSidebarOpen" 
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="fixed inset-y-0 left-0 w-64 max-w-[85vw] bg-white z-50 md:hidden shadow-2xl flex flex-col"
                     style="display: none;">
                    @include('layouts.navigation-patient')
                </div>

                <!-- Desktop Left Sidebar (Fixed on the side) -->
                <div class="hidden md:flex md:w-60 lg:w-64 md:flex-col md:fixed md:inset-y-0 z-40 bg-white border-r border-slate-100 shadow-[1px_0_10px_rgba(0,0,0,0.02)]">
                    @include('layouts.navigation-patient')
                </div>

                <!-- Patient Main Content Area -->
                <div class="md:pl-60 lg:pl-64 flex-1 flex flex-col min-w-0 bg-[#f8fafc]">
                    
                    <!-- Top App Header Bar (Matching Reference) -->
                    <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
                        <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
                            
                            <!-- Left: Mobile Menu Trigger + Search Bar -->
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <!-- Mobile Hamburger -->
                                <button @click="patientSidebarOpen = true" 
                                        type="button"
                                        class="md:hidden p-2 -ml-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl focus:outline-none shrink-0" 
                                        aria-label="Buka Menu">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>

                                <!-- Search Pill Input (Matching Reference) -->
                                <div class="w-full max-w-md">
                                    <div class="relative flex items-center">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" 
                                               placeholder="Cari layanan, jadwal, atau informasi..." 
                                               class="w-full pl-10 pr-4 py-2 bg-[#f1f5f9] text-xs font-medium text-slate-700 placeholder-slate-400 rounded-2xl border-0 focus:ring-2 focus:ring-emerald-500 transition-all">
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Notification Bell + User Profile Pill -->
                            <div class="flex items-center gap-3 shrink-0">
                                
                                <!-- Notification Bell with Red Dot -->
                                <button type="button" 
                                        class="relative p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-colors focus:outline-none"
                                        title="Notifikasi">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <!-- Red Dot Badge -->
                                    <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                                </button>

                                <!-- User Profile Pill (Matching Reference) -->
                                <a href="{{ route('profile') }}" class="flex items-center gap-2.5 pl-2 py-1 pr-1 hover:bg-slate-50 rounded-2xl transition-all">
                                    <div class="w-9 h-9 rounded-full bg-[#dbeafe] text-[#1d4ed8] flex items-center justify-center font-extrabold text-xs shrink-0 shadow-2xs">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="hidden sm:block text-left min-w-0">
                                        <span class="text-[10px] text-slate-400 font-medium leading-none block">Hello,</span>
                                        <span class="text-xs font-black text-slate-800 leading-tight block truncate max-w-[130px]">
                                            {{ auth()->user()?->name ?? 'Andi Pratama' }}
                                        </span>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </header>

                    <!-- Main Content Wrapper -->
                    <main class="flex-1 p-4 sm:p-6 lg:p-8 w-full max-w-[1240px] mx-auto pb-24 md:pb-10">
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
