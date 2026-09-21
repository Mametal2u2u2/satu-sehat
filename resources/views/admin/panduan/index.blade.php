<x-app-layout>
    <div x-data="{ activeTab: 'alur-pasien' }" class="space-y-6">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute -right-8 -bottom-8 w-60 h-60 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold border border-emerald-400/30 mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Pusat Bantuan & Panduan Sistem</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                        Panduan Operasional e-Klinik
                    </h1>
                    <p class="text-emerald-100/80 text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">
                        Dokumentasi ringkas alur kerja digital Satu Sehat LPSK mulai dari pendaftaran antrian pasien, pemeriksaan EMR medis, peresepan elektronik, hingga tata kelola data klinik.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/10 text-emerald-200 text-xs font-semibold backdrop-blur-md border border-white/10">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Versi Sistem v2.4 LPSK
                    </span>
                </div>
            </div>
        </div>

        <!-- Guide Category Navigation Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
            <button @click="activeTab = 'alur-pasien'" 
                    class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all whitespace-nowrap cursor-pointer flex items-center gap-2 border"
                    :class="activeTab === 'alur-pasien' ? 'bg-emerald-700 text-white border-emerald-700 shadow-sm shadow-emerald-800/20' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>1. Alur Pasien</span>
            </button>

            <button @click="activeTab = 'alur-dokter'" 
                    class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all whitespace-nowrap cursor-pointer flex items-center gap-2 border"
                    :class="activeTab === 'alur-dokter' ? 'bg-emerald-700 text-white border-emerald-700 shadow-sm shadow-emerald-800/20' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>2. Dokter & EMR Medis</span>
            </button>

            <button @click="activeTab = 'alur-farmasi'" 
                    class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all whitespace-nowrap cursor-pointer flex items-center gap-2 border"
                    :class="activeTab === 'alur-farmasi' ? 'bg-emerald-700 text-white border-emerald-700 shadow-sm shadow-emerald-800/20' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
                <span>3. Farmasi & E-Resep</span>
            </button>

            <button @click="activeTab = 'alur-admin'" 
                    class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all whitespace-nowrap cursor-pointer flex items-center gap-2 border"
                    :class="activeTab === 'alur-admin' ? 'bg-emerald-700 text-white border-emerald-700 shadow-sm shadow-emerald-800/20' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>4. Admin & Master Data</span>
            </button>

            <button @click="activeTab = 'keamanan'" 
                    class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all whitespace-nowrap cursor-pointer flex items-center gap-2 border"
                    :class="activeTab === 'keamanan' ? 'bg-emerald-700 text-white border-emerald-700 shadow-sm shadow-emerald-800/20' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>5. Keamanan & Backup</span>
            </button>
        </div>

        <!-- Tab 1: Alur Pasien -->
        <div x-show="activeTab === 'alur-pasien'" class="space-y-4">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-extrabold flex items-center justify-center">1</span>
                    Panduan Alur Pelayanan Pasien
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">A</div>
                        <h3 class="font-extrabold text-sm text-slate-900">Registrasi & Ambil Antrian</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pasien mendaftar via form registrasi atau Google Login. Masuk ke menu Antrian, pilih Poli tujuan (Poli Umum, Gigi, Anak), dan sistem otomatis menerbitkan tiket digital berkode QR.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">B</div>
                        <h3 class="font-extrabold text-sm text-slate-900">Pantau Nomor Antrian</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pasien dapat memantau estimasi jam panggilan dan jumlah sisa antrian di hadapan mereka secara real-time langsung melalui perangkat smartphone tanpa perlu berdesakan di ruang tunggu.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">C</div>
                        <h3 class="font-extrabold text-sm text-slate-900">Pemeriksaan & Resep Digital</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Saat nomor dipanggil, tunjukkan QR Code pada perawat. Setelah pemeriksaan dokter selesai, resep obat diteruskan otomatis ke unit farmasi untuk disiapkan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Alur Dokter & EMR Medis -->
        <div x-show="activeTab === 'alur-dokter'" class="space-y-4" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-800 text-xs font-extrabold flex items-center justify-center">2</span>
                    Panduan Dokter & Pengisian Rekam Medis (EMR)
                </h2>
                <div class="space-y-4">
                    <div class="p-5 rounded-2xl bg-teal-50/50 border border-teal-200/70 flex flex-col md:flex-row gap-4 items-start">
                        <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-extrabold text-sm text-teal-950">Pencatatan Rekam Medis Elektronik (SOAP)</h3>
                            <p class="text-xs text-teal-900/80 leading-relaxed">
                                Buka menu <strong>Rekam Medis (EMR)</strong> di sidebar. Pilih pasien aktif dan lakukan pencatatan data subjektif, objektif (tanda-tanda vital), asesmen diagnosa dengan kode ICD-10 resmi (contoh: J06.9 untuk ISPA, K29.7 untuk Gastritis), serta rencana terapi tindakan.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-teal-50/50 border border-teal-200/70 flex flex-col md:flex-row gap-4 items-start">
                        <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-extrabold text-sm text-teal-950">Bridging Integrasi SATUSEHAT Kemenkes</h3>
                            <p class="text-xs text-teal-900/80 leading-relaxed">
                                Sistem telah dilengkapi integrasi HL7 FHIR SATUSEHAT. Setelah resume medis disimpan, data Encounter & Condition dapat disinkronkan langsung ke server Kemenkes melalui modul SatuSehatService.
                            </p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-teal-50/50 border border-teal-200/70 flex flex-col md:flex-row gap-4 items-start">
                        <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-extrabold text-sm text-teal-950">Pembuatan E-Resep Instan</h3>
                            <p class="text-xs text-teal-900/80 leading-relaxed">
                                Klik tombol <strong>"Buat E-Resep"</strong> di menu Aksi Cepat atau bagian bawah pemeriksaan pasien. Pilih obat dari master sediaan klinik beserta aturan pakai (misal: 3x1 tablet setelah makan). Resep langsung diteruskan ke Apotek.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 3: Alur Farmasi & E-Resep -->
        <div x-show="activeTab === 'alur-farmasi'" class="space-y-4" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-blue-100 text-blue-800 text-xs font-extrabold flex items-center justify-center">3</span>
                    Panduan Petugas Farmasi & Pengelolaan Obat
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-blue-100 text-blue-800 text-xs font-bold">
                            Validasi Resep Masuk
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Di tab <strong>E-Resep & Farmasi</strong>, antrian resep dokter tampil secara kronologis. Apoteker memeriksa dosis dan kesesuaian obat, lalu mengubah status resep menjadi <em>"Disiapkan"</em> saat proses compounding/peracikan berlangsung.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-bold">
                            Penyerahan Obat & Stok Otomatis
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Setelah obat siap, panggil nama pasien dan klik tombol <em>"Tandai Diserahkan"</em>. Sistem otomatis mencatat log penyerahan dan memperbarui sisa stok inventaris sediaan obat di modul farmasi.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-purple-100 text-purple-800 text-xs font-bold">
                            Peringatan Stok Menipis & Kritis
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Sistem memberikan label otomatis: <span class="font-bold text-emerald-600">Aman</span> jika di atas batas minimal, <span class="font-bold text-amber-600">Menipis</span> jika mendekati batas, dan <span class="font-bold text-red-600">Kritis</span> jika di bawah 50% batas minimal.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-amber-100 text-amber-800 text-xs font-bold">
                            Pencatatan Obat Baru
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Gunakan tombol <strong>"Tambah Obat"</strong> pada sidebar untuk meregistrasikan sediaan baru (nama obat, bentuk sediaan tablet/sirup/inhaler, kategori terapi, jumlah stok awal, dan satuan).
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 4: Alur Admin & Master Data -->
        <div x-show="activeTab === 'alur-admin'" class="space-y-4" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 text-xs font-extrabold flex items-center justify-center">4</span>
                    Panduan Admin Klinik & Tata Kelola Data Master
                </h2>
                <div class="space-y-4">
                    <div class="p-5 rounded-2xl bg-amber-50/60 border border-amber-200/80 space-y-2">
                        <h3 class="font-extrabold text-sm text-amber-950">Pusat Data Master Klinik</h3>
                        <p class="text-xs text-amber-900/80 leading-relaxed">
                            Hanya role <strong>Super Admin</strong> dan <strong>Admin Klinik</strong> yang memiliki wewenang mengelola data master. Melalui modal Data Master, admin dapat menginput data dokter baru, nomor SIP dinas kesehatan, registrasi unit poli/ruang praktik, serta penyesuaian tarif tindakan medis.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-amber-50/60 border border-amber-200/80 space-y-2">
                        <h3 class="font-extrabold text-sm text-amber-950">Jadwal Praktik & Pengajuan Cuti Dokter</h3>
                        <p class="text-xs text-amber-900/80 leading-relaxed">
                            Di menu <strong>Jadwal & Cuti Dokter</strong>, admin dapat memantau ketersediaan dokter jaga harian, shift pagi/sore, dan mencatat permohonan cuti dokter agar kuota antrian poli terkait dapat disesuaikan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 5: Keamanan & Backup Database -->
        <div x-show="activeTab === 'keamanan'" class="space-y-4" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-extrabold flex items-center justify-center">5</span>
                    Keamanan Sistem, Turnstile Bot Protection, & Backup Database
                </h2>
                <div class="space-y-4">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <h3 class="font-extrabold text-sm text-slate-900">Proteksi Cloudflare Turnstile Manual</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Halaman login staf dan pasien dilindungi oleh widget Cloudflare Turnstile berbasis tantangan manual. Pengguna wajib mencentang kotak verifikasi untuk mencegah serangan bot bruteforce maupun credential stuffing.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <h3 class="font-extrabold text-sm text-slate-900">Prosedur Rutin Backup Database</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Super Admin dan Admin Klinik disarankan melakukan pencadangan database secara berkala melalui menu <strong>"Backup Database"</strong> di sidebar sebelum melakukan perubahan data massal atau maintenance sistem. Salinan berkas <code class="font-mono bg-slate-200 px-1 py-0.5 rounded">.sqlite</code> dapat diunduh langsung ke komputer administrator.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
