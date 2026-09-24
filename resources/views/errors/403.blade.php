<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | Satu Sehat LPSK</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 selection:bg-rose-600 selection:text-white relative">

    <!-- Scaled Justice Pattern Background Watermark -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden opacity-60">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="scalesError" width="130" height="130" patternUnits="userSpaceOnUse">
                    <g stroke="#94a3b8" stroke-width="1.8" fill="none" opacity="0.14">
                        <circle cx="65" cy="18" r="3" fill="#94a3b8" />
                        <line x1="65" y1="21" x2="65" y2="82" stroke-linecap="round" />
                        <path d="M52 82 H78" stroke-linecap="round" stroke-width="2" />
                        <path d="M46 87 H84" stroke-linecap="round" stroke-width="2.6" />
                        <line x1="32" y1="27" x2="98" y2="27" stroke-linecap="round" stroke-width="2.6" />
                        <line x1="32" y1="27" x2="20" y2="56" />
                        <line x1="32" y1="27" x2="44" y2="56" />
                        <path d="M16 56 Q32 66 48 56 Z" fill="#94a3b8" fill-opacity="0.1" stroke-linecap="round" />
                        <line x1="98" y1="27" x2="86" y2="56" />
                        <line x1="98" y1="27" x2="110" y2="56" />
                        <path d="M82 56 Q98 66 114 56 Z" fill="#94a3b8" fill-opacity="0.1" stroke-linecap="round" />
                    </g>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#scalesError)" />
        </svg>
    </div>

    <!-- Center Card -->
    <div class="w-full max-w-lg bg-white rounded-3xl border border-slate-200/90 shadow-[0_12px_45px_rgba(0,0,0,0.06)] p-7 sm:p-10 text-center relative z-10">
        
        <!-- Red Shield Icon -->
        <div class="w-20 h-20 rounded-2xl bg-rose-50 border border-rose-100 mx-auto flex items-center justify-center text-rose-600 mb-5 shadow-xs">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-rose-100/70 text-rose-700 uppercase tracking-wider mb-2">
            HTTP 403 • Akses Ditolak
        </span>

        <h1 class="text-2xl font-black text-slate-800 tracking-tight mb-2">
            Anda Tidak Memiliki Hak Akses
        </h1>

        <p class="text-xs text-slate-500 leading-relaxed max-w-md mx-auto mb-6">
            {{ $exception->getMessage() ?: 'Halaman atau fitur ini dilindungi oleh sistem keamanan berbasis role dan permission. Akun Anda tidak memiliki izin untuk mengakses rute ini.' }}
        </p>

        <!-- Current User Badge -->
        @auth
        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 mb-6 text-left flex items-center justify-between">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-9 h-9 rounded-full bg-slate-200 text-slate-700 font-extrabold flex items-center justify-center text-xs shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-slate-400 font-mono truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-200/80 text-slate-700 shrink-0">
                Role: {{ auth()->user()->roles->first()?->name ?? 'Pengguna' }}
            </span>
        </div>
        @endauth

        <!-- Navigation Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <button onclick="window.history.back()" 
                    class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors cursor-pointer">
                &larr; Kembali Sebelumnya
            </button>
            
            <a href="{{ route('dashboard') }}" 
               class="w-full sm:w-auto px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl transition-all shadow-md shadow-emerald-800/15">
                Dashboard Utama &rarr;
            </a>
        </div>
    </div>

    <!-- Official Copyright -->
    <p class="text-xs text-slate-400 mt-6 text-center relative z-10">
        &copy; {{ date('Y') }} Lembaga Perlindungan Saksi dan Korban (LPSK RI). Sistem Keamanan Role-Based Access Control.
    </p>
</body>
</html>
