<x-app-layout>
    <div x-data="patientDashboard()" 
         x-on:open-patient-modal.window="if ($event.detail.name === 'reminder') showReminderModal = true; if ($event.detail.name === 'daftar') showDaftarBerobatModal = true; if ($event.detail.name === 'resep') showResepModal = true;"
         class="space-y-6 max-w-6xl mx-auto">

        <!-- ====================================================================
             1. WELCOME BANNER (Patient Information & Building Photo)
             ==================================================================== -->
        <div class="bg-white rounded-lg p-5 border border-slate-200 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="flex-1 min-w-0">
                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-medium bg-teal-50 text-teal-800 border border-teal-200 mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-600"></span>
                    <span>Portal Pasien &bull; Satu Sehat LPSK</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    {{ auth()->user()?->name ?? 'Andi Pratama' }}
                </h1>
                
                <!-- Patient Meta Chips -->
                <div class="flex flex-wrap items-center gap-2 mt-2.5 text-xs text-slate-600">
                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 border border-slate-200 font-mono font-semibold text-slate-800">
                        No. RM: <span class="ml-1 text-teal-800" x-text="patient.no_rm"></span>
                    </span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 border border-slate-200 font-mono text-slate-700">
                        NIK: <span class="ml-1 font-semibold" x-text="patient.nik"></span>
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-teal-50 border border-teal-200 text-teal-800 font-medium">
                        <svg class="w-3 h-3 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span x-text="patient.status_bpjs"></span>
                    </span>
                </div>

                <!-- Action Button: Daftar Berobat -->
                <div class="mt-3.5">
                    <button type="button" 
                            @click="showDaftarBerobatModal = true" 
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-semibold rounded-lg shadow-2xs transition-colors cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Daftar Kunjungan Berobat</span>
                    </button>
                </div>
            </div>
            
            <!-- LPSK Building Photo with Exterior Logo -->
            <div class="shrink-0 w-full md:w-64 lg:w-72 h-32 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 relative">
                <img src="{{ asset('images/gedung-lpsk.jpg') }}" 
                     alt="Gedung Lembaga Perlindungan Saksi dan Korban (LPSK)" 
                     class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent pointer-events-none"></div>
                <div class="absolute bottom-1.5 left-2.5 right-2.5 text-white text-[10px] font-semibold">
                    Gedung Pelayanan Terpadu LPSK
                </div>
            </div>
        </div>

        <!-- ====================================================================
             2. GRID 6 QUICK ACTION CARDS (Clean Patient-Centric Actions)
             ==================================================================== -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            
            <!-- 1. Daftar Berobat -->
            <button type="button" 
                    @click="showDaftarBerobatModal = true" 
                    class="bg-white rounded-lg p-3.5 border border-slate-200 hover:border-teal-700 hover:bg-slate-50/50 transition-colors flex flex-col items-center justify-center text-center cursor-pointer shadow-2xs group">
                <div class="w-10 h-10 rounded-lg bg-teal-50 border border-teal-100 text-teal-700 flex items-center justify-center mb-2 group-hover:bg-teal-700 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-teal-800 transition-colors">
                    Daftar Berobat
                </span>
                <span class="text-[10px] text-slate-400 mt-0.5">
                    Ambil antrean
                </span>
            </button>

            <!-- 2. Antrean Saya -->
            <a href="{{ route('antrian.index') }}" 
               class="bg-white rounded-lg p-3.5 border border-slate-200 hover:border-teal-700 hover:bg-slate-50/50 transition-colors flex flex-col items-center justify-center text-center cursor-pointer shadow-2xs group">
                <div class="w-10 h-10 rounded-lg bg-amber-50 border border-amber-100 text-amber-700 flex items-center justify-center mb-2 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-teal-800 transition-colors">
                    Antrean Saya
                </span>
                <span class="text-[10px] font-mono text-amber-700 font-semibold mt-0.5">
                    A-034 Aktif
                </span>
            </a>

            <!-- 3. Jadwal Kunjungan -->
            <a href="{{ route('jadwal.index') }}" 
               class="bg-white rounded-lg p-3.5 border border-slate-200 hover:border-teal-700 hover:bg-slate-50/50 transition-colors flex flex-col items-center justify-center text-center cursor-pointer shadow-2xs group">
                <div class="w-10 h-10 rounded-lg bg-teal-50 border border-teal-100 text-teal-700 flex items-center justify-center mb-2 group-hover:bg-teal-700 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-teal-800 transition-colors">
                    Jadwal Dokter
                </span>
                <span class="text-[10px] text-slate-400 mt-0.5">
                    Jadwal praktik
                </span>
            </a>

            <!-- 4. Resep / Obat -->
            <button type="button" 
                    @click="showResepModal = true" 
                    class="bg-white rounded-lg p-3.5 border border-slate-200 hover:border-teal-700 hover:bg-slate-50/50 transition-colors flex flex-col items-center justify-center text-center cursor-pointer shadow-2xs group">
                <div class="w-10 h-10 rounded-lg bg-teal-50 border border-teal-100 text-teal-700 flex items-center justify-center mb-2 group-hover:bg-teal-700 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-teal-800 transition-colors">
                    Resep Obat
                </span>
                <span class="text-[10px] font-mono text-teal-700 font-semibold mt-0.5">
                    3 Resep aktif
                </span>
            </button>

            <!-- 5. Riwayat Pemeriksaan -->
            <a href="{{ route('rekam-medis.index') }}" 
               class="bg-white rounded-lg p-3.5 border border-slate-200 hover:border-teal-700 hover:bg-slate-50/50 transition-colors flex flex-col items-center justify-center text-center cursor-pointer shadow-2xs group">
                <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center mb-2 group-hover:bg-slate-800 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-teal-800 transition-colors">
                    Riwayat Medis
                </span>
                <span class="text-[10px] text-slate-400 mt-0.5">
                    Catatan klinis
                </span>
            </a>

            <!-- 6. Pengingat / Notifikasi -->
            <button type="button" 
                    @click="showReminderModal = true" 
                    class="bg-white rounded-lg p-3.5 border border-slate-200 hover:border-teal-700 hover:bg-slate-50/50 transition-colors flex flex-col items-center justify-center text-center cursor-pointer shadow-2xs group">
                <div class="w-10 h-10 rounded-lg bg-teal-50 border border-teal-100 text-teal-700 flex items-center justify-center mb-2 group-hover:bg-teal-700 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-teal-800 transition-colors">
                    Pengingat
                </span>
                <span class="text-[10px] text-teal-700 font-semibold mt-0.5">
                    Kontrol rutin
                </span>
            </button>

        </div>

        <!-- ====================================================================
             3. MAIN SECTION: ANTREAN SAYA & STATUS LAYANAN (Oriented to Patient)
             ==================================================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Left Col (2 Columns on Large): Antrean Aktif & Resep Obat -->
            <div class="lg:col-span-2 space-y-4">

                <!-- 3A. CARD ANTREAN SAYA AKTIF -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                            <h2 class="text-sm font-bold text-slate-900 tracking-tight">Antrean Saya Hari Ini</h2>
                        </div>
                        <a href="{{ route('antrian.index') }}" class="text-xs font-semibold text-teal-800 hover:text-teal-900 flex items-center gap-1">
                            <span>Lihat Semua Antrean</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>

                    <div class="bg-white rounded-lg p-5 border border-slate-200 shadow-2xs">
                        <!-- Top Row: Medical Bag + Doctor + Schedule -->
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-lg bg-teal-700 text-white flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8.25 4.5A2.25 2.25 0 0110.5 2.25h3a2.25 2.25 0 012.25 2.25V6h3.75A2.25 2.25 0 0121.75 8.25v9A2.25 2.25 0 0119.5 19.5H4.5A2.25 2.25 0 012.25 17.25v-9A2.25 2.25 0 014.5 6H8.25V4.5zm2.25 0v1.5h3V4.5h-3zM11.25 10.5a.75.75 0 00-1.5 0v2.25H7.5a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H13.5a.75.75 0 000-1.5H11.25V10.5z" />
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h3 class="text-base font-bold text-slate-900 leading-tight" x-text="myQueue.poli">
                                        Poli Penyakit Dalam
                                    </h3>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-800 border border-amber-200">
                                        <span x-text="myQueue.status">Menunggu</span>
                                    </span>
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-slate-600 mt-1">
                                    <span class="font-medium text-slate-800" x-text="myQueue.doctor">dr. Budi Santoso, Sp.PD</span>
                                    <span class="text-slate-300">&bull;</span>
                                    <span class="text-slate-500 font-mono text-[11px]" x-text="myQueue.ruang">Ruang 101</span>
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5 font-mono">
                                    Rabu, 30 Juli 2025 &bull; 09:00 - 11:00 WIB
                                </div>
                            </div>
                        </div>

                        <!-- Divider Line -->
                        <div class="border-t border-slate-100 my-4"></div>

                        <!-- Numbers Display (Nomor Anda vs Saat Ini) -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Left Column: Nomor Anda -->
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Nomor Anda</span>
                                <div class="text-3xl font-extrabold font-mono text-amber-700 tracking-tight mt-0.5" x-text="myQueue.queue_number">
                                    A-034
                                </div>
                                <span class="text-[11px] text-slate-500 mt-0.5 block">
                                    Estimasi: <strong class="text-slate-800 font-mono" x-text="myQueue.estimated_time">10:15 WIB</strong>
                                </span>
                            </div>

                            <!-- Right Column: Saat Ini Dipanggil -->
                            <div class="p-3 bg-teal-50/50 rounded-lg border border-teal-200">
                                <span class="text-[10px] font-bold text-teal-800 uppercase tracking-wider block">Saat Ini Dilayani</span>
                                <div class="text-3xl font-extrabold font-mono text-teal-800 tracking-tight mt-0.5" x-text="myQueue.current_serving">
                                    A-028
                                </div>
                                <span class="text-[11px] text-teal-800 font-medium mt-0.5 block">
                                    <span x-text="myQueue.waiting_ahead">5</span> nomor lagi giliran Anda
                                </span>
                            </div>
                        </div>

                        <!-- Patient Action: Detail Tiket Antrean (NO Panggil Antrian Button) -->
                        <div class="mt-4 flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('antrian.detail') }}" 
                               class="flex-1 py-2 px-3 rounded-lg border border-teal-700 text-teal-800 hover:bg-teal-50 font-semibold text-xs transition-colors flex items-center justify-center gap-1.5 shadow-2xs">
                                <span>Lihat Detail Tiket Antrean & QR</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="{{ route('antrian.index') }}" 
                               class="py-2 px-3 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-xs transition-colors text-center">
                                Pantau Seluruh Antrean
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3B. BANNER INFORMASI PENTING -->
                <div class="bg-slate-50 rounded-lg p-3 border border-slate-200 flex items-center gap-3">
                    <div class="w-6 h-6 rounded bg-slate-800 text-white flex items-center justify-center text-xs font-bold shrink-0">
                        i
                    </div>
                    <p class="text-xs text-slate-700 leading-relaxed">
                        <strong class="font-bold text-slate-900">Informasi Penting:</strong> Harap hadir minimal 15-30 menit sebelum jadwal pemeriksaan di ruang tunggu poliklinik dan tunjukkan kartu identitas/BPJS.
                    </p>
                </div>

                <!-- 3C. STATUS RESEP & OBAT TERAKHIR -->
                <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-2xs space-y-3">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded bg-teal-50 text-teal-700 flex items-center justify-center border border-teal-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-slate-900 leading-tight">E-Resep Obat Pasien</h3>
                                <p class="text-[10px] text-slate-400 font-mono">Resep No. RSP-2026-081 &bull; Dokter: dr. Rina Kusuma</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-teal-50 text-teal-800 border border-teal-200">
                            Siap Diambil di Farmasi
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <template x-for="(item, idx) in activePrescriptions" :key="idx">
                            <div class="p-2.5 rounded border border-slate-200 bg-slate-50 space-y-0.5">
                                <p class="text-xs font-semibold text-slate-900 truncate" x-text="item.name"></p>
                                <p class="text-[11px] text-teal-800 font-medium" x-text="item.dosage"></p>
                                <p class="text-[10px] text-slate-500 italic" x-text="item.note"></p>
                            </div>
                        </template>
                    </div>

                    <div class="pt-1 flex justify-between items-center text-xs">
                        <span class="text-[11px] text-slate-500">Tunjukkan nomor resep saat pengambilan obat di apotek.</span>
                        <button type="button" @click="showResepModal = true" class="text-xs font-semibold text-teal-800 hover:text-teal-900 cursor-pointer">
                            Rincian Resep &rarr;
                        </button>
                    </div>
                </div>

            </div>

            <!-- Right Col (1 Column on Large): Jadwal Kunjungan & Riwayat Terakhir -->
            <div class="space-y-4">

                <!-- 3D. JADWAL KUNJUNGAN BERIKUTNYA -->
                <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-2xs space-y-2.5">
                    <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                        <h3 class="font-bold text-slate-700 uppercase tracking-wider text-[11px]">
                            Jadwal Kunjungan Berikutnya
                        </h3>
                        <a href="{{ route('jadwal.index') }}" class="text-[11px] font-semibold text-teal-800 hover:text-teal-900">
                            Jadwal Dokter
                        </a>
                    </div>

                    <div class="p-3 rounded-lg bg-teal-50/60 border border-teal-200 space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-medium bg-teal-700 text-white">
                                Kontrol Rutin
                            </span>
                            <span class="text-xs font-bold text-teal-900 font-mono">
                                4 hari lagi
                            </span>
                        </div>
                        <h4 class="text-xs font-bold text-slate-900">
                            Evaluasi Hipertensi & Terapi Obat
                        </h4>
                        <div class="text-[11px] text-slate-600 space-y-0.5">
                            <p><strong>Dokter:</strong> dr. Budi Santoso, Sp.PD</p>
                            <p><strong>Waktu:</strong> Kamis, 20 Agustus 2026 (09:00 WIB)</p>
                            <p><strong>Lokasi:</strong> Ruang 101, Lantai 1</p>
                        </div>
                    </div>
                </div>

                <!-- 3E. RIWAYAT KUNJUNGAN TERAKHIR -->
                <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-2xs space-y-2.5">
                    <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                        <h3 class="font-bold text-slate-700 uppercase tracking-wider text-[11px]">
                            Riwayat Pemeriksaan Terakhir
                        </h3>
                        <a href="{{ route('rekam-medis.index') }}" class="text-[11px] font-semibold text-teal-800 hover:text-teal-900">
                            Rekam Medis
                        </a>
                    </div>

                    <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 space-y-1.5">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="font-mono text-slate-600">14 Okt 2023 &bull; 09:15 WIB</span>
                            <span class="px-1.5 py-0.5 rounded bg-slate-200 text-slate-700 text-[10px] font-medium">Poli Umum</span>
                        </div>
                        <p class="text-xs font-bold text-slate-900">
                            Acute upper respiratory infection, unspecified (ISPA)
                        </p>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Dokter: dr. Rina Kusuma &bull; Terapi: Paracetamol 500mg, Ambroxol, Vitamin C.
                        </p>
                        <div class="pt-0.5">
                            <a href="{{ route('rekam-medis.index') }}" class="text-[11px] font-semibold text-teal-800 hover:text-teal-900 inline-flex items-center gap-1">
                                <span>Lihat Resume Rekam Medis</span>
                                &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3F. STATUS PENJAMIN & DATA REKAM MEDIS -->
                <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-2xs space-y-2">
                    <h3 class="font-bold text-slate-700 uppercase tracking-wider text-[11px] pb-1.5 border-b border-slate-100">
                        Status Pendaftaran & Kepesertaan
                    </h3>
                    <div class="space-y-1.5 text-xs">
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500">Penjamin Utama</span>
                            <span class="font-semibold text-slate-800">BPJS Kesehatan / LPSK</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500">Status Kartu</span>
                            <span class="font-semibold text-teal-800">Aktif & Terverifikasi</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500">Faskes Asal</span>
                            <span class="font-semibold text-slate-800">Klinik Pratama LPSK</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-slate-500">Notifikasi WhatsApp</span>
                            <span class="font-semibold text-teal-800">Aktif</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- ====================================================================
             4. INFORMASI LAYANAN & EDUKASI KESEHATAN
             ==================================================================== -->
        <div class="space-y-3 pt-1">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-900 tracking-tight">Informasi Layanan & Edukasi Kesehatan</h2>
                <a href="{{ route('jadwal.index') }}" class="text-xs font-semibold text-teal-800 hover:text-teal-900 flex items-center gap-1">
                    <span>Lihat Semua Layanan</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
                <!-- Card 1: Layanan Poliklinik -->
                <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-2xs flex flex-col justify-between">
                    <div>
                        <div class="w-9 h-9 rounded bg-teal-50 border border-teal-100 text-teal-700 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5M16.5 7.5l-3 3m0 0l-3-3m3 3V18"/>
                                <circle cx="18" cy="18" r="3"/>
                                <path d="M6 3v6a6 6 0 0012 0V3"/>
                            </svg>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900">
                            Layanan Poliklinik
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Tersedia layanan Poli Umum, Poli Gigi & Mulut, serta Poli Anak (Pediatri).
                        </p>
                    </div>
                    <a href="{{ route('jadwal.index') }}" class="text-xs font-semibold text-teal-800 hover:text-teal-900 mt-4 inline-flex items-center gap-1">
                        <span>Lihat Jadwal Praktik</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Card 2: Jadwal Dokter -->
                <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-2xs flex flex-col justify-between">
                    <div>
                        <div class="w-9 h-9 rounded bg-teal-50 border border-teal-100 text-teal-700 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900">
                            Konsultasi & Janji Temu
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Konsultasikan keluhan kesehatan Anda dengan dokter penanggung jawab pelayanan klinik.
                        </p>
                    </div>
                    <button type="button" @click="showDaftarBerobatModal = true" class="text-xs font-semibold text-teal-800 hover:text-teal-900 mt-4 inline-flex items-center gap-1 text-left cursor-pointer">
                        <span>Daftar Kunjungan</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>

                <!-- Card 3: Program Kesehatan GERMAS -->
                <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-2xs flex flex-col justify-between">
                    <div>
                        <div class="w-9 h-9 rounded bg-teal-50 border border-teal-100 text-teal-700 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                            </svg>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900">
                            Program Kesehatan & GERMAS
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Panduan gaya hidup sehat, nutrisi seimbang, dan pencegahan faktor risiko penyakit.
                        </p>
                    </div>
                    <button type="button" @click="showGermasModal = true" class="text-xs font-semibold text-teal-800 hover:text-teal-900 mt-4 inline-flex items-center gap-1 cursor-pointer">
                        <span>Baca Edukasi</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             5. FOOTER (Matching Reference)
             ==================================================================== -->
        <footer class="border-t border-slate-200 pt-6 pb-4 text-xs text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>&copy; 2026 Satu Sehat LPSK. Semua hak dilindungi.</p>
            <div class="flex items-center gap-3 font-medium text-slate-500">
                <a href="{{ route('panduan') }}" class="hover:text-slate-800 transition-colors">Panduan Pasien</a>
                <span class="text-slate-300">|</span>
                <a href="{{ route('panduan') }}" class="hover:text-slate-800 transition-colors">Pusat Bantuan</a>
                <span class="text-slate-300">|</span>
                <span class="text-slate-500">Hotline Klinik: 1500-148</span>
            </div>
        </footer>

        <!-- ====================================================================
             MODALS: DAFTAR BEROBAT, RESEP, PENGINGAT, & EDUKASI GERMAS
             ==================================================================== -->
        
        <!-- Modal 1: Daftar Berobat (Pendaftaran Kunjungan Mandiri Pasien) -->
        <div x-show="showDaftarBerobatModal" 
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 flex items-center justify-center p-3 sm:p-4"
             style="display: none;">
            <div @click.away="showDaftarBerobatModal = false" class="bg-white rounded-lg max-w-md w-full p-5 shadow-xl border border-slate-200 relative">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                            Pendaftaran Kunjungan Berobat
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Daftarkan diri Anda untuk pemeriksaan poli di Klinik LPSK</p>
                    </div>
                    <button @click="showDaftarBerobatModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <form @submit.prevent="submitDaftarBerobat()" class="mt-3.5 space-y-3">
                    <!-- Patient Name (Fixed to current patient) -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Nama Pasien</label>
                        <input type="text" :value="patient.name" readonly class="w-full py-1.5 px-3 rounded-lg border border-slate-200 bg-slate-50 text-slate-700 text-xs font-medium cursor-not-allowed">
                    </div>

                    <!-- Pilih Poli -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Poliklinik Tujuan</label>
                        <select x-model="newRegistration.poli" @change="updateDoctorsRegistration()" class="w-full py-1.5 px-3 rounded-lg border border-slate-300 text-slate-800 text-xs bg-white focus:ring-1 focus:ring-teal-700 focus:border-teal-700">
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Gigi">Poli Gigi & Mulut</option>
                            <option value="Poli Anak">Poli Anak (Pediatri)</option>
                            <option value="Poli Penyakit Dalam">Poli Penyakit Dalam</option>
                        </select>
                    </div>

                    <!-- Pilih Dokter -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Dokter Pemeriksa</label>
                        <select x-model="newRegistration.doctor" class="w-full py-1.5 px-3 rounded-lg border border-slate-300 text-slate-800 text-xs bg-white focus:ring-1 focus:ring-teal-700 focus:border-teal-700">
                            <template x-for="doc in (doctorsByPoli[newRegistration.poli] || ['dr. Rina Kusuma'])" :key="doc">
                                <option :value="doc" x-text="doc"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Penjamin -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Jenis Penjamin / Pembayaran</label>
                        <select x-model="newRegistration.type" class="w-full py-1.5 px-3 rounded-lg border border-slate-300 text-slate-800 text-xs bg-white focus:ring-1 focus:ring-teal-700 focus:border-teal-700">
                            <option value="BPJS Kesehatan">BPJS Kesehatan (Terdaftar)</option>
                            <option value="LPSK Mandiri">Layanan Perlindungan LPSK</option>
                            <option value="Pasien Umum">Pasien Umum / Tunai</option>
                        </select>
                    </div>

                    <!-- Keluhan Singkat -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Keluhan / Gejala Singkat (Opsional)</label>
                        <textarea x-model="newRegistration.complaint" rows="2" placeholder="Contoh: Demam sejak kemarin, batuk dan sakit tenggorokan..." class="w-full py-1.5 px-3 rounded-lg border border-slate-300 text-slate-800 text-xs placeholder-slate-400 focus:ring-1 focus:ring-teal-700 focus:border-teal-700"></textarea>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex gap-2 justify-end">
                        <button type="button" @click="showDaftarBerobatModal = false" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-1.5 bg-teal-700 hover:bg-teal-800 text-white text-xs font-semibold rounded-lg shadow-2xs transition-colors cursor-pointer">
                            Konfirmasi & Ambil Antrean
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal 2: Resep Obat & Petunjuk Konsumsi -->
        <div x-show="showResepModal" 
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 flex items-center justify-center p-3 sm:p-4"
             style="display: none;">
            <div @click.away="showResepModal = false" class="bg-white rounded-lg max-w-md w-full p-5 shadow-xl border border-slate-200 relative">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                            Rincian E-Resep & Petunjuk Minum Obat
                        </h3>
                        <p class="text-[10px] text-slate-500 font-mono mt-0.5">Resep No. RSP-2026-081 &bull; Dokter: dr. Rina Kusuma</p>
                    </div>
                    <button @click="showResepModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="mt-3.5 space-y-2.5">
                    <template x-for="(med, idx) in activePrescriptions" :key="idx">
                        <div class="p-3 rounded border border-slate-200 bg-slate-50 space-y-1">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-bold text-slate-900" x-text="med.name"></h4>
                                <span class="text-[10px] font-medium px-2 py-0.5 rounded bg-teal-50 text-teal-800 border border-teal-200" x-text="med.status"></span>
                            </div>
                            <div class="text-xs text-teal-800 font-semibold" x-text="'Dosis: ' + med.dosage"></div>
                            <div class="text-[11px] text-slate-600" x-text="'Jumlah: ' + med.qty + ' &bull; Bentuk: ' + med.sediaan"></div>
                            <div class="text-[11px] text-slate-500 italic" x-text="'Keterangan: ' + med.note"></div>
                        </div>
                    </template>
                </div>

                <div class="mt-3.5 p-2.5 rounded bg-amber-50 border border-amber-200 text-[11px] text-amber-800 leading-relaxed">
                    <strong>Perhatian:</strong> Habiskan obat antibiotik sesuai instruksi dokter. Jika timbul efek samping, segera hubungi kontak unit farmasi klinik LPSK.
                </div>

                <div class="mt-4 pt-3 border-t border-slate-200 flex justify-end">
                    <button @click="showResepModal = false" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal 3: Detail Pengingat Kontrol -->
        <div x-show="showReminderModal" 
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 flex items-center justify-center p-3 sm:p-4"
             style="display: none;">
            <div @click.away="showReminderModal = false" class="bg-white rounded-lg max-w-md w-full p-5 shadow-xl border border-slate-200 relative">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                        Pengingat Jadwal Kontrol & Vaksinasi
                    </h3>
                    <button @click="showReminderModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="mt-3.5 space-y-2.5">
                    <template x-for="rem in reminders" :key="rem.id">
                        <div class="p-3 rounded border border-slate-200 bg-slate-50 space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-medium px-2 py-0.5 rounded bg-teal-50 text-teal-800 border border-teal-200" x-text="rem.type"></span>
                                <span class="text-[11px] font-mono text-slate-500" x-text="rem.days_left"></span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900" x-text="rem.title"></h4>
                            <p class="text-xs text-slate-600" x-text="rem.date + ' &bull; ' + rem.doctor"></p>
                            <p class="text-[11px] text-slate-500 italic" x-text="'Catatan: ' + rem.notes"></p>
                        </div>
                    </template>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200 flex justify-end">
                    <button @click="showReminderModal = false" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal 4: Edukasi Kesehatan GERMAS -->
        <div x-show="showGermasModal" 
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 flex items-center justify-center p-3 sm:p-4"
             style="display: none;">
            <div @click.away="showGermasModal = false" class="bg-white rounded-lg max-w-lg w-full p-5 shadow-xl border border-slate-200 relative max-h-[85vh] flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                        <h3 class="text-sm font-bold text-slate-900">Edukasi Program Kesehatan & GERMAS</h3>
                        <button @click="showGermasModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="mt-3.5 space-y-2.5 max-h-[55vh] overflow-y-auto pr-1">
                        <template x-for="art in germasArticles" :key="art.id">
                            <div class="p-3 rounded border border-slate-200 bg-slate-50">
                                <span class="text-[10px] font-medium px-2 py-0.5 rounded bg-teal-50 text-teal-800 border border-teal-200" x-text="art.category"></span>
                                <h4 class="text-xs font-bold text-slate-900 mt-1.5" x-text="art.title"></h4>
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed" x-text="art.summary"></p>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200 flex justify-end">
                    <button @click="showGermasModal = false" class="px-3.5 py-1.5 bg-teal-700 hover:bg-teal-800 text-white text-xs font-semibold rounded-lg shadow-2xs transition-colors cursor-pointer">
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
                    status_bpjs: 'BPJS Kesehatan Aktif'
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

                showDaftarBerobatModal: false,
                newRegistration: {
                    poli: 'Poli Umum',
                    doctor: 'dr. Rina Kusuma',
                    type: 'BPJS Kesehatan',
                    complaint: ''
                },
                doctorsByPoli: {
                    'Poli Umum': ['dr. Rina Kusuma', 'dr. Budi S.'],
                    'Poli Gigi': ['drg. Hendra P.', 'drg. Maya Putri'],
                    'Poli Anak': ['dr. Sari Dewi'],
                    'Poli Penyakit Dalam': ['dr. Budi Santoso, Sp.PD']
                },
                updateDoctorsRegistration() {
                    const docs = this.doctorsByPoli[this.newRegistration.poli];
                    if (docs && docs.length > 0) {
                        this.newRegistration.doctor = docs[0];
                    }
                },
                submitDaftarBerobat() {
                    let prefix = 'A';
                    if (this.newRegistration.poli === 'Poli Gigi') prefix = 'B';
                    else if (this.newRegistration.poli === 'Poli Anak') prefix = 'C';
                    else if (this.newRegistration.poli === 'Poli Penyakit Dalam') prefix = 'D';

                    let count = Math.floor(Math.random() * 50) + 35;
                    let queueNo = prefix + '-' + String(count).padStart(3, '0');

                    this.myQueue.queue_number = queueNo;
                    this.myQueue.poli = this.newRegistration.poli;
                    this.myQueue.doctor = this.newRegistration.doctor;
                    this.myQueue.status = 'Menunggu';
                    this.myQueue.waiting_ahead = 4;
                    this.myQueue.estimated_time = '10:45 WIB';
                    this.myQueue.hasActiveQueue = true;
                    this.showDaftarBerobatModal = false;

                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: { 
                            type: 'success', 
                            title: 'Pendaftaran Berhasil', 
                            message: 'Nomor antrean ' + queueNo + ' di ' + this.newRegistration.poli + ' berhasil diambil. Silakan tiba tepat waktu.' 
                        }
                    }));
                },

                showResepModal: false,
                activePrescriptions: [
                    { name: 'Paracetamol 500mg', sediaan: 'Tablet', dosage: '3 x 1 tablet sesudah makan', qty: '10 tablet', note: 'Diminum bila demam atau nyeri', status: 'Siap Diambil' },
                    { name: 'Ambroxol 30mg', sediaan: 'Tablet', dosage: '3 x 1 tablet sesudah makan', qty: '10 tablet', note: 'Meredakan batuk berdahak', status: 'Siap Diambil' },
                    { name: 'Vitamin C 500mg', sediaan: 'Tablet', dosage: '1 x 1 tablet sesudah makan', qty: '10 tablet', note: 'Suplemen daya tahan tubuh', status: 'Siap Diambil' }
                ],

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
