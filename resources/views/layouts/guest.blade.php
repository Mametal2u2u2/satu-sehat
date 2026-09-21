<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Satu Sehat LPSK') }} — Portal Masuk</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Cloudflare Turnstile API -->
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50/70 text-slate-900 min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 selection:bg-emerald-500 selection:text-white">
        
        <!-- Back to Home Link -->
        <div class="w-full max-w-md mb-4 flex justify-between items-center text-xs">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 font-bold text-slate-500 hover:text-emerald-700 transition-colors py-1.5 px-3 rounded-lg hover:bg-slate-200/60">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200/70">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Portal Resmi Terproteksi
            </span>
        </div>

        <div class="flex flex-col w-full max-w-md bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/80 rounded-3xl relative p-6 sm:p-8">

            <!-- App Logo & Title -->
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-16 h-16 bg-emerald-700 rounded-2xl flex items-center justify-center shadow-md shadow-emerald-800/20 p-2.5 mb-3 border border-emerald-600 ring-4 ring-emerald-50">
                    <x-clinic-logo class="w-full h-full" />
                </div>
                <h1 class="text-xl font-black text-slate-900 tracking-tight leading-tight">Satu Sehat LPSK</h1>
                <p class="text-xs text-emerald-700 font-semibold tracking-wide mt-0.5">Sistem Informasi & Layanan Kesehatan Terpadu</p>
            </div>

            <!-- Content Area -->
            <div class="w-full">
                {{ $slot }}
            </div>
            
            <!-- Security Disclaimer -->
            <div class="mt-6 pt-4 border-t border-slate-150 flex items-center justify-center gap-2 text-[11px] text-slate-400">
                <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span>Dilindungi Enkripsi SSL & Cloudflare Turnstile</span>
            </div>
        </div>

        <!-- Footnote / copyright -->
        <p class="text-xs text-slate-400 mt-4 text-center">
            &copy; {{ date('Y') }} Lembaga Perlindungan Saksi dan Korban (LPSK RI). Seluruh Hak Cipta Dilindungi.
        </p>
    </body>
</html>
