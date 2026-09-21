<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="description" content="Satu Sehat LPSK — Sistem Informasi & Layanan Klinik Pratama Terpadu Lembaga Perlindungan Saksi dan Korban Republik Indonesia. Terkoneksi platform SatuSehat Kemenkes RI.">
    <meta name="theme-color" content="#047857">
    
    <title>Satu Sehat LPSK — Klinik Pratama Terpadu & Portal Layanan Kesehatan</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-slate-50 text-slate-900 antialiased selection:bg-emerald-600 selection:text-white flex flex-col min-h-screen">

    <!-- =========================================================================
         1. TOP INSTITUTIONAL BAR
         ========================================================================= -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 sm:px-8 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-3 text-[11px] sm:text-xs">
                <span class="flex items-center gap-1.5 font-bold text-white">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Klinik Beroperasi Normal
                </span>
                <span class="hidden md:inline text-slate-500">|</span>
                <span class="hidden md:inline text-slate-400">Jam Layanan: 08:00 - 21:00 WIB</span>
                <span class="hidden md:inline text-slate-500">|</span>
                <span class="text-emerald-400 font-semibold">Terkoneksi SatuSehat Kemenkes RI</span>
            </div>
            <div class="flex items-center gap-4 text-[11px] sm:text-xs">
                <a href="tel:119" class="text-slate-300 hover:text-white flex items-center gap-1 font-semibold transition-colors">
                    <svg class="w-3.5 h-3.5 text-rose-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z"/>
                    </svg>
                    <span>Layanan Darurat: <strong>119</strong> / <strong>(021) 2929-LPSK</strong></span>
                </a>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         2. MAIN NAVIGATION NAVBAR
         ========================================================================= -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand & Official Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3.5 group">
                    <div class="w-12 h-12 bg-emerald-700 rounded-2xl flex items-center justify-center p-2 shadow-sm shadow-emerald-800/20 group-hover:scale-105 transition-transform">
                        <x-clinic-logo class="w-full h-full" />
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-black text-lg text-slate-900 tracking-tight leading-none group-hover:text-emerald-700 transition-colors">Satu Sehat LPSK</span>
                            <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 border border-emerald-200">Resmi</span>
                        </div>
                        <p class="text-xs text-slate-500 font-semibold tracking-wide mt-1">Klinik Pratama Terpadu LPSK RI</p>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold text-slate-600">
                    <a href="#tentang" class="hover:text-emerald-700 transition-colors py-1">Tentang Klinik</a>
                    <a href="#layanan" class="hover:text-emerald-700 transition-colors py-1">Layanan Medis</a>
                    <a href="#poliklinik" class="hover:text-emerald-700 transition-colors py-1">Poliklinik & Jadwal</a>
                    <a href="#alur" class="hover:text-emerald-700 transition-colors py-1">Alur Berobat</a>
                    <a href="#keamanan" class="hover:text-emerald-700 transition-colors py-1">Privasi & Standar</a>
                    <a href="#kontak" class="hover:text-emerald-700 transition-colors py-1">Kontak</a>
                </nav>

                <!-- Action CTA: Explicit Login Pasien button -->
                <div class="flex items-center gap-3">
                    @auth
                        <!-- If already logged in, show Patient Portal Button -->
                        <a href="{{ route('patient.dashboard') }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 active:scale-[0.98] text-white font-extrabold text-xs sm:text-sm rounded-xl shadow-md shadow-emerald-700/20 transition-all cursor-pointer"
                           id="btn-nav-portal-pasien">
                            <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Portal Pasien</span>
                        </a>
                    @else
                        <!-- Explicit LOGIN PASIEN Button for Guests -->
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 active:scale-[0.98] text-white font-extrabold text-xs sm:text-sm rounded-xl shadow-md shadow-emerald-700/20 transition-all cursor-pointer ring-2 ring-emerald-700/20"
                           id="btn-nav-login"
                           title="Masuk ke Portal Pasien Satu Sehat LPSK">
                            <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Login Pasien</span>
                        </a>

                        <a href="{{ route('register') }}" 
                           class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2.5 border border-slate-300 hover:border-emerald-600 hover:text-emerald-700 text-slate-700 font-bold text-xs sm:text-sm rounded-xl hover:bg-emerald-50/40 transition-all">
                            <span>Pendaftaran Pasien</span>
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    <!-- =========================================================================
         3. HERO SECTION (INSTITUTIONAL & CLINICAL)
         ========================================================================= -->
    <section class="relative bg-gradient-to-b from-white via-slate-50 to-emerald-50/40 pt-10 pb-16 lg:pt-16 lg:pb-24 overflow-hidden border-b border-slate-200/60">
        <!-- Subtle Institutional Background Pattern -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none bg-[radial-gradient(#059669_1px,transparent_1px)] [background-size:20px_20px]"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                
                <!-- Left Column: Headline, Description & CTAs -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- Official Agency Pill -->
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100/80 border border-emerald-200 text-emerald-900 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        Lembaga Perlindungan Saksi dan Korban Republik Indonesia
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-[1.15]">
                        Pelayanan Kesehatan Terpadu, Aman, & Terstandarisasi <span class="text-emerald-700">SatuSehat</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-normal max-w-2xl">
                        Akses layanan poliklinik klinis terakreditasi, pantau nomor antrian secara real-time, dan kelola rekam medis elektronik resmi dengan jaminan privasi serta perlindungan standar negara.
                    </p>

                    <!-- Main Action Group -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                        @auth
                            <a href="{{ route('patient.dashboard') }}" 
                               class="flex items-center justify-center gap-2.5 px-6 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-sm rounded-2xl shadow-lg shadow-emerald-700/25 transition-all"
                               id="hero-btn-portal-pasien">
                                <span>Akses Portal Pasien Saya</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="flex items-center justify-center gap-2.5 px-7 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-base rounded-2xl shadow-lg shadow-emerald-700/25 hover:shadow-emerald-700/35 transition-all cursor-pointer"
                               id="hero-btn-login">
                                <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                <span>Login Pasien</span>
                            </a>
                            
                            <a href="{{ route('register') }}" 
                               class="flex items-center justify-center gap-2 px-6 py-4 bg-white border-2 border-slate-300 hover:border-emerald-600 hover:text-emerald-700 text-slate-800 font-extrabold text-base rounded-2xl shadow-xs hover:bg-emerald-50/50 transition-all"
                               id="hero-btn-register">
                                <span>Pendaftaran Pasien Baru</span>
                            </a>
                        @endauth

                        <a href="#poliklinik" class="flex items-center justify-center gap-1.5 px-5 py-4 text-slate-600 hover:text-emerald-700 font-bold text-sm transition-colors">
                            <span>Jadwal Dokter Hari Ini</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                    </div>

                    <!-- Trust Badges Row -->
                    <div class="pt-4 border-t border-slate-200/80 flex flex-wrap items-center gap-6 text-xs text-slate-500 font-semibold">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Rekam Medis HL7 FHIR Kemenkes</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Proteksi Bot Cloudflare Turnstile</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Kerahasiaan Medis Terjamin</span>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Status Layanan & Poliklinik Publik -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-[0_12px_36px_rgba(0,0,0,0.06)] relative overflow-hidden">
                        <div class="flex items-center justify-between border-b border-slate-150 pb-4 mb-5">
                            <div>
                                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block">Informasi Layanan Publik</span>
                                <h3 class="text-lg font-black text-slate-900">Operasional Poliklinik Hari Ini</h3>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                Buka Normal
                            </span>
                        </div>

                        <!-- Poliklinik Public Status List -->
                        <div class="space-y-3">
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-sm">
                                        PU
                                    </div>
                                    <div>
                                        <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">Poli Umum</h4>
                                        <p class="text-[11px] text-slate-500 font-medium">dr. Rina Kusuma • Jam 08:00 - 21:00</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[11px] font-bold text-emerald-700 bg-emerald-100/70 px-2.5 py-1 rounded-lg">Melayani</span>
                                </div>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black text-sm">
                                        PG
                                    </div>
                                    <div>
                                        <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">Poli Gigi & Mulut</h4>
                                        <p class="text-[11px] text-slate-500 font-medium">drg. Hendra P. • Jam 09:00 - 17:00</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[11px] font-bold text-blue-700 bg-blue-100/70 px-2.5 py-1 rounded-lg">Melayani</span>
                                </div>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center font-black text-sm">
                                        PA
                                    </div>
                                    <div>
                                        <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">Poli Anak (Pediatri)</h4>
                                        <p class="text-[11px] text-slate-500 font-medium">dr. Sari Dewi, Sp.A • Jam 13:00 - 18:00</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[11px] font-bold text-purple-700 bg-purple-100/70 px-2.5 py-1 rounded-lg">Buka 13:00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Direct Patient CTA Banner -->
                        <div class="mt-5 pt-4 border-t border-slate-150">
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl p-4 border border-emerald-200/80 flex items-center justify-between gap-3">
                                <div>
                                    <span class="text-xs font-extrabold text-emerald-950 block">Ambil Tiket & Antrian Online</span>
                                    <span class="text-[11px] text-emerald-700">Masuk ke Portal Pasien untuk registrasi</span>
                                </div>
                                <a href="{{ route('login') }}" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-xs shrink-0 transition-colors">
                                    Login Pasien &rarr;
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================================
         TENTANG KLINIK PRATAMA TERPADU LPSK
         ========================================================================= -->
    <section id="tentang" class="py-16 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-7 space-y-4">
                    <span class="text-xs font-black text-emerald-700 uppercase tracking-wider bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        Profil & Komitmen Pelayanan
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-snug">
                        Fasilitas Pelayanan Kesehatan Terpadu Resmi LPSK RI
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Klinik Pratama Terpadu Lembaga Perlindungan Saksi dan Korban (LPSK RI) menyelenggarakan pelayanan kesehatan rawat jalan tingkat pertama yang komprehensif, humanis, dan akuntabel bagi saksi, korban tindak pidana, keluarga terlindung, pegawai, serta masyarakat umum.
                    </p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Dengan sistem terintegrasi platform <strong>SatuSehat Kementerian Kesehatan Republik Indonesia</strong>, seluruh riwayat pemeriksaan medis tercatat secara aman, terstandarisasi, dan mudah diakses oleh pasien melalui portal web resmi.
                    </p>

                    <!-- 3 Benefit Pillars -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 pt-2">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                            <span class="text-2xl font-black text-emerald-700 block">100%</span>
                            <span class="text-xs font-bold text-slate-900 mt-1 block">Terkoneksi SatuSehat</span>
                            <span class="text-[11px] text-slate-500">Standar HL7 FHIR Kemenkes</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                            <span class="text-2xl font-black text-emerald-700 block">&lt; 15 Mnt</span>
                            <span class="text-xs font-bold text-slate-900 mt-1 block">Waktu Tunggu Cepat</span>
                            <span class="text-[11px] text-slate-500">Antrian digital online</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                            <span class="text-2xl font-black text-emerald-700 block">24 Jam</span>
                            <span class="text-xs font-bold text-slate-900 mt-1 block">Siaga Farmasi</span>
                            <span class="text-[11px] text-slate-500">Ambulans darurat standby</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="relative rounded-3xl overflow-hidden border border-slate-200 shadow-md">
                        <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=800&q=80" 
                             alt="Gedung Klinik LPSK" 
                             class="w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-900/30 to-transparent p-6 flex flex-col justify-end text-white">
                            <span class="text-[11px] font-bold text-emerald-300 uppercase tracking-wider">Graha LPSK Jakarta Timur</span>
                            <h4 class="text-base font-black text-white mt-1">Pelayanan Kesehatan Berkeadilan</h4>
                            <p class="text-[11px] text-slate-300 mt-1">Komitmen profesional dalam memberikan perlindungan fisik dan pemulihan kesehatan prima.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         4. LAYANAN MEDIS UNGGULAN
         ========================================================================= -->
    <section id="layanan" class="py-16 bg-slate-50 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-black text-emerald-700 uppercase tracking-wider bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    Pelayanan Medis Terintegrasi
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-3">
                    Fasilitas Klinis Lengkap Berstandar Nasional
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    Memberikan kepastian perlindungan kesehatan, pemeriksaan dokter spesialis, serta distribusi obat digital yang akuntabel.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 hover:border-emerald-300 hover:shadow-md transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xl mb-4">
                        🩺
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-2">Konsultasi Dokter & Spesialis</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pemeriksaan klinis komprehensif oleh dokter umum bersertifikasi dan dokter spesialis berjadwal tetap di klinik pratama.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 hover:border-emerald-300 hover:shadow-md transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-800 flex items-center justify-center font-bold text-xl mb-4">
                        🛡️
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-2">Perlindungan Medis LPSK</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Layanan penanganan medis khusus, visum et repertum berkolaborasi dengan faskes rujukan, dan pemulihan trauma terpadu.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 hover:border-emerald-300 hover:shadow-md transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-xl mb-4">
                        💊
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-2">Farmasi & E-Resep Digital</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pengambilan obat otomatis langsung dari ruang dokter ke unit farmasi. Validasi stok real-time tanpa resiko salah obat.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 hover:border-emerald-300 hover:shadow-md transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-800 flex items-center justify-center font-bold text-xl mb-4">
                        🚑
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-2">Ambulans Siaga 24 Jam</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Armada ambulans medis gawat darurat yang siap mobilisasi dan evakuasi rujukan ke rumah sakit vertikal kapan saja.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         5. POLIKLINIK & JADWAL DOKTER STANDBY
         ========================================================================= -->
    <section id="poliklinik" class="py-16 bg-slate-50 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="text-xs font-black text-emerald-700 uppercase tracking-wider bg-emerald-100/70 px-3 py-1 rounded-full border border-emerald-200">
                        Poliklinik Aktif
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-3">
                        Jadwal Dokter & Unit Pelayanan Hari Ini
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">
                        Pilih poliklinik tujuan dan pastikan Anda telah mendaftar antrian secara online.
                    </p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl transition-colors shadow-xs">
                        <span>Ambil Antrian Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Poli 1 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-[11px] font-black uppercase">Poli Umum</span>
                            <span class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Buka
                            </span>
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-base">Pemeriksaan Umum & Rujukan</h4>
                        <p class="text-xs text-slate-500 mt-1">Lantai 1 • Ruang 101</p>
                        
                        <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-400">Dokter Jaga:</span>
                                <span class="font-bold text-slate-800">dr. Rina Kusuma</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Jam Layanan:</span>
                                <span class="font-bold text-slate-800">08:00 - 21:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Sisa Kuota:</span>
                                <span class="font-bold text-emerald-700">12 Pasien</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Poli 2 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-2.5 py-1 rounded-lg bg-blue-100 text-blue-800 text-[11px] font-black uppercase">Poli Gigi</span>
                            <span class="text-xs font-bold text-blue-600 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span> Buka
                            </span>
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-base">Kesehatan Gigi & Mulut</h4>
                        <p class="text-xs text-slate-500 mt-1">Lantai 1 • Ruang 103</p>
                        
                        <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-400">Dokter Jaga:</span>
                                <span class="font-bold text-slate-800">drg. Hendra P.</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Jam Layanan:</span>
                                <span class="font-bold text-slate-800">09:00 - 17:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Sisa Kuota:</span>
                                <span class="font-bold text-blue-700">6 Pasien</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Poli 3 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-2.5 py-1 rounded-lg bg-purple-100 text-purple-800 text-[11px] font-black uppercase">Poli Anak</span>
                            <span class="text-xs font-bold text-purple-600 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-purple-500"></span> Buka
                            </span>
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-base">Pediatri & Tumbuh Kembang</h4>
                        <p class="text-xs text-slate-500 mt-1">Lantai 2 • Ruang 201</p>
                        
                        <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-400">Dokter Spesialis:</span>
                                <span class="font-bold text-slate-800">dr. Sari Dewi, Sp.A</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Jam Layanan:</span>
                                <span class="font-bold text-slate-800">13:00 - 18:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Sisa Kuota:</span>
                                <span class="font-bold text-purple-700">4 Pasien</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Poli 4 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-2.5 py-1 rounded-lg bg-amber-100 text-amber-800 text-[11px] font-black uppercase">Unit Farmasi</span>
                            <span class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> 24 Jam
                            </span>
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-base">Dispensing Obat Digital</h4>
                        <p class="text-xs text-slate-500 mt-1">Lobby Utama • Lantai 1</p>
                        
                        <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-400">Apoteker Jaga:</span>
                                <span class="font-bold text-slate-800">Apt. Farhan, S.Farm</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Jam Operasional:</span>
                                <span class="font-bold text-emerald-700">24 Jam Non-Stop</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Kecepatan Resep:</span>
                                <span class="font-bold text-slate-800">&lt; 7 Menit</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         6. ALUR PELAYANAN PASIEN (4 LANGKAH JELAS)
         ========================================================================= -->
    <section id="alur" class="py-16 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-black text-emerald-700 uppercase tracking-wider bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    Alur Mudah & Transparan
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-3">
                    Tata Cara Kunjungan & Berobat di Klinik
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    Sistem digital kami memangkas waktu tunggu sehingga Anda tidak perlu antri berdesakan di loket fisik.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
                <!-- Step 1 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 relative">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-sm mb-4">
                        01
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-1.5">Masuk / Daftar Akun</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Masuk menggunakan username atau email Anda melalui portal web yang terproteksi Cloudflare Turnstile.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 relative">
                    <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-black text-sm mb-4">
                        02
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-1.5">Ambil Antrian Online</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pilih poliklinik dan dokter tujuan. Dapatkan nomor tiket antrian digital dan estimasi waktu panggilan.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 relative">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-sm mb-4">
                        03
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-1.5">Pemeriksaan Dokter</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pemeriksaan tanda vital, konsultasi medis, dan pencatatan riwayat klinis langsung ke rekam medis elektronik.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/90 relative">
                    <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-black text-sm mb-4">
                        04
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-1.5">Ambil Resep Digital</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        E-resep otomatis terkirim ke loket farmasi. Ambil obat dengan memindai kode tiket tanpa resep kertas manual.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         7. STANDAR PRIVASI & KEAMANAN SISTEM
         ========================================================================= -->
    <section id="keamanan" class="py-16 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7 space-y-4">
                    <span class="text-xs font-black text-emerald-400 uppercase tracking-wider bg-white/10 px-3 py-1 rounded-full border border-white/15">
                        Integritas & Privasi Pasien
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Kerahasiaan Medis Pasien Terlindungi Regulasi Negara
                    </h2>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        Seluruh data rekam medis, identitas saksi, korban, dan pegawai dikelola sesuai amanat UU Perlindungan Saksi dan Korban serta Peraturan Menteri Kesehatan tentang Rekam Medis Elektronik (RME).
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 text-xs">
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 flex items-start gap-2.5">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span>Enkripsi Database & Koneksi Aman SSL 256-bit</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 flex items-start gap-2.5">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span>Proteksi Turnstile Anti-Bruteforce & Bot</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 flex items-start gap-2.5">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span>Audit Trail Akses Data Medis Pasien</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 flex items-start gap-2.5">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span>Pemisahan Hak Akses Staf vs Pasien</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 bg-white/10 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/15 text-center">
                    <div class="w-16 h-16 bg-emerald-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg text-2xl">
                        🔒
                    </div>
                    <h3 class="text-lg font-black text-white">Akses Portal Pasien</h3>
                    <p class="text-xs text-slate-300 mt-2 mb-6">
                        Masuk ke portal akun Anda sekarang untuk mengakses rekam medis atau melakukan pendaftaran poliklinik online.
                    </p>
                    <div class="space-y-2.5">
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-black text-sm rounded-xl transition-all shadow-md">
                            <span>Login Pasien</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ route('register') }}" class="w-full flex items-center justify-center py-3 px-4 bg-white/10 hover:bg-white/20 text-white font-bold text-xs rounded-xl transition-colors border border-white/20">
                            Pendaftaran Pasien Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         8. INSTITUTIONAL FOOTER
         ========================================================================= -->
    <footer id="kontak" class="bg-slate-950 text-slate-400 text-xs pt-12 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 pb-10 border-b border-slate-800">
                
                <!-- Col 1: Identity -->
                <div class="lg:col-span-2 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-700 rounded-xl flex items-center justify-center p-1.5 shadow-xs">
                            <x-clinic-logo class="w-full h-full" />
                        </div>
                        <div>
                            <span class="font-extrabold text-white text-sm block">Satu Sehat LPSK</span>
                            <span class="text-[10px] text-emerald-400 font-semibold uppercase">Klinik Pratama Terpadu</span>
                        </div>
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-sm">
                        Lembaga Perlindungan Saksi dan Korban (LPSK RI) berdedikasi memberikan pemenuhan hak bantuan medis, psikologis, dan psikososial secara profesional, humanis, dan akuntabel.
                    </p>
                    <p class="text-[11px] text-slate-500">
                        Graha LPSK: Jl. Raya Bogor KM. 24 No. 47-49, Susukan, Ciracas, Jakarta Timur 13750.
                    </p>
                </div>

                <!-- Col 2: Navigasi Portal Pasien -->
                <div>
                    <h4 class="font-black text-white text-xs uppercase tracking-wider mb-3">Portal Pasien</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition-colors font-semibold">Login Pasien</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-emerald-400 transition-colors">Pendaftaran Akun Pasien</a></li>
                        <li><a href="{{ route('patient.dashboard') }}" class="hover:text-emerald-400 transition-colors">Portal Pasien</a></li>
                        <li><a href="#poliklinik" class="hover:text-emerald-400 transition-colors">Jadwal Poliklinik</a></li>
                        <li><a href="#alur" class="hover:text-emerald-400 transition-colors">Alur Pelayanan Berobat</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan Medis -->
                <div>
                    <h4 class="font-black text-white text-xs uppercase tracking-wider mb-3">Unit Pelayanan</h4>
                    <ul class="space-y-2">
                        <li><a href="#poliklinik" class="hover:text-emerald-400 transition-colors">Poli Umum</a></li>
                        <li><a href="#poliklinik" class="hover:text-emerald-400 transition-colors">Poli Gigi & Mulut</a></li>
                        <li><a href="#poliklinik" class="hover:text-emerald-400 transition-colors">Poli Anak (Pediatri)</a></li>
                        <li><a href="#poliklinik" class="hover:text-emerald-400 transition-colors">Unit Farmasi & Apotek</a></li>
                        <li><a href="#layanan" class="hover:text-emerald-400 transition-colors">Ambulans Darurat 24 Jam</a></li>
                    </ul>
                </div>

                <!-- Col 4: Kontak Darurat -->
                <div>
                    <h4 class="font-black text-white text-xs uppercase tracking-wider mb-3">Bantuan & Hotline</h4>
                    <ul class="space-y-2">
                        <li><span class="text-slate-500">Call Center LPSK:</span> <strong class="text-white block">148</strong></li>
                        <li><span class="text-slate-500">Hotline Klinik Darurat:</span> <strong class="text-emerald-400 block">(021) 2929-LPSK</strong></li>
                        <li><span class="text-slate-500">Email Bantuan:</span> <strong class="text-white block">klinik@lpsk.go.id</strong></li>
                        <li><span class="text-slate-500">WhatsApp Pelayanan:</span> <strong class="text-white block">0857-7001-0148</strong></li>
                    </ul>
                </div>

            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-500">
                <p>&copy; {{ date('Y') }} Lembaga Perlindungan Saksi dan Korban (LPSK RI). Seluruh Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center gap-4">
                    <span>Standar Pelayanan Medis Terakreditasi</span>
                    <span>•</span>
                    <span>Kemenkes RI SatuSehat FHIR</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
