<aside class="flex flex-col h-full bg-white border-r border-slate-100 select-none">
    <!-- Brand / Clinic Header -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100 shrink-0">
        <a href="{{ route('patient.dashboard') }}" class="flex items-center gap-3 min-w-0">
            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0">
                <x-clinic-logo class="w-10 h-10" />
            </div>
            <div class="min-w-0">
                <span class="font-extrabold text-sm tracking-tight text-slate-900 block truncate">Satu Sehat LPSK</span>
                <span class="text-[11px] text-slate-400 font-medium block truncate">Melayani dengan Hati</span>
            </div>
        </a>

        <!-- Mobile close button -->
        <button @click="patientSidebarOpen = false" class="md:hidden p-2 -mr-2 text-slate-400 hover:text-slate-700 rounded-lg focus:outline-none" aria-label="Tutup Menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Menu Items -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5">
        
        <!-- 1. Beranda -->
        <a href="{{ route('patient.dashboard') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs font-extrabold transition-all {{ request()->routeIs('patient.dashboard') || request()->routeIs('dashboard') || request()->is('patient-dashboard') ? 'bg-[#e6f4ea] text-[#137333] shadow-xs' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('patient.dashboard') || request()->routeIs('dashboard') || request()->is('patient-dashboard') ? 'text-[#137333] fill-current' : 'text-slate-400' }}" viewBox="0 0 24 24" fill="{{ request()->routeIs('patient.dashboard') || request()->routeIs('dashboard') || request()->is('patient-dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ request()->routeIs('patient.dashboard') || request()->routeIs('dashboard') || request()->is('patient-dashboard') ? '0' : '2' }}">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            <span class="flex-1">Beranda</span>
        </a>

        <!-- 2. Antrian -->
        <a href="{{ route('antrian.index') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs font-extrabold transition-all {{ request()->routeIs('antrian.*') ? 'bg-[#e6f4ea] text-[#137333] shadow-xs' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('antrian.*') ? 'text-[#137333]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="flex-1">Antrian</span>
        </a>

        <!-- 3. Jadwal -->
        <a href="{{ route('jadwal.index') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs font-extrabold transition-all {{ request()->routeIs('jadwal.*') ? 'bg-[#e6f4ea] text-[#137333] shadow-xs' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('jadwal.*') ? 'text-[#137333]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
            <span class="flex-1">Jadwal</span>
        </a>

        <!-- 4. Akun / Profil -->
        <a href="{{ route('profile') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs font-extrabold transition-all {{ request()->routeIs('profile') ? 'bg-[#e6f4ea] text-[#137333] shadow-xs' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('profile') ? 'text-[#137333]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="flex-1">Akun</span>
        </a>

        <div class="pt-3 pb-1 border-t border-slate-100 my-2"></div>

        <!-- 5. Rekam Medis Pasien -->
        <a href="{{ route('rekam-medis.index') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs font-extrabold transition-all {{ request()->routeIs('rekam-medis.*') ? 'bg-[#e6f4ea] text-[#137333] shadow-xs' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('rekam-medis.*') ? 'text-[#137333]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="flex-1">Rekam Medis</span>
        </a>

        <!-- 6. Panduan Sistem -->
        <a href="{{ route('panduan') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs font-extrabold transition-all {{ request()->routeIs('panduan*') ? 'bg-[#e6f4ea] text-[#137333] shadow-xs' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('panduan*') ? 'text-[#137333]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span class="flex-1">Panduan</span>
        </a>

    </div>

    <!-- User Profile Footer & Logout -->
    <div class="p-4 border-t border-slate-100 bg-slate-50/50 shrink-0">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-full bg-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs shrink-0">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'P', 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-extrabold text-slate-800 truncate">
                        {{ auth()->user()?->name ?? 'Pasien' }}
                    </p>
                    <span class="inline-block text-[10px] text-slate-400 truncate">
                        {{ auth()->user()?->email ?? 'pasien@eklinik.com' }}
                    </span>
                </div>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        title="Keluar" 
                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
