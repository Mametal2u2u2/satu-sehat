<aside class="flex flex-col h-full bg-white border-r border-slate-200 select-none font-sans text-xs">
    <!-- Brand / Clinic Header -->
    <div class="h-14 flex items-center justify-between px-4 border-b border-slate-200 shrink-0 bg-white">
        <a href="{{ route('patient.dashboard') }}" class="flex items-center gap-2.5 min-w-0">
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0">
                <x-clinic-logo class="w-8 h-8" />
            </div>
            <div class="min-w-0">
                <span class="font-bold text-xs tracking-tight text-slate-900 block truncate">Satu Sehat LPSK</span>
                <span class="text-[10px] text-slate-400 block truncate">Portal Pasien Mandiri</span>
            </div>
        </a>

        <!-- Mobile close button -->
        <button @click="patientSidebarOpen = false" class="md:hidden p-1.5 text-slate-400 hover:text-slate-700 rounded-md focus:outline-none" aria-label="Tutup Menu">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Menu Items -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-4">
        
        <div>
            <span class="px-2 text-[10px] font-semibold tracking-wider text-slate-400 uppercase block mb-1.5">
                Menu Pasien
            </span>
            <div class="space-y-0.5">
                <!-- 1. Beranda -->
                <a href="{{ route('patient.dashboard') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('patient.dashboard') || request()->routeIs('dashboard') || request()->is('pasien*') || request()->is('patient-dashboard') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('patient.dashboard') || request()->routeIs('dashboard') || request()->is('pasien*') || request()->is('patient-dashboard') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="flex-1">Beranda Portal</span>
                </a>

                <!-- 2. Daftar Berobat -->
                <a href="{{ route('antrian.index', ['modal' => 'daftar']) }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('antrian.*') && (request('modal') === 'daftar' || request('modal') === 'tambah') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('antrian.*') && (request('modal') === 'daftar' || request('modal') === 'tambah') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="flex-1">Pendaftaran Berobat</span>
                </a>

                <!-- 3. Antrean Saya -->
                <a href="{{ route('antrian.index') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('antrian.*') && !request()->has('modal') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('antrian.*') && !request()->has('modal') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="flex-1">Status Antrean</span>
                </a>

                <!-- 4. Jadwal Dokter -->
                <a href="{{ route('jadwal.index') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('jadwal.*') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('jadwal.*') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    <span class="flex-1">Jadwal Praktik Dokter</span>
                </a>

                <!-- 5. Riwayat Rekam Medis -->
                <a href="{{ route('rekam-medis.index') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('rekam-medis.*') && request('tab') !== 'resep' ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('rekam-medis.*') && request('tab') !== 'resep' ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="flex-1">Riwayat Rekam Medis</span>
                </a>

                <!-- 6. Resep & Obat -->
                <a href="{{ route('rekam-medis.index', ['tab' => 'resep']) }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request('tab') === 'resep' ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request('tab') === 'resep' ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    <span class="flex-1">E-Resep & Obat</span>
                </a>
            </div>
        </div>

        <div class="pt-2 border-t border-slate-200"></div>

        <div>
            <span class="px-2 text-[10px] font-semibold tracking-wider text-slate-400 uppercase block mb-1.5">
                Akun Saya
            </span>
            <div class="space-y-0.5">
                <!-- Notifikasi -->
                <button type="button" 
                   @click.prevent="window.dispatchEvent(new CustomEvent('open-patient-modal', {detail: {name: 'reminder'}})); if (window.innerWidth < 768) patientSidebarOpen = false;"
                   class="w-full flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium cursor-pointer text-left">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="flex-1">Pengingat & Notifikasi</span>
                </button>

                <!-- Profil Pasien -->
                <a href="{{ route('profile') }}" 
                   class="flex items-center gap-2.5 px-2.5 py-2 rounded-md transition-colors {{ request()->routeIs('profile') ? 'bg-teal-50 text-teal-900 font-semibold border-l-2 border-teal-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-medium' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('profile') ? 'text-teal-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="flex-1">Pengaturan Profil</span>
                </a>
            </div>
        </div>

    </div>

    <!-- User Profile Footer with Role Tag & Logout -->
    <div class="p-3 border-t border-slate-200 bg-slate-50 shrink-0">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 min-w-0">
                <div class="w-7 h-7 rounded-full bg-teal-100 text-teal-800 font-bold flex items-center justify-center text-xs shrink-0">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'P', 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-slate-800 truncate">
                        {{ auth()->user()?->name ?? 'Pasien' }}
                    </p>
                    <p class="text-[10px] text-slate-500 truncate">
                        Pasien Terdaftar
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
