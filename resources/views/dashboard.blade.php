<x-app-layout>
    <div x-data="{
        activeTab: 'overview',
        showObatModal: false,
        showResepModal: false,
        showMasterModal: false,
        masterTab: 'dokter',
        
        // Data Obat / Sediaan
        obatList: [
            {kode: 'OBT-001', nama: 'Paracetamol 500mg', sediaan: 'Tablet', kategori: 'Analgesik & Antipiretik', stok: 240, minStok: 50, satuan: 'Tablet', status: 'Aman'},
            {kode: 'OBT-002', nama: 'Amoxicillin 500mg', sediaan: 'Kapsul', kategori: 'Antibiotik', stok: 85, minStok: 40, satuan: 'Kapsul', status: 'Aman'},
            {kode: 'OBT-003', nama: 'Cetirizine 10mg', sediaan: 'Tablet', kategori: 'Antihistamin', stok: 18, minStok: 30, satuan: 'Tablet', status: 'Menipis'},
            {kode: 'OBT-004', nama: 'OBH Sirup Anak 60ml', sediaan: 'Sirup', kategori: 'Obat Batuk & Flu', stok: 12, minStok: 25, satuan: 'Botol', status: 'Menipis'},
            {kode: 'OBT-005', nama: 'Salbutamol Inhaler 100mcg', sediaan: 'Inhaler', kategori: 'Bronkodilator', stok: 35, minStok: 15, satuan: 'Pcs', status: 'Aman'},
            {kode: 'OBT-006', nama: 'Hydrocortisone Salep 1%', sediaan: 'Salep/Krim', kategori: 'Kortikosteroid Topikal', stok: 45, minStok: 20, satuan: 'Tube', status: 'Aman'},
            {kode: 'OBT-007', nama: 'Antasida Doen Suspensi', sediaan: 'Suspensi', kategori: 'Antasida', stok: 9, minStok: 20, satuan: 'Botol', status: 'Kritis'},
            {kode: 'OBT-008', nama: 'Metformin HCl 500mg', sediaan: 'Tablet', kategori: 'Antidiabetes', stok: 150, minStok: 50, satuan: 'Tablet', status: 'Aman'},
        ],
        newObat: {
            nama: '',
            sediaan: 'Tablet',
            kategori: 'Umum',
            stok: 100,
            minStok: 20,
            satuan: 'Tablet'
        },
        tambahObatSubmit() {
            if (!this.newObat.nama.trim()) return;
            let count = this.obatList.length + 1;
            let kode = 'OBT-' + String(count).padStart(3, '0');
            let stokNum = parseInt(this.newObat.stok) || 0;
            let minStokNum = parseInt(this.newObat.minStok) || 20;
            let status = stokNum <= minStokNum ? (stokNum <= minStokNum / 2 ? 'Kritis' : 'Menipis') : 'Aman';

            this.obatList.unshift({
                kode: kode,
                nama: this.newObat.nama,
                sediaan: this.newObat.sediaan,
                kategori: this.newObat.kategori,
                stok: stokNum,
                minStok: minStokNum,
                satuan: this.newObat.satuan,
                status: status
            });

            this.newObat.nama = '';
            this.showObatModal = false;
        },

        // Data Resep
        resepList: [
            {no: 'RSP-2026-081', waktu: '10:45', pasien: 'Ahmad Fauzi (34 th)', dokter: 'dr. Rina Kusuma', poli: 'Poli Umum', item: 'Paracetamol 500mg (3x1), Amoxicillin 500mg (3x1)', status: 'Siap Diambil'},
            {no: 'RSP-2026-082', waktu: '10:30', pasien: 'Siti Rahayu (28 th)', dokter: 'drg. Hendra P.', poli: 'Poli Gigi', item: 'Ibuprofen 400mg (3x1), Amoxicillin 500mg (3x1)', status: 'Disiapkan'},
            {no: 'RSP-2026-083', waktu: '10:15', pasien: 'Dewi Lestari (6 th)', dokter: 'dr. Sari Dewi', poli: 'Poli Anak', item: 'OBH Sirup Anak (3x1 cth), Cetirizine Drop', status: 'Diserahkan'},
            {no: 'RSP-2026-084', waktu: '09:50', pasien: 'Rudi Hermawan (45 th)', dokter: 'dr. Budi Santoso', poli: 'Poli Umum', item: 'Metformin 500mg (2x1), Amlodipine 5mg (1x1)', status: 'Diserahkan'},
            {no: 'RSP-2026-085', waktu: '09:20', pasien: 'Budi Santoso (52 th)', dokter: 'dr. Rina Kusuma', poli: 'Poli Umum', item: 'Antasida Doen (3x1 AC), Ranitidine 150mg (2x1)', status: 'Diserahkan'},
        ],
        newResep: {
            pasien: '',
            dokter: 'dr. Rina Kusuma',
            poli: 'Poli Umum',
            item: ''
        },
        tambahResepSubmit() {
            if (!this.newResep.pasien.trim() || !this.newResep.item.trim()) return;
            let count = this.resepList.length + 81;
            let now = new Date();
            let jam = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');

            this.resepList.unshift({
                no: 'RSP-2026-0' + count,
                waktu: jam,
                pasien: this.newResep.pasien,
                dokter: this.newResep.dokter,
                poli: this.newResep.poli,
                item: this.newResep.item,
                status: 'Disiapkan'
            });

            this.newResep.pasien = '';
            this.newResep.item = '';
            this.showResepModal = false;
        },
        updateResepStatus(index, newStatus) {
            this.resepList[index].status = newStatus;
        },

        // Data Master
        masterDokter: [
            {nama: 'dr. Rina Kusuma', sip: 'SIP.446/012/DINKES/2023', spesialisasi: 'Dokter Umum', poli: 'Poli Umum', status: 'Aktif', sisaCuti: '10 Hari'},
            {nama: 'drg. Hendra P.', sip: 'SIP.446/045/DINKES/2022', spesialisasi: 'Dokter Gigi', poli: 'Poli Gigi', status: 'Aktif', sisaCuti: '12 Hari'},
            {nama: 'dr. Budi Santoso, Sp.PD', sip: 'SIP.446/088/DINKES/2021', spesialisasi: 'Spesialis Penyakit Dalam', poli: 'Poli Umum / Internis', status: 'Aktif', sisaCuti: '12 Hari'},
            {nama: 'dr. Sari Dewi, Sp.A', sip: 'SIP.446/102/DINKES/2023', spesialisasi: 'Spesialis Anak', poli: 'Poli Anak', status: 'Aktif', sisaCuti: '12 Hari'},
        ],
        masterPoli: [
            {nama: 'Poli Umum', ruang: 'Ruang 101 (Lantai 1)', jam: '08:00 - 21:00', dokterJaga: 'dr. Rina Kusuma / dr. Budi S.', status: 'Buka'},
            {nama: 'Poli Gigi & Mulut', ruang: 'Ruang 103 (Lantai 1)', jam: '09:00 - 17:00', dokterJaga: 'drg. Hendra P.', status: 'Buka'},
            {nama: 'Poli Anak (Pediatri)', ruang: 'Ruang 201 (Lantai 2)', jam: '13:00 - 18:00', dokterJaga: 'dr. Sari Dewi, Sp.A', status: 'Buka'},
            {nama: 'Unit Farmasi & Apotek', ruang: 'Lobby Farmasi', jam: '24 Jam', dokterJaga: 'Apt. Farhan, S.Farm', status: 'Buka'},
        ],
        masterTindakan: [
            {kode: 'TDK-001', nama: 'Konsultasi & Pemeriksaan Dokter Umum', poli: 'Poli Umum', tarif: 'Rp 50.000', kategori: 'Pemeriksaan'},
            {kode: 'TDK-002', nama: 'Pembersihan Karang Gigi (Scaling)', poli: 'Poli Gigi', tarif: 'Rp 175.000', kategori: 'Tindakan Gigi'},
            {kode: 'TDK-003', nama: 'Penambalan Gigi Komposit', poli: 'Poli Gigi', tarif: 'Rp 150.000', kategori: 'Tindakan Gigi'},
            {kode: 'TDK-004', nama: 'Pemeriksaan Tumbuh Kembang Anak', poli: 'Poli Anak', tarif: 'Rp 75.000', kategori: 'Pemeriksaan'},
            {kode: 'TDK-005', nama: 'Cek Gula Darah Sewaktu (GDS)', poli: 'Laboratorium', tarif: 'Rp 25.000', kategori: 'Laboratorium'},
            {kode: 'TDK-006', nama: 'Nebulisasi (Terapi Uap)', poli: 'Poli Umum / Anak', tarif: 'Rp 65.000', kategori: 'Tindakan Medis'},
        ]
    }">

        <!-- Top Header & Clinic Live Status -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm border border-emerald-100 p-2 shrink-0">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/ea/Logo_Garuda_Pancasila_Emas.svg" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="font-extrabold text-gray-900 text-lg leading-tight">Satu Sehat LPSK</h1>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Klinik Buka
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-0.5">Sistem Informasi Manajemen Pelayanan Klinik Terpadu</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-gray-800" x-text="new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })"></p>
                    <p class="text-[11px] text-gray-400">Jam Operasional: 08:00 - 21:00 WIB</p>
                </div>
                <button class="relative p-2.5 text-gray-500 hover:text-gray-900 bg-white rounded-2xl shadow-sm border border-gray-150 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 border-[1.5px] border-white rounded-full"></span>
                </button>
            </div>
        </div>

        <!-- Greeting Card with Background Image -->
        <div class="relative w-full rounded-3xl overflow-hidden border border-gray-150 shadow-[0_4px_20px_rgba(0,0,0,0.03)] mb-6 bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 text-white p-6">
            <div class="absolute right-0 top-0 bottom-0 w-1/2 opacity-10 pointer-events-none">
                <img src="https://images.unsplash.com/photo-1586773860418-d37222d8fce3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Hospital" class="w-full h-full object-cover">
            </div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-lg text-[11px] font-bold uppercase tracking-wider text-emerald-200 border border-white/10">Dashboard Operasional</span>
                    <h2 class="text-2xl font-black mt-2">Kondisi & Ringkasan Layanan Klinik</h2>
                    <p class="text-xs text-emerald-100/90 mt-1 max-w-xl leading-relaxed">
                        Monitoring terpadu arus antrian, dokter praktik, manajemen sediaan obat farmasi, dan e-resep secara real-time.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="showMasterModal = true" class="px-4 py-2.5 bg-white text-emerald-900 font-bold rounded-xl text-xs hover:bg-emerald-50 transition-all shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16"/></svg>
                        Data Master
                    </button>
                    <button @click="showObatModal = true" class="px-4 py-2.5 bg-emerald-600/80 hover:bg-emerald-600 text-white font-bold rounded-xl text-xs border border-white/20 transition-all shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Obat
                    </button>
                </div>
            </div>
        </div>

        <!-- 6 Main Quick Action Grid -->
        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 mb-8">
            <!-- Cek Antrian -->
            <a href="{{ route('antrian.index') }}" wire:navigate class="flex flex-col items-center gap-2 p-3 bg-white rounded-2xl border border-gray-150 shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:border-orange-200 hover:bg-orange-50/40 transition-all group">
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform border border-orange-100">
                    <svg class="w-6 h-6 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-800 text-center">Antrian</span>
            </a>

            <!-- Jadwal Dokter -->
            <a href="{{ route('jadwal.index') }}" wire:navigate class="flex flex-col items-center gap-2 p-3 bg-white rounded-2xl border border-gray-150 shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:border-emerald-200 hover:bg-emerald-50/40 transition-all group">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform border border-emerald-100">
                    <svg class="w-6 h-6 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-800 text-center">Jadwal</span>
            </a>

            <!-- Obat / Sediaan -->
            <button @click="activeTab = 'obat'; $nextTick(() => document.getElementById('section-content')?.scrollIntoView({behavior: 'smooth'}))" class="flex flex-col items-center gap-2 p-3 bg-white rounded-2xl border border-gray-150 shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:border-blue-200 hover:bg-blue-50/40 transition-all group">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform border border-blue-100">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-800 text-center">Obat / Sediaan</span>
            </button>

            <!-- Resep -->
            <button @click="activeTab = 'resep'; $nextTick(() => document.getElementById('section-content')?.scrollIntoView({behavior: 'smooth'}))" class="flex flex-col items-center gap-2 p-3 bg-white rounded-2xl border border-gray-150 shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:border-purple-200 hover:bg-purple-50/40 transition-all group">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform border border-purple-100">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-800 text-center">Resep Obat</span>
            </button>

            <!-- Data Master -->
            <button @click="showMasterModal = true" class="flex flex-col items-center gap-2 p-3 bg-white rounded-2xl border border-gray-150 shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:border-amber-200 hover:bg-amber-50/40 transition-all group">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform border border-amber-100">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-800 text-center">Data Master</span>
            </button>

            <!-- Rekam Medis -->
            <a href="{{ route('rekam-medis.index') }}" wire:navigate class="flex flex-col items-center gap-2 p-3 bg-white rounded-2xl border border-gray-150 shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:border-teal-200 hover:bg-teal-50/40 transition-all group">
                <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform border border-teal-100">
                    <svg class="w-6 h-6 text-teal-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                        <line x1="12" y1="11" x2="12" y2="17" />
                        <line x1="9" y1="14" x2="15" y2="14" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-800 text-center">Rekam Medis</span>
            </a>
        </div>

        <!-- ================= SECTION: RINGKASAN KONDISI KLINIK ================= -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-extrabold text-gray-900 text-lg">Ringkasan Kondisi Klinik Hari Ini</h3>
                    <p class="text-xs text-gray-500">Statistik operasional layanan, antrian, kesiapan medis, dan farmasi</p>
                </div>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    Live Update
                </span>
            </div>

            <!-- 4 Key Performance Indicators (KPI Cards) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- 1. Pasien Terdaftar -->
                <div class="bg-white rounded-3xl p-5 border border-gray-150 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pasien Hari Ini</span>
                        <div class="w-9 h-9 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-black text-gray-900">86</span>
                            <span class="text-xs text-gray-400 font-semibold">/ 120 Kuota</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full mt-3 overflow-hidden">
                            <div class="bg-orange-500 h-full rounded-full" style="width: 71%;"></div>
                        </div>
                        <div class="flex justify-between items-center text-[11px] text-gray-500 mt-2 font-medium">
                            <span>42 Selesai</span>
                            <span>18 Diperiksa</span>
                            <span>26 Menunggu</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Dokter & Poli Praktik -->
                <div class="bg-white rounded-3xl p-5 border border-gray-150 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Dokter & Poli</span>
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-black text-emerald-600">4</span>
                            <span class="text-xs text-gray-500 font-bold">Dokter Aktif</span>
                        </div>
                        <div class="flex items-center gap-1.5 mt-3">
                            <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">3 Poli Buka</span>
                            <span class="px-2 py-0.5 rounded-md bg-red-50 text-red-600 text-[10px] font-bold border border-red-200">1 Dokter Cuti</span>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-2">Semua poli utama beroperasi normal</p>
                    </div>
                </div>

                <!-- 3. Resep & Farmasi -->
                <div class="bg-white rounded-3xl p-5 border border-gray-150 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Antrian Resep</span>
                        <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-black text-purple-600" x-text="resepList.length"></span>
                            <span class="text-xs text-gray-500 font-bold">E-Resep Masuk</span>
                        </div>
                        <div class="flex items-center gap-1.5 mt-3">
                            <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">
                                <span x-text="resepList.filter(r => r.status === 'Diserahkan').length"></span> Selesai
                            </span>
                            <span class="px-2 py-0.5 rounded-md bg-yellow-50 text-yellow-700 text-[10px] font-bold border border-yellow-200">
                                <span x-text="resepList.filter(r => r.status === 'Disiapkan').length"></span> Diproses
                            </span>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-2">Waktu tunggu rata-rata: 7 menit</p>
                    </div>
                </div>

                <!-- 4. Stok Obat & Sediaan -->
                <div class="bg-white rounded-3xl p-5 border border-gray-150 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kondisi Obat</span>
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-black text-gray-900" x-text="obatList.length"></span>
                            <span class="text-xs text-gray-500 font-bold">Jenis Sediaan</span>
                        </div>
                        <div class="flex items-center gap-1.5 mt-3">
                            <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">
                                <span x-text="obatList.filter(o => o.status === 'Aman').length"></span> Aman
                            </span>
                            <span class="px-2 py-0.5 rounded-md bg-red-50 text-red-600 text-[10px] font-bold border border-red-200">
                                <span x-text="obatList.filter(o => o.status !== 'Aman').length"></span> Restock
                            </span>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-2">Stok apotek terintegrasi real-time</p>
                    </div>
                </div>
            </div>

            <!-- Kondisi Live Setiap Poli -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Poli Umum -->
                <div class="bg-white rounded-3xl p-5 border border-gray-150 shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">Poli Umum</span>
                        <span class="text-xs font-bold text-gray-400">Ruang 101</span>
                    </div>
                    <h4 class="font-bold text-gray-900">dr. Rina Kusuma</h4>
                    <p class="text-xs text-gray-500 mb-4">Praktik: 08:00 - 14:00 WIB</p>
                    
                    <div class="p-3 bg-gray-50 rounded-2xl flex items-center justify-between">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Dipanggil</p>
                            <p class="text-xl font-black text-emerald-600">A-014</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Antrian Sisa</p>
                            <p class="text-sm font-extrabold text-gray-800">12 Pasien</p>
                        </div>
                    </div>
                </div>

                <!-- Poli Gigi -->
                <div class="bg-white rounded-3xl p-5 border border-gray-150 shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-200">Poli Gigi</span>
                        <span class="text-xs font-bold text-gray-400">Ruang 103</span>
                    </div>
                    <h4 class="font-bold text-gray-900">drg. Hendra P.</h4>
                    <p class="text-xs text-gray-500 mb-4">Praktik: 09:00 - 15:00 WIB</p>
                    
                    <div class="p-3 bg-gray-50 rounded-2xl flex items-center justify-between">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Dipanggil</p>
                            <p class="text-xl font-black text-blue-600">B-008</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Antrian Sisa</p>
                            <p class="text-sm font-extrabold text-gray-800">6 Pasien</p>
                        </div>
                    </div>
                </div>

                <!-- Poli Anak -->
                <div class="bg-white rounded-3xl p-5 border border-gray-150 shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-xs font-bold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-full border border-purple-200">Poli Anak</span>
                        <span class="text-xs font-bold text-gray-400">Ruang 201</span>
                    </div>
                    <h4 class="font-bold text-gray-900">dr. Sari Dewi, Sp.A</h4>
                    <p class="text-xs text-gray-500 mb-4">Praktik: 13:00 - 17:00 WIB</p>
                    
                    <div class="p-3 bg-gray-50 rounded-2xl flex items-center justify-between">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Dipanggil</p>
                            <p class="text-xl font-black text-purple-600">C-005</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Antrian Sisa</p>
                            <p class="text-sm font-extrabold text-gray-800">4 Pasien</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= SECTION CONTENT: TABS / FITUR OBAT & RESEP & MASTER ================= -->
        <div id="section-content" class="mb-10">
            <!-- Navigation Tabs for Interactive Section -->
            <div class="flex border-b border-gray-200 gap-2 mb-6 overflow-x-auto">
                <button @click="activeTab = 'overview'" 
                        :class="activeTab === 'overview' ? 'border-emerald-600 text-emerald-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 font-semibold'"
                        class="py-3 px-4 border-b-2 text-sm whitespace-nowrap transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    Semua Modul
                </button>
                <button @click="activeTab = 'obat'" 
                        :class="activeTab === 'obat' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 font-semibold'"
                        class="py-3 px-4 border-b-2 text-sm whitespace-nowrap transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    Obat & Sediaan (<span x-text="obatList.length"></span>)
                </button>
                <button @click="activeTab = 'resep'" 
                        :class="activeTab === 'resep' ? 'border-purple-600 text-purple-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 font-semibold'"
                        class="py-3 px-4 border-b-2 text-sm whitespace-nowrap transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Resep Pasien (<span x-text="resepList.length"></span>)
                </button>
            </div>

            <!-- 1. OBAT & SEDIAAN SECTION -->
            <div x-show="activeTab === 'overview' || activeTab === 'obat'" class="mb-8">
                <div class="bg-white rounded-3xl border border-gray-150 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gradient-to-r from-blue-50/50 to-white">
                        <div>
                            <h4 class="font-extrabold text-gray-900 text-base flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                                Daftar Obat & Sediaan Farmasi
                            </h4>
                            <p class="text-xs text-gray-500 mt-0.5">Monitoring stok sediaan tablet, sirup, salep, kapsul & alkes</p>
                        </div>
                        <button @click="showObatModal = true" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white font-bold rounded-xl text-xs hover:bg-blue-700 transition-colors shadow-sm self-start sm:self-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Obat / Sediaan
                        </button>
                    </div>

                    <!-- Table of Obat -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-600">
                            <thead class="bg-gray-50/80 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                <tr>
                                    <th class="py-3.5 px-5">Kode</th>
                                    <th class="py-3.5 px-5">Nama Obat</th>
                                    <th class="py-3.5 px-5">Bentuk Sediaan</th>
                                    <th class="py-3.5 px-5">Kategori</th>
                                    <th class="py-3.5 px-5 text-right">Sisa Stok</th>
                                    <th class="py-3.5 px-5 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-medium">
                                <template x-for="(o, idx) in (activeTab === 'overview' ? obatList.slice(0, 5) : obatList)" :key="o.kode">
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="py-3.5 px-5 font-bold text-gray-400" x-text="o.kode"></td>
                                        <td class="py-3.5 px-5 font-bold text-gray-900" x-text="o.nama"></td>
                                        <td class="py-3.5 px-5">
                                            <span class="px-2.5 py-1 rounded-lg bg-gray-100 text-gray-700 font-semibold" x-text="o.sediaan"></span>
                                        </td>
                                        <td class="py-3.5 px-5 text-gray-500" x-text="o.kategori"></td>
                                        <td class="py-3.5 px-5 text-right font-bold text-gray-900" x-text="o.stok + ' ' + o.satuan"></td>
                                        <td class="py-3.5 px-5 text-center">
                                            <span :class="{
                                                'bg-emerald-50 text-emerald-700 border-emerald-200': o.status === 'Aman',
                                                'bg-yellow-50 text-yellow-700 border-yellow-200': o.status === 'Menipis',
                                                'bg-red-50 text-red-700 border-red-200': o.status === 'Kritis'
                                            }" class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border" x-text="o.status">
                                            </span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 2. RESEP OBAT SECTION -->
            <div x-show="activeTab === 'overview' || activeTab === 'resep'" class="mb-8">
                <div class="bg-white rounded-3xl border border-gray-150 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gradient-to-r from-purple-50/50 to-white">
                        <div>
                            <h4 class="font-extrabold text-gray-900 text-base flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                                E-Resep & Antrian Farmasi Pasien
                            </h4>
                            <p class="text-xs text-gray-500 mt-0.5">Resep masuk dari dokter yang siap diracik dan diserahkan</p>
                        </div>
                        <button @click="showResepModal = true" class="inline-flex items-center gap-1.5 px-4 py-2 bg-purple-600 text-white font-bold rounded-xl text-xs hover:bg-purple-700 transition-colors shadow-sm self-start sm:self-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Buat Resep Baru
                        </button>
                    </div>

                    <!-- Resep List Cards / Table -->
                    <div class="divide-y divide-gray-100">
                        <template x-for="(r, rIdx) in (activeTab === 'overview' ? resepList.slice(0, 4) : resepList)" :key="r.no">
                            <div class="p-4 sm:p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-gray-50/60 transition-colors">
                                <div class="space-y-1.5 flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="font-extrabold text-xs text-purple-700 bg-purple-50 px-2.5 py-0.5 rounded-md border border-purple-100" x-text="r.no"></span>
                                        <span class="text-xs text-gray-400 font-semibold" x-text="'Pukul ' + r.waktu + ' WIB'"></span>
                                        <span class="text-xs font-bold text-gray-500" x-text="'• ' + r.poli"></span>
                                    </div>
                                    <h5 class="font-bold text-sm text-gray-900" x-text="r.pasien"></h5>
                                    <p class="text-xs text-gray-600 bg-gray-50 p-2.5 rounded-xl border border-gray-100 font-sans">
                                        <span class="font-bold text-gray-700">Rincian Obat:</span> <span x-text="r.item"></span>
                                    </p>
                                    <p class="text-[11px] text-gray-400" x-text="'Peresep: ' + r.dokter"></p>
                                </div>

                                <div class="flex items-center gap-3 self-end md:self-center shrink-0">
                                    <span :class="{
                                        'bg-yellow-50 text-yellow-700 border-yellow-200': r.status === 'Disiapkan',
                                        'bg-blue-50 text-blue-700 border-blue-200': r.status === 'Siap Diambil',
                                        'bg-emerald-50 text-emerald-700 border-emerald-200': r.status === 'Diserahkan'
                                    }" class="px-3 py-1 rounded-full text-xs font-bold border" x-text="r.status">
                                    </span>
                                    
                                    <template x-if="r.status === 'Disiapkan'">
                                        <button @click="updateResepStatus(rIdx, 'Siap Diambil')" class="px-3 py-1.5 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition-colors shadow-sm">
                                            Siap Diambil
                                        </button>
                                    </template>
                                    <template x-if="r.status === 'Siap Diambil'">
                                        <button @click="updateResepStatus(rIdx, 'Diserahkan')" class="px-3 py-1.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors shadow-sm">
                                            Serahkan Obat
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= MODALS ================= -->

        <!-- 1. MODAL TAMBAH OBAT & SEDIAAN -->
        <div x-show="showObatModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
             style="display: none;"
             x-transition>
            <div @click.away="showObatModal = false" class="bg-white w-full max-w-md rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-blue-50">
                    <h3 class="font-extrabold text-gray-900 text-lg">Tambah Obat / Sediaan</h3>
                    <button @click="showObatModal = false" class="text-gray-400 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form @submit.prevent="tambahObatSubmit()" class="p-6 space-y-4 font-sans">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama Obat & Dosis</label>
                        <input x-model="newObat.nama" type="text" placeholder="Contoh: Amoxicillin 500mg" required class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Bentuk Sediaan</label>
                            <select x-model="newObat.sediaan" class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm bg-white">
                                <option value="Tablet">Tablet</option>
                                <option value="Kapsul">Kapsul</option>
                                <option value="Sirup">Sirup</option>
                                <option value="Suspensi">Suspensi</option>
                                <option value="Salep/Krim">Salep/Krim</option>
                                <option value="Injeksi">Injeksi</option>
                                <option value="Inhaler">Inhaler</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Satuan</label>
                            <input x-model="newObat.satuan" type="text" placeholder="Tablet/Botol" required class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kategori / Golongan</label>
                        <input x-model="newObat.kategori" type="text" placeholder="Contoh: Antibiotik / Analgesik" required class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Stok Awal</label>
                            <input x-model="newObat.stok" type="number" placeholder="100" required class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Batas Minimum</label>
                            <input x-model="newObat.minStok" type="number" placeholder="20" required class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                        </div>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showObatModal = false" class="flex-1 py-3 bg-white text-gray-700 font-bold border border-gray-200 rounded-xl text-sm transition-colors hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-xl text-sm shadow-sm transition-colors hover:bg-blue-700">
                            Simpan Obat
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 2. MODAL BUAT RESEP BARU -->
        <div x-show="showResepModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
             style="display: none;"
             x-transition>
            <div @click.away="showResepModal = false" class="bg-white w-full max-w-md rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-purple-50">
                    <h3 class="font-extrabold text-gray-900 text-lg">Buat E-Resep Baru</h3>
                    <button @click="showResepModal = false" class="text-gray-400 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form @submit.prevent="tambahResepSubmit()" class="p-6 space-y-4 font-sans">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama Pasien</label>
                        <input x-model="newResep.pasien" type="text" placeholder="Masukkan nama pasien & umur" required class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Poli</label>
                            <select x-model="newResep.poli" class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm bg-white">
                                <option value="Poli Umum">Poli Umum</option>
                                <option value="Poli Gigi">Poli Gigi</option>
                                <option value="Poli Anak">Poli Anak</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Dokter Peresep</label>
                            <select x-model="newResep.dokter" class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm bg-white">
                                <option value="dr. Rina Kusuma">dr. Rina Kusuma</option>
                                <option value="drg. Hendra P.">drg. Hendra P.</option>
                                <option value="dr. Budi Santoso">dr. Budi Santoso</option>
                                <option value="dr. Sari Dewi">dr. Sari Dewi</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Rincian Obat & Aturan Pakai</label>
                        <textarea x-model="newResep.item" rows="3" placeholder="Contoh: Paracetamol 500mg (3x1 tab sesudah makan), Cetirizine 10mg (1x1 malam)" required class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-sm"></textarea>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showResepModal = false" class="flex-1 py-3 bg-white text-gray-700 font-bold border border-gray-200 rounded-xl text-sm transition-colors hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-purple-600 text-white font-bold rounded-xl text-sm shadow-sm transition-colors hover:bg-purple-700">
                            Kirim ke Farmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 3. MODAL DATA MASTER -->
        <div x-show="showMasterModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
             style="display: none;"
             x-transition>
            <div @click.away="showMasterModal = false" class="bg-white w-full max-w-2xl rounded-3xl shadow-xl border border-gray-100 overflow-hidden flex flex-col max-h-[90vh]">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-amber-50">
                    <div>
                        <h3 class="font-extrabold text-gray-900 text-lg">Pusat Data Master Klinik</h3>
                        <p class="text-xs text-gray-500">Kelola master dokter, poli layanan, tindakan & tarif medis</p>
                    </div>
                    <button @click="showMasterModal = false" class="text-gray-400 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Master Sub Tabs -->
                <div class="flex border-b border-gray-150 px-6 pt-3 gap-3 bg-gray-50/50">
                    <button @click="masterTab = 'dokter'" :class="masterTab === 'dokter' ? 'border-amber-600 text-amber-700 font-bold' : 'border-transparent text-gray-500 font-semibold'" class="pb-3 px-2 border-b-2 text-xs transition-colors">
                        Master Dokter (<span x-text="masterDokter.length"></span>)
                    </button>
                    <button @click="masterTab = 'poli'" :class="masterTab === 'poli' ? 'border-amber-600 text-amber-700 font-bold' : 'border-transparent text-gray-500 font-semibold'" class="pb-3 px-2 border-b-2 text-xs transition-colors">
                        Master Poli & Ruangan (<span x-text="masterPoli.length"></span>)
                    </button>
                    <button @click="masterTab = 'tindakan'" :class="masterTab === 'tindakan' ? 'border-amber-600 text-amber-700 font-bold' : 'border-transparent text-gray-500 font-semibold'" class="pb-3 px-2 border-b-2 text-xs transition-colors">
                        Tindakan & Tarif (<span x-text="masterTindakan.length"></span>)
                    </button>
                </div>

                <!-- Master Tab Content Area -->
                <div class="p-6 overflow-y-auto flex-1 space-y-4">
                    <!-- Tab Dokter -->
                    <div x-show="masterTab === 'dokter'" class="space-y-3">
                        <template x-for="d in masterDokter" :key="d.nama">
                            <div class="p-4 rounded-2xl border border-gray-150 flex items-center justify-between hover:bg-amber-50/20 transition-colors">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm" x-text="d.nama"></h4>
                                    <p class="text-xs text-amber-700 font-semibold mt-0.5" x-text="d.spesialisasi + ' • ' + d.poli"></p>
                                    <p class="text-[11px] text-gray-400" x-text="d.sip"></p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200" x-text="d.status"></span>
                                    <p class="text-[11px] text-gray-500 mt-1 font-semibold" x-text="'Sisa Cuti: ' + d.sisaCuti"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Tab Poli -->
                    <div x-show="masterTab === 'poli'" class="space-y-3">
                        <template x-for="p in masterPoli" :key="p.nama">
                            <div class="p-4 rounded-2xl border border-gray-150 flex items-center justify-between hover:bg-amber-50/20 transition-colors">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm" x-text="p.nama"></h4>
                                    <p class="text-xs text-gray-600 mt-0.5" x-text="p.ruang"></p>
                                    <p class="text-[11px] text-gray-400" x-text="'Dokter: ' + p.dokterJaga"></p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold border border-blue-200" x-text="p.jam"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Tab Tindakan -->
                    <div x-show="masterTab === 'tindakan'" class="space-y-3">
                        <template x-for="t in masterTindakan" :key="t.kode">
                            <div class="p-4 rounded-2xl border border-gray-150 flex items-center justify-between hover:bg-amber-50/20 transition-colors">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-extrabold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200" x-text="t.kode"></span>
                                        <h4 class="font-bold text-gray-900 text-sm" x-text="t.nama"></h4>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1" x-text="t.poli + ' • ' + t.kategori"></p>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-black text-emerald-700" x-text="t.tarif"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <button @click="showMasterModal = false" class="px-6 py-2.5 bg-gray-900 text-white font-bold rounded-xl text-xs hover:bg-gray-800 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <div class="h-6"></div>
    </div>
</x-app-layout>
