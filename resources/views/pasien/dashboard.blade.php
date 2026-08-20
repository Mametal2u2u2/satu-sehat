<x-app-layout>
    <div x-data="patientDashboard()" class="space-y-6 max-w-7xl mx-auto">

        <!-- ====================================================================
             1. HEADER PERSONAL PASIEN
             ==================================================================== -->
        <div class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-700 rounded-3xl p-6 sm:p-8 text-white shadow-lg shadow-emerald-700/15 relative overflow-hidden">
            <!-- Decorative Patterns -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-1/3 -mb-12 w-48 h-48 bg-emerald-400/20 rounded-full blur-xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <!-- Patient Profile Info -->
                <div class="flex items-center gap-4 sm:gap-5">
                    <div class="relative flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&h=200&q=80" 
                             alt="Foto Profil Pasien" 
                             class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover ring-4 ring-white/30 shadow-md">
                        <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-400 border-2 border-emerald-800 rounded-full flex items-center justify-center text-[10px] text-emerald-950 font-bold" title="Online / Aktif">✓</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-emerald-800/60 text-emerald-200 border border-emerald-500/30 tracking-wide" x-text="greetingTime">
                                Selamat Pagi
                            </span>
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-white/20 text-white backdrop-blur-sm">
                                <span x-text="patient.status_bpjs">BPJS Aktif</span>
                            </span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-1">
                            Halo, <span x-text="patient.name">Budi Santoso</span>! 👋
                        </h1>
                        <p class="text-xs sm:text-sm text-emerald-100/90 font-medium mt-0.5 flex items-center gap-2">
                            <span>No. RM: <strong class="text-white tracking-wider" x-text="patient.no_rm">RM-2023-0142</strong></span>
                            <span>•</span>
                            <span>Klinik LPSK Melayani dengan Hati</span>
                        </p>
                    </div>
                </div>

                <!-- Header Action Buttons & Notification Bell -->
                <div class="flex items-center gap-3 self-end md:self-center">
                    <!-- Notification Bell with Counter -->
                    <button @click="showNotificationModal = true" 
                            class="relative p-3 bg-white/15 hover:bg-white/25 active:scale-95 transition-all rounded-2xl backdrop-blur-md border border-white/20 text-white flex items-center justify-center group focus:outline-none focus:ring-2 focus:ring-white/50"
                            title="Notifikasi Pasien">
                        <svg class="w-6 h-6 transform group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <template x-if="unreadNotificationCount > 0">
                            <span class="absolute -top-1.5 -right-1.5 px-2 py-0.5 bg-rose-500 text-white text-[11px] font-extrabold rounded-full border-2 border-emerald-700 shadow-md animate-pulse"
                                  x-text="unreadNotificationCount">
                                2
                            </span>
                        </template>
                    </button>

                    <!-- Ambil Antrian Baru Shortcut -->
                    <a href="{{ route('antrian.detail') }}" 
                       class="inline-flex items-center gap-2 px-4 py-3 bg-white text-emerald-800 hover:bg-emerald-50 active:scale-95 font-bold text-sm rounded-2xl shadow-md shadow-emerald-900/20 transition-all">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Ambil Antrian</span>
                    </a>
                </div>
            </div>

            <!-- Quick Status Ticker -->
            <div class="mt-5 pt-4 border-t border-white/15 flex flex-wrap items-center justify-between gap-3 text-xs text-emerald-100">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-ping"></span>
                    <span class="font-medium">Status Klinik: <strong class="text-white">Buka & Beroperasi Normal</strong></span>
                </div>
                <div class="flex items-center gap-4">
                    <span>🕒 Jam Layanan: 08:00 - 21:00 WIB</span>
                    <span>🚑 Layanan Darurat: 119 / 021-2929-LPSK</span>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             2. CARD "ANTRIAN SAYA" (LIVE MONITORING & TIMELINE)
             ==================================================================== -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] relative">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg">
                        🎫
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-xl font-bold text-gray-900">Antrian Saya</h2>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold"
                                  :class="{
                                      'bg-amber-100 text-amber-800': myQueue.status === 'Menunggu',
                                      'bg-emerald-100 text-emerald-800 ring-2 ring-emerald-400/50 animate-pulse': myQueue.status === 'Dipanggil',
                                      'bg-gray-100 text-gray-700': myQueue.status === 'Selesai'
                                  }"
                                  x-text="myQueue.status">
                                Menunggu
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">Monitoring antrean aktif Anda hari ini secara langsung.</p>
                    </div>
                </div>

                <!-- Simulation Tools for Reviewers & Users -->
                <div class="flex items-center gap-2 bg-gray-50 p-1.5 rounded-2xl border border-gray-200/80 text-xs">
                    <span class="text-gray-500 font-semibold px-2">Simulasi Status:</span>
                    <button @click="setQueueStatus('Menunggu')" 
                            :class="myQueue.status === 'Menunggu' ? 'bg-white shadow-sm text-amber-700 font-bold' : 'text-gray-500 hover:text-gray-900'"
                            class="px-2.5 py-1 rounded-xl transition-all">
                        Menunggu
                    </button>
                    <button @click="setQueueStatus('Dipanggil')" 
                            :class="myQueue.status === 'Dipanggil' ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'text-gray-500 hover:text-gray-900'"
                            class="px-2.5 py-1 rounded-xl transition-all">
                        Dipanggil 🔔
                    </button>
                    <button @click="setQueueStatus('Selesai')" 
                            :class="myQueue.status === 'Selesai' ? 'bg-white shadow-sm text-gray-800 font-bold' : 'text-gray-500 hover:text-gray-900'"
                            class="px-2.5 py-1 rounded-xl transition-all">
                        Selesai
                    </button>
                </div>
            </div>

            <!-- Queue Banner Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6 items-center">
                <!-- Left: Big Ticket Number & Poli Info -->
                <div class="lg:col-span-5 bg-gradient-to-br from-emerald-50 via-teal-50/50 to-white rounded-2xl p-5 border border-emerald-100/80 flex flex-col justify-between relative overflow-hidden">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Nomor Antrean Anda</span>
                            <div class="text-4xl sm:text-5xl font-black text-emerald-700 tracking-tight mt-1" x-text="myQueue.queue_number">
                                A-014
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] font-bold uppercase text-gray-400 block">Jenis Pasien</span>
                            <span class="inline-block mt-0.5 px-2.5 py-1 bg-emerald-600 text-white text-xs font-bold rounded-lg" x-text="myQueue.type">
                                BPJS Kesehatan
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-emerald-200/60 space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Poli Tujuan:</span>
                            <span class="font-bold text-gray-900" x-text="myQueue.poli">Poli Umum</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Dokter:</span>
                            <span class="font-bold text-gray-900" x-text="myQueue.doctor">dr. Rina Kusuma</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Ruangan:</span>
                            <span class="font-semibold text-emerald-700" x-text="myQueue.ruang">Ruang 101 (Lt. 1)</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Realtime Queue Insights & Action -->
                <div class="lg:col-span-7 flex flex-col justify-between h-full space-y-5">
                    <!-- 3 Stats Metric Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="bg-gray-50 rounded-2xl p-3.5 border border-gray-100 text-center">
                            <span class="text-xs text-gray-500 block font-medium">Sedang Dilayani</span>
                            <span class="text-xl font-extrabold text-gray-900 mt-1 block" x-text="myQueue.current_serving">A-012</span>
                            <span class="text-[10px] text-gray-400">Di Ruang 101</span>
                        </div>

                        <div class="bg-amber-50/70 rounded-2xl p-3.5 border border-amber-100 text-center">
                            <span class="text-xs text-amber-700 block font-semibold">Sisa Menunggu</span>
                            <span class="text-xl font-extrabold text-amber-900 mt-1 block">
                                <span x-text="myQueue.waiting_ahead">2</span> Pasien
                            </span>
                            <span class="text-[10px] text-amber-700">Di depan Anda</span>
                        </div>

                        <div class="bg-emerald-50/70 rounded-2xl p-3.5 border border-emerald-100 text-center">
                            <span class="text-xs text-emerald-700 block font-semibold">Estimasi Dipanggil</span>
                            <span class="text-base font-extrabold text-emerald-900 mt-1 block" x-text="myQueue.estimated_time">~10:15 WIB</span>
                            <span class="text-[10px] text-emerald-600 font-medium">Perkiraan waktu</span>
                        </div>
                    </div>

                    <!-- Progress Step Indicator -->
                    <div class="bg-white rounded-2xl p-4 border border-gray-100">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-3">Tahapan Antrean</span>
                        <div class="relative flex items-center justify-between">
                            <div class="absolute left-4 right-4 top-3.5 h-0.5 bg-gray-200 -z-0"></div>
                            
                            <!-- Step 1 -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shadow-sm">✓</div>
                                <span class="text-[11px] font-semibold text-gray-800 mt-1">Daftar</span>
                            </div>

                            <!-- Step 2 -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold shadow-sm"
                                     :class="myQueue.status === 'Menunggu' ? 'bg-amber-500 text-white ring-4 ring-amber-100' : 'bg-emerald-600 text-white'">
                                    <span x-text="myQueue.status === 'Menunggu' ? '2' : '✓'">2</span>
                                </div>
                                <span class="text-[11px] font-semibold mt-1" :class="myQueue.status === 'Menunggu' ? 'text-amber-700 font-bold' : 'text-gray-700'">Menunggu</span>
                            </div>

                            <!-- Step 3 -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold shadow-sm"
                                     :class="myQueue.status === 'Dipanggil' ? 'bg-emerald-600 text-white ring-4 ring-emerald-200 animate-pulse' : (myQueue.status === 'Selesai' ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-500')">
                                    <span x-text="myQueue.status === 'Selesai' ? '✓' : '3'">3</span>
                                </div>
                                <span class="text-[11px] font-semibold mt-1" :class="myQueue.status === 'Dipanggil' ? 'text-emerald-700 font-bold' : 'text-gray-500'">Dipanggil</span>
                            </div>

                            <!-- Step 4 -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold"
                                     :class="myQueue.status === 'Selesai' ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-500'">
                                    <span x-text="myQueue.status === 'Selesai' ? '✓' : '4'">4</span>
                                </div>
                                <span class="text-[11px] font-semibold mt-1" :class="myQueue.status === 'Selesai' ? 'text-emerald-700 font-bold' : 'text-gray-500'">Selesai</span>
                            </div>
                        </div>
                    </div>

                    <!-- Call To Actions -->
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <button @click="showQueueDetailModal = true" 
                                class="w-full sm:flex-1 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 active:scale-98 text-white rounded-xl font-bold text-sm shadow-sm transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>Lihat Detail Antrean</span>
                        </button>
                        <a href="{{ route('antrian.index') }}" 
                           class="w-full sm:w-auto py-3 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold text-sm transition-colors text-center">
                            Daftar Antrian Klinik
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             3. JADWAL DOKTER & 4. PENGINGAT (2-COLUMN RESPONSIVE LAYOUT)
             ==================================================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- LEFT: 3. JADWAL DOKTER RELEVAN -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-7 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col justify-between">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-lg">
                                🩺
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Jadwal Praktik Dokter</h3>
                                <p class="text-xs text-gray-500">Jadwal dokter yang relevan dengan kunjungan Anda.</p>
                            </div>
                        </div>

                        <!-- Schedule Filter Pills -->
                        <div class="flex items-center gap-1 bg-gray-50 p-1 rounded-xl border border-gray-200/70 text-xs font-semibold overflow-x-auto">
                            <template x-for="f in ['Semua', 'Hari Ini', 'Umum', 'Gigi', 'Anak']" :key="f">
                                <button @click="scheduleFilter = f"
                                        :class="scheduleFilter === f ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-500 hover:text-gray-900'"
                                        class="px-2.5 py-1 rounded-lg transition-all"
                                        x-text="f">
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Doctors List Cards -->
                    <div class="mt-4 space-y-3">
                        <template x-for="doc in filteredDoctorSchedules" :key="doc.id">
                            <div class="p-4 rounded-2xl border border-gray-100 hover:border-emerald-200 bg-gray-50/40 hover:bg-emerald-50/20 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center font-extrabold text-sm shadow-sm flex-shrink-0"
                                         :class="doc.avatar_color">
                                        <span x-text="doc.name.replace('dr. ', '').replace('drg. ', '').substring(0,2).toUpperCase()">DR</span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-bold text-sm text-gray-900" x-text="doc.name">dr. Rina Kusuma</h4>
                                            <!-- Doctor Status Badge -->
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                                  :class="{
                                                      'bg-emerald-100 text-emerald-800': doc.status === 'Tersedia',
                                                      'bg-blue-100 text-blue-800 animate-pulse': doc.status === 'Sedang Praktik',
                                                      'bg-amber-100 text-amber-800': doc.status === 'Libur',
                                                      'bg-rose-100 text-rose-800': doc.status === 'Dibatalkan'
                                                  }"
                                                  x-text="doc.status">
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            <span class="font-medium text-emerald-700" x-text="doc.poli">Poli Umum</span> • 
                                            <span x-text="doc.room">Ruang 101</span>
                                        </p>
                                        <div class="flex items-center gap-3 mt-1.5 text-xs text-gray-600">
                                            <span class="inline-flex items-center gap-1 font-semibold text-gray-700">
                                                🗓️ <span x-text="doc.day">Hari Ini</span>
                                            </span>
                                            <span>•</span>
                                            <span class="inline-flex items-center gap-1">
                                                ⏰ <span x-text="doc.time">08:00 - 14:00 WIB</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between sm:flex-col sm:items-end gap-2 border-t sm:border-t-0 pt-2 sm:pt-0 border-gray-100">
                                    <div class="text-left sm:text-right">
                                        <span class="text-[10px] text-gray-400 block font-medium">Sisa Kuota</span>
                                        <span class="text-xs font-bold"
                                              :class="doc.quota_remaining > 0 ? 'text-gray-800' : 'text-rose-600'"
                                              x-text="doc.quota_remaining > 0 ? doc.quota_remaining + ' Pasien' : 'Penuh / Tutup'">
                                            8 Pasien
                                        </span>
                                    </div>
                                    <template x-if="doc.status === 'Tersedia' || doc.status === 'Sedang Praktik'">
                                        <a href="{{ route('antrian.detail') }}" 
                                           class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white rounded-xl text-xs font-bold transition-colors">
                                            Daftar
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                    <span class="text-gray-400">Menampilkan jadwal dokter terdaftar</span>
                    <a href="{{ route('jadwal.index') }}" class="font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        Lihat Seluruh Jadwal Dokter &rarr;
                    </a>
                </div>
            </div>

            <!-- RIGHT: 4. PENGINGAT (JADWAL KONTROL & PEMERIKSAAN) -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-7 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg">
                                🔔
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Pengingat Saya</h3>
                                <p class="text-xs text-gray-500">Jadwal kontrol & pemeriksaan medis Anda.</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800" x-text="reminders.length + ' Agenda'">
                            2 Agenda
                        </span>
                    </div>

                    <!-- Reminder Cards List -->
                    <div class="mt-4 space-y-3.5">
                        <template x-for="item in reminders" :key="item.id">
                            <div class="p-4 rounded-2xl border border-gray-100 bg-gradient-to-br from-white to-gray-50/80 hover:border-amber-200 transition-all">
                                <div class="flex items-start justify-between gap-2">
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md border uppercase"
                                          :class="item.badge_bg"
                                          x-text="item.type">
                                        Kontrol Rutin
                                    </span>
                                    <span class="text-[11px] font-semibold text-amber-700 flex items-center gap-1">
                                        ⏱️ <span x-text="item.days_left">4 hari lagi</span>
                                    </span>
                                </div>

                                <h4 class="font-bold text-sm text-gray-900 mt-2" x-text="item.title">
                                    Kontrol Rutin Hipertensi
                                </h4>

                                <div class="mt-2 space-y-1 text-xs text-gray-600">
                                    <div class="flex items-center gap-1.5 font-medium">
                                        <span>📅</span>
                                        <span class="text-gray-900 font-semibold" x-text="item.date">Kamis, 20 Agustus 2026</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span>⏰</span>
                                        <span x-text="item.time">09:00 - 11:00 WIB</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span>👨‍⚕️</span>
                                        <span x-text="item.doctor">dr. Rina Kusuma</span> (<span x-text="item.poli">Poli Umum</span>)
                                    </div>
                                </div>

                                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                                    <span class="text-[11px] text-gray-400 truncate max-w-[180px]" x-text="item.location">Klinik LPSK Lt. 1</span>
                                    <button @click="openReminderDetail(item)"
                                            class="px-3 py-1.5 bg-gray-900 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Small helper banner -->
                <div class="mt-4 p-3 bg-emerald-50/70 rounded-2xl border border-emerald-100 flex items-center gap-3">
                    <span class="text-lg">💡</span>
                    <p class="text-xs text-emerald-900 leading-tight">
                        Butuh perubahan jadwal kontrol? Hubungi bagian registrasi klinik minimal 1 hari sebelumnya.
                    </p>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             5. NOTIFIKASI TERBARU (MULTI-CATEGORY LIST)
             ==================================================================== -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg">
                        📬
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-gray-900">Notifikasi Terbaru</h3>
                            <template x-if="unreadNotificationCount > 0">
                                <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-xs font-bold rounded-full"
                                      x-text="unreadNotificationCount + ' Belum Dibaca'">
                                    2 Belum Dibaca
                                </span>
                            </template>
                        </div>
                        <p class="text-xs text-gray-500">Informasi status antrean, jadwal dokter, kontrol, dan edukasi klinik.</p>
                    </div>
                </div>

                <!-- Action & Filter Pills -->
                <div class="flex items-center gap-2 flex-wrap">
                    <div class="flex items-center gap-1 bg-gray-50 p-1 rounded-xl border border-gray-200/70 text-xs font-semibold">
                        <template x-for="nf in ['Semua', 'Belum Dibaca', 'Antrian', 'Jadwal']" :key="nf">
                            <button @click="notificationFilter = nf"
                                    :class="notificationFilter === nf ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-500 hover:text-gray-900'"
                                    class="px-2.5 py-1 rounded-lg transition-all"
                                    x-text="nf">
                            </button>
                        </template>
                    </div>

                    <template x-if="unreadNotificationCount > 0">
                        <button @click="markAllAsRead()" 
                                class="text-xs font-bold text-emerald-600 hover:text-emerald-800 hover:underline px-2 py-1">
                            Tandai Semua Dibaca
                        </button>
                    </template>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="mt-4 space-y-2.5">
                <template x-for="item in filteredNotifications" :key="item.id">
                    <div @click="markAsRead(item)"
                         class="p-4 rounded-2xl border transition-all cursor-pointer flex items-start justify-between gap-3"
                         :class="!item.read ? 'bg-emerald-50/40 border-emerald-200/80 hover:bg-emerald-50/70' : 'bg-white border-gray-100 hover:bg-gray-50'">
                        
                        <div class="flex items-start gap-3.5">
                            <!-- Category Icon -->
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold flex-shrink-0 mt-0.5"
                                 :class="{
                                     'bg-emerald-100 text-emerald-700': item.category === 'antrian',
                                     'bg-amber-100 text-amber-700': item.category === 'jadwal',
                                     'bg-blue-100 text-blue-700': item.category === 'kontrol',
                                     'bg-purple-100 text-purple-700': item.category === 'germas',
                                     'bg-gray-100 text-gray-700': item.category === 'klinik'
                                 }">
                                <span x-text="item.category === 'antrian' ? '🎫' : (item.category === 'jadwal' ? '📅' : (item.category === 'kontrol' ? '🔔' : (item.category === 'germas' ? '🍏' : '📢')))"></span>
                            </div>

                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-sm font-bold" :class="!item.read ? 'text-gray-900 font-extrabold' : 'text-gray-700'" x-text="item.title">
                                        Judul Notifikasi
                                    </h4>
                                    <span class="text-[10px] font-semibold px-2 py-0.2 rounded-md bg-gray-100 text-gray-600" x-text="item.badge">
                                        Kategori
                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 mt-1 leading-relaxed" x-text="item.message">
                                    Isi pesan notifikasi...
                                </p>
                                <span class="text-[10px] text-gray-400 mt-1 block font-medium" x-text="item.time">10 menit lalu</span>
                            </div>
                        </div>

                        <!-- Read Status Indicator -->
                        <div class="flex items-center flex-shrink-0 self-center">
                            <template x-if="!item.read">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></span>
                            </template>
                            <template x-if="item.read">
                                <span class="text-xs text-gray-300">✓✓</span>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- ====================================================================
             6. EDUKASI KESEHATAN (GERMAS CARDS)
             ==================================================================== -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-5 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg">
                        🥗
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-gray-900">Edukasi Kesehatan GERMAS</h3>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Kemenkes RI
                            </span>
                        </div>
                        <p class="text-xs text-gray-500">Gerakan Masyarakat Hidup Sehat untuk tubuh bugar dan bebas penyakit.</p>
                    </div>
                </div>
                <span class="text-xs text-gray-400 font-medium hidden sm:block">Artikel & Tips Harian</span>
            </div>

            <!-- Germas Grid Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                <template x-for="art in germasArticles" :key="art.id">
                    <div class="rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-md transition-all duration-200 bg-white flex flex-col justify-between p-5 group">
                        <div>
                            <!-- Header tag & read time -->
                            <div class="flex items-center justify-between text-[11px] mb-3">
                                <span class="font-bold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700" x-text="art.tag">
                                    Kebugaran
                                </span>
                                <span class="text-gray-400" x-text="art.read_time">3 menit baca</span>
                            </div>

                            <!-- Decorative Gradient Pill Icon -->
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br flex items-center justify-center text-white text-lg font-bold shadow-sm mb-3"
                                 :class="art.accent_color">
                                <span x-text="art.icon === 'activity' ? '🏃' : (art.icon === 'nutrition' ? '🥦' : (art.icon === 'checkup' ? '🩺' : '🧼'))"></span>
                            </div>

                            <h4 class="font-bold text-sm text-gray-900 group-hover:text-emerald-700 transition-colors leading-snug" x-text="art.title">
                                Judul Edukasi
                            </h4>
                            <p class="text-xs text-gray-500 mt-2 line-clamp-3 leading-relaxed" x-text="art.summary">
                                Ringkasan artikel edukasi...
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <button @click="openGermasDetail(art)" 
                                    class="w-full py-2 bg-gray-50 hover:bg-emerald-600 text-gray-700 hover:text-white rounded-xl text-xs font-bold transition-all text-center flex items-center justify-center gap-1 group-hover:bg-emerald-600 group-hover:text-white">
                                <span>Baca Edukasi</span>
                                <span>&rarr;</span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- ====================================================================
             7. MODAL: DETAIL ANTRIAN SAYA (QR & PETUNJUK KEDATANGAN)
             ==================================================================== -->
        <div x-show="showQueueDetailModal" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
             style="display: none;">
            
            <div @click.away="showQueueDetailModal = false"
                 class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-gray-100 relative">
                
                <button @click="showQueueDetailModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <!-- Ticket Header -->
                <div class="text-center pt-2">
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Tiket Antrean Pasien</span>
                    <h3 class="text-lg font-extrabold text-gray-900 mt-0.5">Klinik Pratama LPSK</h3>
                    <p class="text-xs text-gray-400">Tunjukkan barcode ini kepada petugas jika diminta</p>
                </div>

                <!-- Big Queue Number & QR -->
                <div class="my-5 p-5 bg-gradient-to-b from-emerald-50 to-teal-50/30 rounded-2xl border border-emerald-100 text-center">
                    <span class="text-xs text-emerald-800 font-bold block">Nomor Antrean Anda</span>
                    <div class="text-5xl font-black text-emerald-700 tracking-wider my-2" x-text="myQueue.queue_number">A-014</div>
                    
                    <!-- QR Code -->
                    <div class="flex justify-center my-3">
                        <div class="bg-white p-2.5 rounded-xl border border-gray-200 shadow-sm">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=SATUSEHAT-LPSK-A014-BUDISANTOSO&format=png&color=059669" 
                                 alt="QR Antrean" 
                                 class="w-36 h-36">
                        </div>
                    </div>

                    <p class="text-xs font-bold text-gray-800" x-text="myQueue.poli">Poli Umum</p>
                    <p class="text-xs text-gray-500" x-text="myQueue.doctor">dr. Rina Kusuma</p>
                </div>

                <!-- Ticket Details List -->
                <div class="space-y-2 text-xs border-t border-b border-gray-100 py-3 text-gray-600">
                    <div class="flex justify-between">
                        <span>Nama Pasien:</span>
                        <strong class="text-gray-900" x-text="patient.name">Budi Santoso</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Nomor RM:</span>
                        <span class="font-mono text-gray-900" x-text="patient.no_rm">RM-2023-0142</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Ruangan:</span>
                        <strong class="text-emerald-700" x-text="myQueue.ruang">Ruang 101 (Lt. 1)</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Jam Registrasi:</span>
                        <span x-text="myQueue.registered_at">08:45 WIB</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Status Saat Ini:</span>
                        <strong class="text-amber-700" x-text="myQueue.status">Menunggu</strong>
                    </div>
                </div>

                <div class="mt-5 flex gap-2">
                    <a href="{{ route('antrian.detail') }}" 
                       class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-center font-bold text-sm rounded-xl shadow-sm transition-all">
                        Halaman Tiket Lengkap
                    </a>
                    <button @click="showQueueDetailModal = false" 
                            class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm rounded-xl transition-all">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             8. MODAL: DETAIL PENGINGAT JADWAL KONTROL
             ==================================================================== -->
        <div x-show="showReminderModal" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
             style="display: none;">
            
            <div @click.away="showReminderModal = false"
                 class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-gray-100 relative">
                
                <button @click="showReminderModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <template x-if="selectedReminder">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl font-bold">
                                🔔
                            </div>
                            <div>
                                <span class="text-xs font-bold text-amber-700 uppercase" x-text="selectedReminder.type">Kontrol Rutin</span>
                                <h3 class="text-lg font-bold text-gray-900" x-text="selectedReminder.title">Detail Pengingat</h3>
                            </div>
                        </div>

                        <div class="mt-5 space-y-3 bg-gray-50 p-4 rounded-2xl border border-gray-100 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal:</span>
                                <strong class="text-gray-900" x-text="selectedReminder.date">Kamis, 20 Agustus 2026</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Waktu Praktik:</span>
                                <strong class="text-gray-900" x-text="selectedReminder.time">09:00 - 11:00 WIB</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Dokter / Petugas:</span>
                                <strong class="text-emerald-700" x-text="selectedReminder.doctor">dr. Rina Kusuma</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Lokasi:</span>
                                <strong class="text-gray-900" x-text="selectedReminder.location">Klinik LPSK Lt. 1</strong>
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-amber-50/80 rounded-2xl border border-amber-200">
                            <h4 class="text-xs font-bold text-amber-900 uppercase">Petunjuk & Persiapan Pasien:</h4>
                            <p class="text-xs text-amber-800 mt-1 leading-relaxed" x-text="selectedReminder.notes"></p>
                        </div>

                        <div class="mt-6 flex gap-2">
                            <button @click="alert('Jadwal pengingat telah disinkronkan ke kalender perangkat Anda!'); showReminderModal = false;" 
                                    class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                                <span>📅 Tambah ke Kalender</span>
                            </button>
                            <button @click="showReminderModal = false" 
                                    class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm rounded-xl transition-all">
                                Tutup
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- ====================================================================
             9. MODAL: BACA ARTIKEL EDUKASI GERMAS LENGKAP
             ==================================================================== -->
        <div x-show="showGermasModal" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
             style="display: none;">
            
            <div @click.away="showGermasModal = false"
                 class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 relative max-h-[90vh] flex flex-col justify-between">
                
                <button @click="showGermasModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <template x-if="selectedGermas">
                    <div class="overflow-y-auto pr-1">
                        <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200" x-text="selectedGermas.category">Kategori</span>
                            <span>•</span>
                            <span class="text-gray-400" x-text="selectedGermas.read_time">3 menit baca</span>
                        </div>

                        <h3 class="text-xl font-extrabold text-gray-900 mt-2" x-text="selectedGermas.title">Judul Edukasi Germas</h3>

                        <div class="mt-4 pt-4 border-t border-gray-100 leading-relaxed" x-html="selectedGermas.content">
                            <!-- Injected Germas Content -->
                        </div>
                    </div>
                </template>

                <div class="mt-6 pt-4 border-t border-gray-100 flex justify-end">
                    <button @click="showGermasModal = false" 
                            class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all">
                        Tutup Bacaan
                    </button>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             10. MODAL / DRAWER: PUSAT NOTIFIKASI PASIEN
             ==================================================================== -->
        <div x-show="showNotificationModal" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
             style="display: none;">
            
            <div @click.away="showNotificationModal = false"
                 class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 relative max-h-[85vh] flex flex-col justify-between">
                
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-gray-900">Pusat Notifikasi Pasien</h3>
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full" x-text="unreadNotificationCount + ' Baru'">
                                2 Baru
                            </span>
                        </div>
                        <button @click="showNotificationModal = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-full hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="mt-4 space-y-2.5 max-h-[55vh] overflow-y-auto pr-1">
                        <template x-for="item in notifications" :key="item.id">
                            <div @click="markAsRead(item)"
                                 class="p-3.5 rounded-2xl border transition-all cursor-pointer flex items-start justify-between gap-2"
                                 :class="!item.read ? 'bg-emerald-50/50 border-emerald-200' : 'bg-gray-50 border-gray-100'">
                                <div class="flex items-start gap-3">
                                    <span class="text-lg mt-0.5" x-text="item.category === 'antrian' ? '🎫' : (item.category === 'jadwal' ? '📅' : (item.category === 'kontrol' ? '🔔' : '📢'))"></span>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-900" x-text="item.title">Judul</h4>
                                        <p class="text-xs text-gray-600 mt-0.5 leading-relaxed" x-text="item.message">Pesan</p>
                                        <span class="text-[10px] text-gray-400 mt-1 block" x-text="item.time">Waktu</span>
                                    </div>
                                </div>
                                <template x-if="!item.read">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0 mt-1.5"></span>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                    <button @click="markAllAsRead()" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                        Tandai Semua Dibaca
                    </button>
                    <button @click="showNotificationModal = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- ====================================================================
         JAVASCRIPT STATE & METHODS (API-READY)
         ==================================================================== -->
    <script>
        function patientDashboard() {
            return {
                /* 1. PATIENT PROFILE STATE (API: /api/v1/patient/profile) */
                patient: {
                    name: 'Budi Santoso',
                    no_rm: 'RM-2023-0142',
                    nik: '3174091204890001',
                    status_bpjs: 'BPJS Aktif (Faskes 1)'
                },

                get greetingTime() {
                    const hour = new Date().getHours();
                    if (hour < 11) return 'Selamat Pagi';
                    if (hour < 15) return 'Selamat Siang';
                    if (hour < 18) return 'Selamat Sore';
                    return 'Selamat Malam';
                },

                /* 2. ANTRIAN SAYA STATE (API: /api/v1/patient/queues/active) */
                myQueue: {
                    hasActiveQueue: true,
                    queue_number: 'A-014',
                    poli: 'Poli Umum',
                    doctor: 'dr. Rina Kusuma',
                    ruang: 'Ruang Pemeriksaan 101 (Lt. 1)',
                    status: 'Menunggu', // 'Menunggu' | 'Dipanggil' | 'Selesai'
                    current_serving: 'A-012',
                    waiting_ahead: 2,
                    estimated_time: '10:15 WIB (~15 Menit)',
                    registered_at: '08:45 WIB',
                    type: 'BPJS Kesehatan',
                    keluhan: 'Kontrol rutin tensi dan konsultasi batuk ringan'
                },

                showQueueDetailModal: false,
                soundEnabled: true,

                triggerAudioAlert() {
                    if (!this.soundEnabled) return;
                    try {
                        let ctx = new (window.AudioContext || window.webkitAudioContext)();
                        let osc1 = ctx.createOscillator();
                        let gain1 = ctx.createGain();
                        osc1.connect(gain1);
                        gain1.connect(ctx.destination);
                        osc1.type = 'sine';
                        osc1.frequency.setValueAtTime(587.33, ctx.currentTime);
                        gain1.gain.setValueAtTime(0.2, ctx.currentTime);
                        gain1.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.35);
                        osc1.start(ctx.currentTime);
                        osc1.stop(ctx.currentTime + 0.35);

                        let osc2 = ctx.createOscillator();
                        let gain2 = ctx.createGain();
                        osc2.connect(gain2);
                        gain2.connect(ctx.destination);
                        osc2.type = 'sine';
                        osc2.frequency.setValueAtTime(880.00, ctx.currentTime + 0.2);
                        gain2.gain.setValueAtTime(0.25, ctx.currentTime + 0.2);
                        gain2.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.6);
                        osc2.start(ctx.currentTime + 0.2);
                        osc2.stop(ctx.currentTime + 0.6);
                    } catch(e) {}
                },

                setQueueStatus(status) {
                    this.myQueue.status = status;
                    if (status === 'Dipanggil') {
                        this.myQueue.waiting_ahead = 0;
                        this.myQueue.current_serving = this.myQueue.queue_number;
                        this.triggerAudioAlert();
                        this.addNotification({
                            id: Date.now(),
                            category: 'antrian',
                            title: 'Giliran Anda Tiba!',
                            message: 'Nomor ' + this.myQueue.queue_number + ' dipanggil menuju ' + this.myQueue.ruang + ' (' + this.myQueue.doctor + ').',
                            time: 'Baru saja',
                            read: false,
                            badge: 'Panggilan'
                        });
                    } else if (status === 'Menunggu') {
                        this.myQueue.waiting_ahead = 2;
                        this.myQueue.current_serving = 'A-012';
                    } else if (status === 'Selesai') {
                        this.myQueue.waiting_ahead = 0;
                    }
                },

                /* 3. JADWAL DOKTER RELEVAN (API: /api/v1/patient/doctor-schedules) */
                scheduleFilter: 'Semua',
                doctorSchedules: [
                    {
                        id: 1,
                        name: 'dr. Rina Kusuma',
                        specialty: 'Dokter Umum',
                        poli: 'Poli Umum',
                        room: 'Ruang 101',
                        day: 'Hari Ini (Senin)',
                        time: '08:00 - 14:00 WIB',
                        status: 'Tersedia',
                        quota_remaining: 8,
                        total_quota: 30,
                        avatar_color: 'bg-emerald-500 text-white'
                    },
                    {
                        id: 2,
                        name: 'drg. Hendra Pratama',
                        specialty: 'Dokter Gigi & Mulut',
                        poli: 'Poli Gigi',
                        room: 'Ruang 103',
                        day: 'Hari Ini (Senin)',
                        time: '09:00 - 15:00 WIB',
                        status: 'Sedang Praktik',
                        quota_remaining: 4,
                        total_quota: 20,
                        avatar_color: 'bg-blue-500 text-white'
                    },
                    {
                        id: 3,
                        name: 'dr. Sari Dewi, Sp.A',
                        specialty: 'Spesialis Anak',
                        poli: 'Poli Anak',
                        room: 'Ruang 201',
                        day: 'Hari Ini (Senin)',
                        time: '13:00 - 17:00 WIB',
                        status: 'Tersedia',
                        quota_remaining: 12,
                        total_quota: 25,
                        avatar_color: 'bg-purple-500 text-white'
                    },
                    {
                        id: 4,
                        name: 'dr. Budi Santoso, Sp.PD',
                        specialty: 'Spesialis Penyakit Dalam',
                        poli: 'Poli Penyakit Dalam',
                        room: 'Ruang 204',
                        day: 'Besok (Selasa)',
                        time: '10:00 - 16:00 WIB',
                        status: 'Tersedia',
                        quota_remaining: 15,
                        total_quota: 20,
                        avatar_color: 'bg-indigo-500 text-white'
                    },
                    {
                        id: 5,
                        name: 'drg. Maya Putri, Sp.KG',
                        specialty: 'Spesialis Konservasi Gigi',
                        poli: 'Poli Gigi',
                        room: 'Ruang 104',
                        day: 'Besok (Selasa)',
                        time: '13:00 - 17:00 WIB',
                        status: 'Libur',
                        quota_remaining: 0,
                        total_quota: 15,
                        avatar_color: 'bg-rose-500 text-white'
                    },
                    {
                        id: 6,
                        name: 'dr. Agus Setiawan, Sp.THT',
                        specialty: 'Spesialis THT-KL',
                        poli: 'Poli THT',
                        room: 'Ruang 202',
                        day: 'Rabu',
                        time: '09:00 - 13:00 WIB',
                        status: 'Dibatalkan',
                        quota_remaining: 0,
                        total_quota: 15,
                        avatar_color: 'bg-amber-500 text-white'
                    }
                ],

                get filteredDoctorSchedules() {
                    if (this.scheduleFilter === 'Semua') return this.doctorSchedules;
                    if (this.scheduleFilter === 'Hari Ini') return this.doctorSchedules.filter(d => d.day.includes('Hari Ini'));
                    return this.doctorSchedules.filter(d => d.poli.toLowerCase().includes(this.scheduleFilter.toLowerCase()));
                },

                /* 4. PENGINGAT JADWAL KONTROL (API: /api/v1/patient/reminders) */
                selectedReminder: null,
                showReminderModal: false,
                reminders: [
                    {
                        id: 'REM-01',
                        type: 'Kontrol Rutin',
                        title: 'Kontrol Rutin Hipertensi & Evaluasi Obat',
                        poli: 'Poli Umum',
                        doctor: 'dr. Rina Kusuma',
                        date: 'Kamis, 20 Agustus 2026',
                        time: '09:00 - 11:00 WIB',
                        location: 'Klinik LPSK - Lt. 1 Ruang 101',
                        notes: 'Bawa kartu BPJS, buku riwayat tensi mandiri 7 hari terakhir, dan obat yang sedang dikonsumsi.',
                        urgency: 'Penting',
                        badge_bg: 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        days_left: '4 hari lagi'
                    },
                    {
                        id: 'REM-02',
                        type: 'Pemeriksaan Lab',
                        title: 'Pemeriksaan Profil Lipid & Gula Darah Puasa',
                        poli: 'Unit Laboratorium',
                        doctor: 'dr. Analis Lab / dr. Budi S.',
                        date: 'Senin, 24 Agustus 2026',
                        time: '07:30 - 09:00 WIB',
                        location: 'Klinik LPSK - Laboratorium Lt. 1',
                        notes: 'Wajib puasa 10-12 jam sebelum tes (hanya boleh minum air putih). Hindari makan berat malam sebelumnya.',
                        urgency: 'Persiapan Puasa',
                        badge_bg: 'bg-blue-50 text-blue-700 border-blue-200',
                        days_left: '8 hari lagi'
                    }
                ],
                openReminderDetail(item) {
                    this.selectedReminder = item;
                    this.showReminderModal = true;
                },

                /* 5. NOTIFIKASI TERBARU (API: /api/v1/patient/notifications) */
                showNotificationModal: false,
                notificationFilter: 'Semua',
                notifications: [
                    {
                        id: 101,
                        category: 'antrian',
                        title: 'Nomor Antrian Dikonfirmasi',
                        message: 'Nomor antrian A-014 di Poli Umum telah terbit. Silakan tunggu di ruang tunggu lantai 1.',
                        time: '15 menit lalu',
                        read: false,
                        badge: 'Antrian'
                    },
                    {
                        id: 102,
                        category: 'jadwal',
                        title: 'Info Dokter: dr. Agus Setiawan Berhalangan',
                        message: 'Jadwal praktik dr. Agus Setiawan, Sp.THT pada hari Rabu, 19 Agustus 2026 dibatalkan karena dinas luar.',
                        time: '1 jam lalu',
                        read: false,
                        badge: 'Jadwal Dokter'
                    },
                    {
                        id: 103,
                        category: 'kontrol',
                        title: 'Pengingat Jadwal Kontrol Hipertensi',
                        message: 'Jadwal kontrol rutin Anda dengan dr. Rina Kusuma dijadwalkan pada Kamis, 20 Agustus 2026.',
                        time: 'Kemarin',
                        read: true,
                        badge: 'Pengingat'
                    },
                    {
                        id: 104,
                        category: 'klinik',
                        title: 'Layanan Vaksinasi Influenza Tersedia',
                        message: 'Klinik LPSK kini melayani paket vaksinasi influenza tahunan bagi seluruh keluarga pegawai & umum.',
                        time: '2 hari lalu',
                        read: true,
                        badge: 'Info Klinik'
                    },
                    {
                        id: 105,
                        category: 'germas',
                        title: 'Tips Germas: 30 Menit Bergerak Setiap Hari',
                        message: 'Cukup luangkan waktu 30 menit jalan santai atau senam ringan untuk menjaga kebugaran jantung.',
                        time: '3 hari lalu',
                        read: true,
                        badge: 'Edukasi Germas'
                    }
                ],
                get unreadNotificationCount() {
                    return this.notifications.filter(n => !n.read).length;
                },
                get filteredNotifications() {
                    if (this.notificationFilter === 'Semua') return this.notifications;
                    if (this.notificationFilter === 'Belum Dibaca') return this.notifications.filter(n => !n.read);
                    return this.notifications.filter(n => n.category === this.notificationFilter.toLowerCase());
                },
                markAsRead(item) {
                    item.read = true;
                },
                markAllAsRead() {
                    this.notifications.forEach(n => n.read = true);
                },
                addNotification(item) {
                    this.notifications.unshift(item);
                },

                /* 6. EDUKASI KESEHATAN GERMAS (API: /api/v1/patient/health-education) */
                selectedGermas: null,
                showGermasModal: false,
                germasArticles: [
                    {
                        id: 'GERMAS-01',
                        category: 'Aktivitas Fisik',
                        title: 'Aktivitas Fisik 30 Menit Setiap Hari',
                        summary: 'Tingkatkan metabolisme tubuh, kurangi stres, dan jaga kesehatan kardiovaskular dengan olahraga rutin minimal 150 menit/minggu.',
                        read_time: '3 menit baca',
                        tag: 'Kebugaran',
                        accent_color: 'from-emerald-500 to-teal-600',
                        icon: 'activity',
                        content: '<p class="mb-3 text-gray-600 leading-relaxed">Gerakan Masyarakat Hidup Sehat (GERMAS) mengajak setiap individu untuk melakukan aktivitas fisik minimal <strong>30 menit setiap hari</strong>. Aktivitas dapat berupa jalan cepat, bersepeda santai, naik-turun tangga, atau senam peregangan.</p><h4 class="font-bold text-gray-900 mt-4 mb-2 text-sm">Manfaat Utama:</h4><ul class="list-disc pl-5 space-y-1 text-sm text-gray-600"><li>Menstabilkan tekanan darah dan kadar gula darah</li><li>Memperkuat otot jantung dan sirkulasi peredaran darah</li><li>Meningkatkan daya tahan tubuh dan imunitas</li><li>Memperbaiki kualitas tidur dan mengurangi stres</li></ul><div class="mt-4 p-3 bg-emerald-50 rounded-xl border border-emerald-200 text-xs text-emerald-800">💡 <strong>Tips:</strong> Luangkan waktu berdiri dan peregangan setiap 60 menit bekerja.</div>'
                    },
                    {
                        id: 'GERMAS-02',
                        category: 'Gizi Seimbang',
                        title: 'Terapkan Konsep Isi Piringku Setiap Makan',
                        summary: 'Pola makan seimbang: 1/2 piring sayur & buah, 1/4 piring karbohidrat kompleks, dan 1/4 piring lauk berprotein tinggi.',
                        read_time: '2 menit baca',
                        tag: 'Nutrisi Sehat',
                        accent_color: 'from-blue-500 to-indigo-600',
                        icon: 'nutrition',
                        content: '<p class="mb-3 text-gray-600 leading-relaxed">Panduan <strong>"Isi Piringku"</strong> dari Kemenkes RI menekankan porsi seimbang dan pembatasan konsumsi GGL (Gula, Garam, Lemak).</p><h4 class="font-bold text-gray-900 mt-4 mb-2 text-sm">Komposisi 1 Piring:</h4><ul class="list-disc pl-5 space-y-1 text-sm text-gray-600"><li><strong>50% Piring:</strong> Sayuran segar dan aneka buah-buahan</li><li><strong>25% Piring:</strong> Makanan pokok (nasi merah, kentang, jagung)</li><li><strong>25% Piring:</strong> Lauk-pauk berprotein (ikan, telur, tahu, tempe, ayam)</li></ul><div class="mt-4 p-3 bg-blue-50 rounded-xl border border-blue-200 text-xs text-blue-800">💧 Minum air putih minimal <strong>8 gelas sehari (2 Liter)</strong>.</div>'
                    },
                    {
                        id: 'GERMAS-03',
                        category: 'Deteksi Dini',
                        title: 'Cek Kesehatan Berkala (CERDIK)',
                        summary: 'Deteksi dini risiko hipertensi, diabetes, dan kolesterol dengan pemeriksaan tensi, gula darah, dan lingkar perut secara teratur.',
                        read_time: '4 menit baca',
                        tag: 'Pencegahan',
                        accent_color: 'from-purple-500 to-violet-600',
                        icon: 'checkup',
                        content: '<p class="mb-3 text-gray-600 leading-relaxed">Penyakit Tidak Menular (PTM) sering kali tidak bergejala di awal. Pemeriksaan berkala di faskes primer sangat krusial.</p><h4 class="font-bold text-gray-900 mt-4 mb-2 text-sm">Pemeriksaan Berkala yang Dianjurkan:</h4><ul class="list-disc pl-5 space-y-1 text-sm text-gray-600"><li>Cek Tekanan Darah (tiap 1 bulan)</li><li>Cek Gula Darah Sewaktu/Puasa (tiap 3-6 bulan)</li><li>Cek Profil Kolesterol & Asam Urat</li><li>Pengukuran Lingkar Perut & IMT</li></ul><div class="mt-4 p-3 bg-purple-50 rounded-xl border border-purple-200 text-xs text-purple-800">🏥 <strong>Klinik LPSK</strong> melayani skrining berkala PTM bagi seluruh pasien.</div>'
                    },
                    {
                        id: 'GERMAS-04',
                        category: 'Gaya Hidup',
                        title: 'Enyahkan Asap Rokok & Jaga Kebersihan',
                        summary: 'Ciptakan lingkungan keluarga bebas asap rokok, serta budayakan cuci tangan pakai sabun (CTPS) 6 langkah.',
                        read_time: '2 menit baca',
                        tag: 'Higienis',
                        accent_color: 'from-amber-500 to-orange-600',
                        icon: 'hygiene',
                        content: '<p class="mb-3 text-gray-600 leading-relaxed">Menghindari asap rokok aktif maupun pasif melindungi kesehatan saluran pernapasan anak dan keluarga.</p><h4 class="font-bold text-gray-900 mt-4 mb-2 text-sm">Langkah Higienitas Pribadi:</h4><ul class="list-disc pl-5 space-y-1 text-sm text-gray-600"><li>Cuci tangan pakai sabun selama 20-30 detik dengan air mengalir</li><li>Jaga ventilasi dan sirkulasi udara kamar & kantor</li><li>Istirahat dan tidur berkualitas 7-8 jam per hari</li></ul><div class="mt-4 p-3 bg-amber-50 rounded-xl border border-amber-200 text-xs text-amber-800">🚭 Rumah bebas asap rokok lindungi generasi sehat masa depan.</div>'
                    }
                ],
                openGermasDetail(article) {
                    this.selectedGermas = article;
                    this.showGermasModal = true;
                }
            };
        }
    </script>
</x-app-layout>
