<x-app-layout>
    <div x-data="patientDashboard()" class="space-y-6 max-w-5xl mx-auto">

        <!-- ====================================================================
             1. WELCOME BANNER (Matching Reference Image)
             ==================================================================== -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-150 shadow-[0_2px_12px_rgba(0,0,0,0.02)] flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
            <div class="flex-1 min-w-0 z-10">
                <span class="text-sm font-semibold text-slate-500 block">Selamat Datang,</span>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-0.5">
                    {{ auth()->user()?->name ?? 'Andi Pratama' }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-2 max-w-md leading-relaxed">
                    Pantau antrian, jadwal, dan layanan klinik dalam genggaman Anda.
                </p>
            </div>
            
            <!-- LPSK Building Photo with Exterior Logo -->
            <div class="shrink-0 w-full md:w-72 lg:w-80 h-36 rounded-2xl overflow-hidden shadow-xs border border-slate-150 bg-slate-100 relative group">
                <img src="{{ asset('images/gedung-lpsk.jpg') }}" 
                     alt="Gedung Lembaga Perlindungan Saksi dan Korban (LPSK)" 
                     class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/20 via-transparent to-transparent pointer-events-none"></div>
            </div>
        </div>

        <!-- ====================================================================
             2. GRID 4 QUICK ACTION CARDS (Matching Reference Image)
             ==================================================================== -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- 1. Cek Antrian -->
            <a href="{{ route('antrian.index') }}" 
               class="bg-white rounded-2xl p-5 sm:p-6 border-2 border-[#f59e0b]/50 hover:border-[#f59e0b] hover:shadow-md transition-all flex flex-col items-center justify-center text-center cursor-pointer group shadow-2xs">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center p-1 mb-1 group-hover:scale-105 transition-transform">
                    <!-- Clean illustration of queue / patients -->
                    <svg class="w-12 h-12" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="23" cy="22" r="10" fill="#F97316"/>
                        <path d="M7 52C7 41.5066 14.1634 33 23 33C31.8366 33 39 41.5066 39 52H7Z" fill="#EA580C"/>
                        <circle cx="43" cy="25" r="9" fill="#0D9488"/>
                        <path d="M29 52C29 42.6112 35.268 35 43 35C50.732 35 57 42.6112 57 52H29Z" fill="#0F766E"/>
                    </svg>
                </div>
                <span class="text-xs sm:text-sm font-extrabold text-slate-800 group-hover:text-amber-700 transition-colors">
                    Cek Antrian
                </span>
            </a>

            <!-- 2. Jadwal Dokter -->
            <a href="{{ route('jadwal.index') }}" 
               class="bg-white rounded-2xl p-5 sm:p-6 border-2 border-[#10b981]/50 hover:border-[#10b981] hover:shadow-md transition-all flex flex-col items-center justify-center text-center cursor-pointer group shadow-2xs">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center p-1 mb-1 group-hover:scale-105 transition-transform">
                    <!-- Clean illustration of calendar with clock -->
                    <svg class="w-12 h-12" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="8" y="14" width="36" height="36" rx="8" fill="#10B981"/>
                        <rect x="8" y="14" width="36" height="12" rx="8" fill="#059669"/>
                        <rect x="14" y="8" width="4" height="10" rx="2" fill="#047857"/>
                        <rect x="34" y="8" width="4" height="10" rx="2" fill="#047857"/>
                        <circle cx="41" cy="41" r="13" fill="#0284C7" stroke="#ffffff" stroke-width="3"/>
                        <path d="M41 33V41L46 44" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="text-xs sm:text-sm font-extrabold text-slate-800 group-hover:text-emerald-700 transition-colors">
                    Jadwal Dokter
                </span>
            </a>

            <!-- 3. Pengingat -->
            <button type="button" @click="showReminderModal = true" 
               class="bg-white rounded-2xl p-5 sm:p-6 border-2 border-[#10b981]/50 hover:border-[#10b981] hover:shadow-md transition-all flex flex-col items-center justify-center text-center cursor-pointer group shadow-2xs">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center p-1 mb-1 group-hover:scale-105 transition-transform">
                    <!-- Clean illustration of bell with checkmark -->
                    <svg class="w-12 h-12" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32 8C22.0589 8 14 16.0589 14 26V38L8 46H56L50 38V26C50 16.0589 41.9411 8 32 8Z" fill="#059669"/>
                        <circle cx="32" cy="54" r="5" fill="#047857"/>
                        <circle cx="32" cy="30" r="10" fill="#34D399"/>
                        <path d="M28 30L31 33L37 27" stroke="#064E3B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="text-xs sm:text-sm font-extrabold text-slate-800 group-hover:text-emerald-700 transition-colors">
                    Pengingat
                </span>
            </button>

            <!-- 4. Riwayat -->
            <a href="{{ route('rekam-medis.index') }}" 
               class="bg-white rounded-2xl p-5 sm:p-6 border-2 border-[#f59e0b]/50 hover:border-[#f59e0b] hover:shadow-md transition-all flex flex-col items-center justify-center text-center cursor-pointer group shadow-2xs">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center p-1 mb-1 group-hover:scale-105 transition-transform">
                    <!-- Clean medical folder / wallet illustration -->
                    <svg class="w-12 h-12" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="14" width="44" height="40" rx="10" fill="#0D9488"/>
                        <path d="M10 24H54V18C54 13.5817 50.4183 10 46 10H18C13.5817 10 10 13.5817 10 18V24Z" fill="#F97316"/>
                        <circle cx="32" cy="36" r="3.5" fill="#ffffff"/>
                        <path d="M32 30V42M26 36H38" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <span class="text-xs sm:text-sm font-extrabold text-slate-800 group-hover:text-amber-700 transition-colors">
                    Riwayat
                </span>
            </a>
        </div>

        <!-- ====================================================================
             3. SECTION: ANTRIAN SAYA (Matching Reference Image)
             ==================================================================== -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">Antrian Saya</h2>
                <a href="{{ route('antrian.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1 group">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>

            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-[0_2px_12px_rgba(0,0,0,0.02)]">
                <!-- Top Row: Medical Bag + Doctor + Schedule -->
                <div class="flex items-start gap-4">
                    <!-- Green Medical First Aid Bag Icon -->
                    <div class="w-12 h-12 rounded-2xl bg-[#0f766e] text-white flex items-center justify-center shrink-0 shadow-xs">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8.25 4.5A2.25 2.25 0 0110.5 2.25h3a2.25 2.25 0 012.25 2.25V6h3.75A2.25 2.25 0 0121.75 8.25v9A2.25 2.25 0 0119.5 19.5H4.5A2.25 2.25 0 012.25 17.25v-9A2.25 2.25 0 014.5 6H8.25V4.5zm2.25 0v1.5h3V4.5h-3zM11.25 10.5a.75.75 0 00-1.5 0v2.25H7.5a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H13.5a.75.75 0 000-1.5H11.25V10.5z" />
                        </svg>
                    </div>

                    <div class="min-w-0 flex-1">
                        <h3 class="text-base sm:text-lg font-black text-slate-900 leading-tight">
                            Poli Penyakit Dalam
                        </h3>
                        <div class="flex items-center gap-1.5 text-xs text-slate-600 mt-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="font-medium">dr. Budi Santoso, Sp.PD</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-400 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <span>Rabu, 30 Juli 2025 | 09:00 - 11:00</span>
                        </div>
                    </div>
                </div>

                <!-- Divider Line -->
                <div class="border-t border-slate-100 my-5"></div>

                <!-- Numbers Display (Nomor Anda: A-034 Orange | Saat Ini: A-028 Green) -->
                <div class="grid grid-cols-2 gap-4 sm:gap-8">
                    <!-- Left Column: Nomor Anda -->
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Nomor Anda</span>
                        <div class="text-3xl sm:text-4xl font-black text-[#ea580c] tracking-tight mt-1">
                            A-034
                        </div>
                        <span class="text-xs text-slate-500 font-medium mt-1 block">
                            Estimasi 10:15 WIB
                        </span>
                    </div>

                    <!-- Right Column: Saat Ini -->
                    <div class="border-l border-slate-150 pl-5 sm:pl-8">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Saat Ini</span>
                        <div class="text-3xl sm:text-4xl font-black text-[#0f766e] tracking-tight mt-1">
                            A-028
                        </div>
                        <span class="text-xs text-slate-500 font-medium mt-1 block">
                            5 nomor lagi
                        </span>
                    </div>
                </div>

                <!-- Full-width Outline Action Button (Matching Reference) -->
                <a href="{{ route('antrian.detail') }}" 
                   class="w-full mt-6 py-3.5 px-4 rounded-2xl border border-[#0f766e] text-[#0f766e] hover:bg-[#e6f4ea]/60 active:scale-[0.99] font-extrabold text-sm transition-all flex items-center justify-center gap-1.5 shadow-2xs">
                    <span>Lihat Detail Antrian</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- ====================================================================
             4. BANNER INFORMASI PENTING (Matching Reference Image)
             ==================================================================== -->
        <div class="bg-[#f0f4f8] rounded-2xl p-4 sm:p-4.5 border border-slate-200/60 flex items-center gap-3.5 shadow-2xs">
            <div class="w-7 h-7 rounded-full bg-[#1e293b] text-white flex items-center justify-center text-xs font-black shrink-0">
                i
            </div>
            <p class="text-xs text-slate-700 font-medium leading-relaxed">
                <strong class="font-extrabold text-slate-900">Informasi Penting:</strong> Harap hadir 30 menit sebelum jadwal pemeriksaan.
            </p>
        </div>

        <!-- ====================================================================
             5. INFORMASI LAYANAN (Matching Reference Image: 3 Mint Cards)
             ==================================================================== -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">Informasi Layanan</h2>
                <a href="{{ route('jadwal.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1 group">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
                <!-- Card 1: Layanan Poliklinik -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex flex-col justify-between hover:shadow-md transition-all group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-[#dcfce7] text-[#15803d] flex items-center justify-center mb-4">
                            <!-- Stethoscope icon -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5M16.5 7.5l-3 3m0 0l-3-3m3 3V18"/>
                                <circle cx="18" cy="18" r="3"/>
                                <path d="M6 3v6a6 6 0 0012 0V3"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                            Layanan Poliklinik
                        </h3>
                        <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                            Tersedia berbagai layanan spesialis dan umum.
                        </p>
                    </div>
                    <a href="{{ route('jadwal.index') }}" class="text-xs font-extrabold text-emerald-700 hover:text-emerald-800 mt-5 inline-flex items-center gap-1.5">
                        <span>Selengkapnya</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Card 2: Jadwal Dokter -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex flex-col justify-between hover:shadow-md transition-all group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-[#dcfce7] text-[#15803d] flex items-center justify-center mb-4">
                            <!-- Document / Schedule icon -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                            Jadwal Dokter
                        </h3>
                        <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                            Lihat jadwal dokter hari ini dan buat janji temu.
                        </p>
                    </div>
                    <a href="{{ route('jadwal.index') }}" class="text-xs font-extrabold text-emerald-700 hover:text-emerald-800 mt-5 inline-flex items-center gap-1.5">
                        <span>Selengkapnya</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Card 3: Program Kesehatan -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex flex-col justify-between hover:shadow-md transition-all group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-[#dcfce7] text-[#15803d] flex items-center justify-center mb-4">
                            <!-- Shield health icon -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                            Program Kesehatan
                        </h3>
                        <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                            Informasi program dan edukasi kesehatan terbaru.
                        </p>
                    </div>
                    <button type="button" @click="showGermasModal = true" class="text-xs font-extrabold text-emerald-700 hover:text-emerald-800 mt-5 inline-flex items-center gap-1.5 cursor-pointer">
                        <span>Selengkapnya</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             6. FOOTER (Matching Reference Image)
             ==================================================================== -->
        <footer class="border-t border-slate-200/70 pt-8 pb-6 text-xs text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>© 2025 Satu Sehat LPSK. Semua hak dilindungi.</p>
            <div class="flex items-center gap-4 font-medium text-slate-500">
                <a href="{{ route('panduan') }}" class="hover:text-slate-800 transition-colors">Tentang Kami</a>
                <span>|</span>
                <a href="{{ route('panduan') }}" class="hover:text-slate-800 transition-colors">Bantuan</a>
                <span>|</span>
                <a href="#" class="hover:text-slate-800 transition-colors">Kebijakan Privasi</a>
            </div>
        </footer>

        <!-- ====================================================================
             MODALS: PENGINGAT, EDUKASI GERMAS, & NOTIFIKASI
             (Semua fungsi & logika backend tetap dipertahankan utuh)
             ==================================================================== -->
        
        <!-- Modal: Detail Pengingat Kontrol -->
        <div x-show="showReminderModal" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4"
             style="display: none;">
            <div @click.away="showReminderModal = false" class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 relative">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        Pengingat Jadwal Kontrol & Vaksinasi
                    </h3>
                    <button @click="showReminderModal = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-full hover:bg-slate-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="mt-4 space-y-3">
                    <template x-for="rem in reminders" :key="rem.id">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800" x-text="rem.type"></span>
                                <span class="text-[11px] font-bold text-slate-500" x-text="rem.days_left"></span>
                            </div>
                            <h4 class="text-xs font-black text-slate-900" x-text="rem.title"></h4>
                            <p class="text-xs text-slate-600" x-text="rem.date + ' • ' + rem.doctor"></p>
                            <p class="text-[11px] text-slate-500 italic" x-text="'Catatan: ' + rem.notes"></p>
                        </div>
                    </template>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 flex justify-end">
                    <button @click="showReminderModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal: Edukasi Kesehatan GERMAS -->
        <div x-show="showGermasModal" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4"
             style="display: none;">
            <div @click.away="showGermasModal = false" class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl border border-slate-100 relative max-h-[85vh] flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3 class="text-base font-extrabold text-slate-900">Edukasi Program Kesehatan & GERMAS</h3>
                        <button @click="showGermasModal = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-full hover:bg-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="mt-4 space-y-3 max-h-[55vh] overflow-y-auto pr-1">
                        <template x-for="art in germasArticles" :key="art.id">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70">
                                <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800" x-text="art.category"></span>
                                <h4 class="text-xs font-black text-slate-900 mt-2" x-text="art.title"></h4>
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed" x-text="art.summary"></p>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 flex justify-end">
                    <button @click="showGermasModal = false" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow-xs">
                        Tutup Bacaan
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- ====================================================================
         JAVASCRIPT LOGIC (Semua data & fungsi lama dipertahankan)
         ==================================================================== -->
    <script>
        function patientDashboard() {
            return {
                patient: {
                    name: '{{ auth()->user()?->name ?? "Andi Pratama" }}',
                    no_rm: 'RM-2023-0142',
                    nik: '3174091204890001',
                    status_bpjs: 'BPJS Aktif'
                },

                myQueue: {
                    hasActiveQueue: true,
                    queue_number: 'A-034',
                    poli: 'Poli Penyakit Dalam',
                    doctor: 'dr. Budi Santoso, Sp.PD',
                    ruang: 'Ruang 101 (Lt. 1)',
                    status: 'Menunggu',
                    current_serving: 'A-028',
                    waiting_ahead: 5,
                    estimated_time: '10:15 WIB',
                    registered_at: '08:45 WIB',
                    type: 'BPJS Kesehatan'
                },

                showReminderModal: false,
                reminders: [
                    {
                        id: 'REM-01',
                        type: 'Kontrol Rutin',
                        title: 'Kontrol Rutin Hipertensi & Evaluasi Obat',
                        doctor: 'dr. Budi Santoso, Sp.PD',
                        date: 'Kamis, 20 Agustus 2026',
                        days_left: '4 hari lagi',
                        notes: 'Bawa kartu BPJS dan catatan tensi mandiri.'
                    },
                    {
                        id: 'REM-02',
                        type: 'Pemeriksaan Lab',
                        title: 'Pemeriksaan Profil Lipid & Gula Darah',
                        doctor: 'dr. Analis Lab',
                        date: 'Senin, 24 Agustus 2026',
                        days_left: '8 hari lagi',
                        notes: 'Puasa 10-12 jam sebelum pengambilan darah.'
                    }
                ],

                showGermasModal: false,
                germasArticles: [
                    {
                        id: 'GERMAS-01',
                        category: 'Aktivitas Fisik',
                        title: 'Aktivitas Fisik 30 Menit Setiap Hari',
                        summary: 'Tingkatkan metabolisme tubuh, kurangi stres, dan jaga kesehatan kardiovaskular dengan olahraga rutin minimal 150 menit/minggu.'
                    },
                    {
                        id: 'GERMAS-02',
                        category: 'Gizi Seimbang',
                        title: 'Terapkan Konsep Isi Piringku Setiap Makan',
                        summary: 'Pola makan seimbang: 1/2 piring sayur & buah, 1/4 piring karbohidrat kompleks, dan 1/4 piring lauk berprotein tinggi.'
                    },
                    {
                        id: 'GERMAS-03',
                        category: 'Deteksi Dini',
                        title: 'Cek Kesehatan Berkala (CERDIK)',
                        summary: 'Deteksi dini risiko hipertensi, diabetes, dan kolesterol dengan pemeriksaan tensi, gula darah, dan lingkar perut secara teratur.'
                    }
                ]
            };
        }
    </script>
</x-app-layout>
