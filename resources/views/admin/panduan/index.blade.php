<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        Dokumentasi & SOP
                    </span>
                    <span class="text-xs text-slate-300">•</span>
                    <span class="text-xs font-medium text-slate-500">SIMRS e-Klinik</span>
                </div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight mt-1">
                    Panduan Operasional e-Klinik
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Prosedur operasional standar (SOP) alur pendaftaran, rekam medis elektronik, peresepan farmasi, dan administrasi sistem.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-xs font-medium bg-white border border-slate-200 text-slate-700 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                    <span>Versi SIMRS v2.4 LPSK</span>
                </span>
            </div>
        </div>
    </x-slot>

    <div x-data="{ activeTab: 'alur-pasien' }" class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

        <!-- Guide Category Navigation Tabs -->
        <div class="bg-white p-1 rounded-lg border border-slate-200 shadow-2xs flex flex-wrap gap-1">
            <button @click="activeTab = 'alur-pasien'" 
                    class="px-3.5 py-2 rounded-md text-xs font-medium transition-colors cursor-pointer flex items-center gap-2"
                    :class="activeTab === 'alur-pasien' ? 'bg-teal-700 text-white font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>1. Alur Pasien & Antrean</span>
            </button>

            <button @click="activeTab = 'alur-dokter'" 
                    class="px-3.5 py-2 rounded-md text-xs font-medium transition-colors cursor-pointer flex items-center gap-2"
                    :class="activeTab === 'alur-dokter' ? 'bg-teal-700 text-white font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>2. Dokter & EMR Medis</span>
            </button>

            <button @click="activeTab = 'alur-farmasi'" 
                    class="px-3.5 py-2 rounded-md text-xs font-medium transition-colors cursor-pointer flex items-center gap-2"
                    :class="activeTab === 'alur-farmasi' ? 'bg-teal-700 text-white font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
                <span>3. Farmasi & E-Resep</span>
            </button>

            <button @click="activeTab = 'alur-admin'" 
                    class="px-3.5 py-2 rounded-md text-xs font-medium transition-colors cursor-pointer flex items-center gap-2"
                    :class="activeTab === 'alur-admin' ? 'bg-teal-700 text-white font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>4. Admin & Master Data</span>
            </button>

            <button @click="activeTab = 'keamanan'" 
                    class="px-3.5 py-2 rounded-md text-xs font-medium transition-colors cursor-pointer flex items-center gap-2"
                    :class="activeTab === 'keamanan' ? 'bg-teal-700 text-white font-semibold shadow-2xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>5. Keamanan & Backup</span>
            </button>
        </div>

        <!-- Tab 1: Alur Pasien -->
        <div x-show="activeTab === 'alur-pasien'" class="space-y-4">
            <div class="bg-white rounded-lg p-5 border border-slate-200 shadow-2xs">
                <div class="border-b border-slate-200 pb-3 mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-teal-50 border border-teal-200 text-teal-800 text-xs font-bold flex items-center justify-center">1</span>
                            Prosedur Alur Pelayanan Pasien
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Tata cara pendaftaran mandiri, pengambilan nomor antrian, hingga pemanggilan di poliklinik.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-2">
                        <div class="w-6 h-6 rounded bg-teal-700 text-white font-bold text-xs flex items-center justify-center">A</div>
                        <h3 class="font-bold text-xs text-slate-900">Registrasi & Ambil Antrean</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pasien mendaftar via formulir registrasi atau Google Login. Buka menu Antrean, pilih poli tujuan (Poli Umum, Gigi, atau Anak). Sistem otomatis menerbitkan tiket digital bernomor urut dan QR Code.
                        </p>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-2">
                        <div class="w-6 h-6 rounded bg-teal-700 text-white font-bold text-xs flex items-center justify-center">B</div>
                        <h3 class="font-bold text-xs text-slate-900">Pemantauan Antrean Realtime</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pasien dapat memantau estimasi jam panggilan dan jumlah sisa antrean di hadapannya secara realtime melalui dashboard pasien tanpa harus menunggu terus di ruang tunggu.
                        </p>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-2">
                        <div class="w-6 h-6 rounded bg-teal-700 text-white font-bold text-xs flex items-center justify-center">C</div>
                        <h3 class="font-bold text-xs text-slate-900">Pemeriksaan & E-Resep</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Saat nomor dipanggil, tunjukkan tiket digital kepada perawat/dokter. Selesai pemeriksaan, resume medis tersimpan ke EMR dan e-resep otomatis diteruskan ke unit farmasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Alur Dokter & EMR Medis -->
        <div x-show="activeTab === 'alur-dokter'" class="space-y-4" style="display: none;">
            <div class="bg-white rounded-lg p-5 border border-slate-200 shadow-2xs">
                <div class="border-b border-slate-200 pb-3 mb-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-teal-50 border border-teal-200 text-teal-800 text-xs font-bold flex items-center justify-center">2</span>
                        Panduan Dokter & Pengisian Rekam Medis (EMR)
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Standar pencatatan catatan medis, kode diagnosa ICD-10, dan bridging SATUSEHAT Kemenkes.</p>
                </div>

                <div class="space-y-3">
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 flex flex-col md:flex-row gap-3 items-start">
                        <div class="w-8 h-8 rounded bg-teal-50 text-teal-700 border border-teal-200 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-bold text-xs text-slate-900">Pencatatan Rekam Medis Elektronik (SOAP)</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Buka menu <strong>Rekam Medis (EMR)</strong> di sidebar. Pilih pasien aktif dan lakukan input data Subjektif, Objektif (tekanan darah, nadi, suhu), Asesmen diagnosa kode ICD-10 (contoh: J06.9 untuk ISPA, K29.7 untuk Gastritis), serta Rencana Tindakan.
                            </p>
                        </div>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 flex flex-col md:flex-row gap-3 items-start">
                        <div class="w-8 h-8 rounded bg-teal-50 text-teal-700 border border-teal-200 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-bold text-xs text-slate-900">Integrasi SATUSEHAT Kemenkes (HL7 FHIR)</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Sistem telah terintegrasi dengan spesifikasi HL7 FHIR SATUSEHAT. Setelah resume medis disimpan, data Encounter & Condition dapat disinkronkan langsung ke platform SATUSEHAT via modul SatuSehatService.
                            </p>
                        </div>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 flex flex-col md:flex-row gap-3 items-start">
                        <div class="w-8 h-8 rounded bg-teal-50 text-teal-700 border border-teal-200 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-bold text-xs text-slate-900">Pembuatan E-Resep Terpadu</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Buat e-resep langsung dari panel pemeriksaan. Pilih sediaan obat dari stok apotek yang aktif, atur dosis dan signa (aturan pakai). Data resep langsung terkirim ke antrean peracikan farmasi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 3: Alur Farmasi & E-Resep -->
        <div x-show="activeTab === 'alur-farmasi'" class="space-y-4" style="display: none;">
            <div class="bg-white rounded-lg p-5 border border-slate-200 shadow-2xs">
                <div class="border-b border-slate-200 pb-3 mb-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-teal-50 border border-teal-200 text-teal-800 text-xs font-bold flex items-center justify-center">3</span>
                        Panduan Petugas Farmasi & Pengelolaan Sediaan Obat
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Tata laksana pemrosesan resep masuk, dispensing obat, dan kontrol stok sediaan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-2">
                        <div class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                            Validasi Resep Masuk
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Di tab <strong>E-Resep & Farmasi</strong>, antrean resep dokter tampil secara kronologis. Apoteker memeriksa dosis dan kesesuaian obat, lalu mengubah status resep menjadi <em>"Disiapkan"</em> saat proses compounding/peracikan berlangsung.
                        </p>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-2">
                        <div class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Penyerahan Obat & Pemotongan Stok
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Setelah obat siap, panggil nama pasien dan klik tombol <em>"Tandai Diserahkan"</em>. Sistem otomatis mencatat log penyerahan dan mengurangi stok sediaan obat di modul farmasi.
                        </p>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-2">
                        <div class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                            Klasifikasi Stok & Peringatan
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Sistem memberikan indikator otomatis: <span class="font-semibold text-emerald-700">Aman</span> jika di atas batas minimal, <span class="font-semibold text-amber-700">Menipis</span> jika mendekati batas, dan <span class="font-semibold text-rose-700">Kritis</span> jika di bawah 50% batas minimal.
                        </p>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-2">
                        <div class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                            Pencatatan Master Obat Baru
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
            <div class="bg-white rounded-lg p-5 border border-slate-200 shadow-2xs">
                <div class="border-b border-slate-200 pb-3 mb-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-teal-50 border border-teal-200 text-teal-800 text-xs font-bold flex items-center justify-center">4</span>
                        Panduan Administrator & Tata Kelola Data Master
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Konfigurasi data dokter, jadwal praktik, poliklinik, dan tarif tindakan klinik.</p>
                </div>

                <div class="space-y-3">
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-1.5">
                        <h3 class="font-bold text-xs text-slate-900">Pusat Data Master Klinik</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Hanya role <strong>Super Admin</strong> dan <strong>Admin Klinik</strong> yang memiliki wewenang mengelola data master. Melalui modal Data Master, admin dapat mendaftarkan dokter baru, nomor SIP dinas kesehatan, registrasi unit poli, serta penyesuaian tarif tindakan medis.
                        </p>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-1.5">
                        <h3 class="font-bold text-xs text-slate-900">Jadwal Praktik & Izin Cuti Dokter</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pada menu <strong>Jadwal & Cuti Dokter</strong>, admin memantau ketersediaan dokter jaga harian, shift pagi/sore, dan mencatat permohonan cuti dokter agar kuota antrian poli terkait dapat disesuaikan secara dinamis.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 5: Keamanan & Backup Database -->
        <div x-show="activeTab === 'keamanan'" class="space-y-4" style="display: none;">
            <div class="bg-white rounded-lg p-5 border border-slate-200 shadow-2xs">
                <div class="border-b border-slate-200 pb-3 mb-4">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-teal-50 border border-teal-200 text-teal-800 text-xs font-bold flex items-center justify-center">5</span>
                        Keamanan Sistem, Proteksi Bot, & Prosedur Backup
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Pencegahan akses ilegal dan pemeliharaan arsip basis data medis.</p>
                </div>

                <div class="space-y-3">
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-1.5">
                        <h3 class="font-bold text-xs text-slate-900">Proteksi Cloudflare Turnstile</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Halaman login staf dan portal pasien dilindungi oleh widget verifikasi interaktif Cloudflare Turnstile untuk mencegah serangan bot bruteforce maupun credential stuffing otomatis.
                        </p>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-1.5">
                        <h3 class="font-bold text-xs text-slate-900">Prosedur Rutin Backup Database</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Administrator disarankan melakukan pencadangan berkala melalui menu <strong>"Backup Database"</strong> di sidebar sebelum melakukan migrasi data besar atau pemeliharaan server. Berkas cadangan <code class="font-mono bg-slate-200 px-1 py-0.5 rounded text-slate-800 text-[11px]">.sqlite</code> dapat diunduh langsung untuk arsip offline yang aman.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
