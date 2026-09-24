<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Satu Sehat LPSK') }} — Portal Login Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Cloudflare Turnstile API -->
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 min-h-screen flex flex-col justify-between relative selection:bg-blue-600 selection:text-white bg-[#f4f6fa]">
        
        <!-- Scaled Justice (Timbangan Keadilan) Repeating Watermark Pattern Background -->
        <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden opacity-90">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="scalesOfJustice" width="130" height="130" patternUnits="userSpaceOnUse">
                        <g stroke="#94a3b8" stroke-width="1.8" fill="none" opacity="0.18">
                            <!-- Center Column & Finial -->
                            <circle cx="65" cy="18" r="3.2" fill="#94a3b8" />
                            <line x1="65" y1="21" x2="65" y2="82" stroke-linecap="round" />
                            <!-- Base Pedestal -->
                            <path d="M52 82 H78" stroke-linecap="round" stroke-width="2" />
                            <path d="M46 87 H84" stroke-linecap="round" stroke-width="2.6" />
                            <!-- Crossbeam -->
                            <line x1="32" y1="27" x2="98" y2="27" stroke-linecap="round" stroke-width="2.6" />
                            <circle cx="65" cy="27" r="2.5" fill="#94a3b8" />
                            <!-- Left Scale Pan & Strings -->
                            <line x1="32" y1="27" x2="20" y2="56" />
                            <line x1="32" y1="27" x2="44" y2="56" />
                            <path d="M16 56 Q32 66 48 56 Z" fill="#94a3b8" fill-opacity="0.12" stroke-linecap="round" />
                            <!-- Right Scale Pan & Strings -->
                            <line x1="98" y1="27" x2="86" y2="56" />
                            <line x1="98" y1="27" x2="110" y2="56" />
                            <path d="M82 56 Q98 66 114 56 Z" fill="#94a3b8" fill-opacity="0.12" stroke-linecap="round" />
                        </g>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#scalesOfJustice)" />
            </svg>
        </div>

        <!-- Top Navigation Header -->
        <header class="w-full relative z-10 p-4 sm:px-8 flex justify-between items-center max-w-7xl mx-auto">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-900 transition-colors py-1.5 px-3 rounded-lg hover:bg-white/80">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-blue-900 bg-blue-50/90 border border-blue-200/80 px-3 py-1 rounded-full shadow-2xs backdrop-blur-xs">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Portal Resmi Admin & Staf Medis
                </span>
            </div>
        </header>

        <!-- Main Card Content -->
        <main class="w-full flex items-center justify-center px-4 py-6 sm:py-10 relative z-10">
            {{ $slot }}
        </main>

        <!-- Official Institutional Footer -->
        <footer class="w-full relative z-10 py-4 text-center border-t border-slate-200/60 bg-white/40 backdrop-blur-xs text-xs text-slate-500">
            <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p>&copy; {{ date('Y') }} Lembaga Perlindungan Saksi dan Korban (LPSK RI). Seluruh Hak Cipta Dilindungi.</p>
                <p class="text-[11px] text-slate-400">Pusat Layanan Kesehatan Satu Sehat Terpadu LPSK</p>
            </div>
        </footer>
    </body>
</html>
