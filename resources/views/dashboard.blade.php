<x-app-layout>
    <div x-data="{
        activeTab: 'overview',
        showObatModal: false,
        showResepModal: false,
        showMasterModal: false,
        masterTab: 'dokter',
        searchObat: '',
        searchResep: '',
        
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
            if (!this.newObat.nama.trim()) {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { type: 'error', title: 'Input Gagal', message: 'Nama obat wajib diisi sebelum menyimpan data!' }
                }));
                return;
            }
            let count = this.obatList.length + 1;
            let kode = 'OBT-' + String(count).padStart(3, '0');
            let stokNum = parseInt(this.newObat.stok) || 0;
            let minStokNum = parseInt(this.newObat.minStok) || 20;
            let status = stokNum <= minStokNum ? (stokNum <= minStokNum / 2 ? 'Kritis' : 'Menipis') : 'Aman';
            let namaObat = this.newObat.nama;

            this.obatList.unshift({
                kode: kode,
                nama: namaObat,
                sediaan: this.newObat.sediaan,
                kategori: this.newObat.kategori,
                stok: stokNum,
                minStok: minStokNum,
                satuan: this.newObat.satuan,
                status: status
            });

            this.newObat.nama = '';
            this.showObatModal = false;

            window.dispatchEvent(new CustomEvent('notify', {
                detail: { type: 'success', title: 'Input Berhasil', message: 'Sediaan obat ' + namaObat + ' (' + kode + ') berhasil disimpan ke stok.' }
            }));
        },
        get filteredObatList() {
            if (!this.searchObat.trim()) return this.obatList;
            let q = this.searchObat.toLowerCase();
            return this.obatList.filter(o => o.nama.toLowerCase().includes(q) || o.kode.toLowerCase().includes(q) || o.kategori.toLowerCase().includes(q));
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
            if (!this.newResep.pasien.trim()) {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { type: 'error', title: 'Input Gagal', message: 'Nama pasien penerima resep wajib diisi!' }
                }));
                return;
            }
            if (!this.newResep.item.trim()) {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { type: 'error', title: 'Input Gagal', message: 'Daftar item obat dan dosis resep wajib diisi!' }
                }));
                return;
            }
            let count = this.resepList.length + 81;
            let now = new Date();
            let jam = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
            let noResep = 'RSP-2026-0' + count;
            let namaPasien = this.newResep.pasien;

            this.resepList.unshift({
                no: noResep,
                waktu: jam,
                pasien: namaPasien,
                dokter: this.newResep.dokter,
                poli: this.newResep.poli,
                item: this.newResep.item,
                status: 'Disiapkan'
            });

            this.newResep.pasien = '';
            this.newResep.item = '';
            this.showResepModal = false;

            window.dispatchEvent(new CustomEvent('notify', {
                detail: { type: 'success', title: 'E-Resep Berhasil Terbit', message: 'E-Resep ' + noResep + ' untuk ' + namaPasien + ' berhasil dikirim ke Farmasi.' }
            }));
        },
        updateResepStatus(index, newStatus) {
            this.resepList[index].status = newStatus;
            window.dispatchEvent(new CustomEvent('notify', {
                detail: { type: 'success', title: 'Status E-Resep Berubah', message: 'Resep ' + this.resepList[index].no + ' kini berstatus: ' + newStatus }
            }));
        },
        get filteredResepList() {
            if (!this.searchResep.trim()) return this.resepList;
            let q = this.searchResep.toLowerCase();
            return this.resepList.filter(r => r.pasien.toLowerCase().includes(q) || r.no.toLowerCase().includes(q) || r.poli.toLowerCase().includes(q) || r.item.toLowerCase().includes(q));
        },

        init() {
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            if (tabParam && ['overview', 'obat', 'resep'].includes(tabParam)) {
                this.activeTab = tabParam;
                this.$nextTick(() => {
                    document.getElementById('section-content')?.scrollIntoView({behavior: 'smooth'});
                });
            }
            const modalParam = urlParams.get('modal');
            if (modalParam === 'obat') this.showObatModal = true;
            if (modalParam === 'resep') this.showResepModal = true;
            if (modalParam === 'master') {
                this.showMasterModal = true;
                const mTab = urlParams.get('masterTab');
                if (mTab && ['dokter', 'poli', 'tindakan'].includes(mTab)) {
                    this.masterTab = mTab;
                }
                const addParam = urlParams.get('add');
                if (addParam) {
                    this.showMasterAddForm = true;
                }
            }
        },

        // Data Master
        showMasterAddForm: false,
        newMasterDokter: {
            nama: '',
            sip: '',
            spesialisasi: '',
            poli: 'Poli Umum',
            status: 'Aktif',
            sisaCuti: '12 Hari'
        },
        newMasterPoli: {
            nama: '',
            ruang: '',
            jam: '08:00 - 16:00',
            dokterJaga: '',
            status: 'Buka'
        },
        newMasterTindakan: {
            kode: '',
            nama: '',
            poli: 'Poli Umum',
            tarif: '',
            kategori: 'Pemeriksaan'
        },
        tambahMasterDokterSubmit() {
            if (!this.newMasterDokter.nama.trim()) {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { type: 'error', title: 'Input Gagal', message: 'Nama dokter wajib diisi!' }
                }));
                return;
            }
            let namaDokter = this.newMasterDokter.nama;
            this.masterDokter.unshift({ ...this.newMasterDokter });
            this.newMasterDokter = { nama: '', sip: '', spesialisasi: '', poli: 'Poli Umum', status: 'Aktif', sisaCuti: '12 Hari' };
            this.showMasterAddForm = false;

            window.dispatchEvent(new CustomEvent('notify', {
                detail: { type: 'success', title: 'Data Master Disimpan', message: 'Dokter ' + namaDokter + ' berhasil ditambahkan ke sistem.' }
            }));
        },
        tambahMasterPoliSubmit() {
            if (!this.newMasterPoli.nama.trim()) {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { type: 'error', title: 'Input Gagal', message: 'Nama poliklinik wajib diisi!' }
                }));
                return;
            }
            let namaPoli = this.newMasterPoli.nama;
            this.masterPoli.unshift({ ...this.newMasterPoli });
            this.newMasterPoli = { nama: '', ruang: '', jam: '08:00 - 16:00', dokterJaga: '', status: 'Buka' };
            this.showMasterAddForm = false;

            window.dispatchEvent(new CustomEvent('notify', {
                detail: { type: 'success', title: 'Data Master Disimpan', message: 'Poliklinik ' + namaPoli + ' berhasil didaftarkan.' }
            }));
        },
        tambahMasterTindakanSubmit() {
            if (!this.newMasterTindakan.nama.trim()) {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { type: 'error', title: 'Input Gagal', message: 'Nama tindakan medis wajib diisi!' }
                }));
                return;
            }
            if (!this.newMasterTindakan.kode.trim()) {
                this.newMasterTindakan.kode = 'TDK-00' + (this.masterTindakan.length + 1);
            }
            if (!this.newMasterTindakan.tarif.trim().startsWith('Rp')) {
                this.newMasterTindakan.tarif = 'Rp ' + this.newMasterTindakan.tarif.trim();
            }
            let namaTindakan = this.newMasterTindakan.nama;
            let kodeTindakan = this.newMasterTindakan.kode;
            this.masterTindakan.unshift({ ...this.newMasterTindakan });
            this.newMasterTindakan = { kode: '', nama: '', poli: 'Poli Umum', tarif: '', kategori: 'Pemeriksaan' };
            this.showMasterAddForm = false;

            window.dispatchEvent(new CustomEvent('notify', {
                detail: { type: 'success', title: 'Data Master Disimpan', message: 'Tindakan ' + namaTindakan + ' (' + kodeTindakan + ') berhasil didaftarkan.' }
            }));
        },
        masterDokter: [
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
        ],

        // Statistical Analytics Datasets
        trafficData: [
            { jam: '08:00', pasien: 8, height: '32%', peak: false },
            { jam: '09:00', pasien: 17, height: '68%', peak: true },
            { jam: '10:00', pasien: 21, height: '84%', peak: true },
            { jam: '11:00', pasien: 15, height: '60%', peak: false },
            { jam: '12:00', pasien: 6, height: '24%', peak: false },
            { jam: '13:00', pasien: 11, height: '44%', peak: false },
            { jam: '14:00', pasien: 16, height: '64%', peak: false },
            { jam: '15:00', pasien: 10, height: '40%', peak: false },
            { jam: '16:00', pasien: 5, height: '20%', peak: false },
        ],
        poliStats: [
            { id: 'umum', nama: 'Poli Umum', dokter: 'dr. Rina Kusuma', ruang: 'R. 101', kuota: 50, terisi: 38, dipanggil: 'A-014', sisa: 12, avgWait: '12 min', status: 'Optimal', badgeColor: 'emerald', barColor: 'bg-[#009669]' },
            { id: 'gigi', nama: 'Poli Gigi & Mulut', dokter: 'drg. Hendra P.', ruang: 'R. 103', kuota: 30, terisi: 26, dipanggil: 'B-008', sisa: 6, avgWait: '18 min', status: 'Terkendali', badgeColor: 'blue', barColor: 'bg-blue-600' },
            { id: 'anak', nama: 'Poli Anak (Pediatri)', dokter: 'dr. Sari Dewi, Sp.A', ruang: 'R. 201', kuota: 30, terisi: 18, dipanggil: 'C-005', sisa: 4, avgWait: '10 min', status: 'Lancar', badgeColor: 'purple', barColor: 'bg-purple-600' },
            { id: 'farmasi', nama: 'Unit Farmasi & Apotek', dokter: 'Apt. Farhan, S.Farm', ruang: 'Lobby Farmasi', kuota: 90, terisi: 68, dipanggil: 'R-035', sisa: 8, avgWait: '7 min', status: 'Siap Layanan', badgeColor: 'amber', barColor: 'bg-amber-500' },
        ],
        topDiagnosa: [
            { icd: 'J06.9', nama: 'Infeksi Saluran Pernapasan Akut (ISPA)', count: 28, pct: 32, poli: 'Poli Umum / Anak', barColor: 'bg-[#009669]' },
            { icd: 'I10', nama: 'Hipertensi Esensial / Primer', count: 21, pct: 24, poli: 'Poli Umum', barColor: 'bg-blue-600' },
            { icd: 'K30', nama: 'Dispepsia & Gangguan Lambung', count: 16, pct: 18, poli: 'Poli Umum', barColor: 'bg-teal-600' },
            { icd: 'K04.0', nama: 'Pulpitis Akut & Karies Dentis', count: 12, pct: 14, poli: 'Poli Gigi', barColor: 'bg-indigo-600' },
            { icd: 'L20', nama: 'Dermatitis Atopik & Reaksi Alergi', count: 9, pct: 12, poli: 'Poli Umum / Anak', barColor: 'bg-amber-500' },
        ],
        demografiUsia: [
            { grup: 'Anak (0 - 14 th)', count: 18, pct: 21, color: 'bg-purple-500' },
            { grup: 'Usia Produktif (15 - 54 th)', count: 49, pct: 57, color: 'bg-[#009669]' },
            { grup: 'Lansia (≥ 55 th)', count: 19, pct: 22, color: 'bg-blue-500' },
        ],
        waktuLayanan: [
            { tahap: 'Registrasi & Triage', durasi: '3.4 min', target: '< 5 min', status: 'Optimal', iconBg: 'bg-emerald-50 text-emerald-700' },
            { tahap: 'Pemeriksaan Tanda Vital', durasi: '4.8 min', target: '< 7 min', status: 'Optimal', iconBg: 'bg-blue-50 text-blue-700' },
            { tahap: 'Konsultasi & Pemeriksaan Dokter', durasi: '12.5 min', target: '10-15 min', status: 'Sesuai SOP', iconBg: 'bg-indigo-50 text-indigo-700' },
            { tahap: 'Peracikan & Penyerahan E-Resep', durasi: '6.8 min', target: '< 10 min', status: 'Sangat Cepat', iconBg: 'bg-purple-50 text-purple-700' },
        ]
    }"
    x-on:switch-tab.window="activeTab = $event.detail.tab; $nextTick(() => { document.getElementById('section-content')?.scrollIntoView({behavior: 'smooth'}); })"
    x-on:open-modal.window="if ($event.detail.name === 'obat') showObatModal = true; if ($event.detail.name === 'resep') showResepModal = true; if ($event.detail.name === 'master') { showMasterModal = true; if ($event.detail.tab) masterTab = $event.detail.tab; if ($event.detail.add) showMasterAddForm = true; }"
    x-on:close-modals.window="showObatModal = false; showResepModal = false; showMasterModal = false; showMasterAddForm = false;"
    class="font-sans"
    >

        <!-- ================= HERO OVERVIEW BANNER (Matching Patient Style) ================= -->
        <div class="bg-white rounded-3xl border border-slate-100 p-6 sm:p-7 shadow-[0_4px_25px_rgba(0,0,0,0.02)] mb-7">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <span class="px-3 py-1 bg-[#e6f4ea] text-[#137333] border border-emerald-200/60 rounded-full text-[11px] font-extrabold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#009669] animate-pulse"></span>
                            Live Analytics Hari Ini
                        </span>
                        <span class="text-xs text-slate-400 font-medium">
                            Pembaruan Terakhir: {{ now()->locale('id')->isoFormat('dddd, D MMMM Y • HH:mm') }} WIB
                        </span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Overview Operasional Klinik</h2>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-2xl leading-relaxed">
                        Pantau evaluasi real-time arus kunjungan pasien, kuota per poliklinik, efisiensi waktu antrian, serta ketersediaan stok obat secara terpadu.
                    </p>
                </div>

                <!-- Quick Summary Stats Pills -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                    <div class="bg-slate-50 rounded-2xl p-3.5 border border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#009669] text-white flex items-center justify-center font-black text-base shadow-2xs">
                            86
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold block">Pasien Terlayani</span>
                            <span class="text-xs font-extrabold text-slate-800">71.6% dari Kuota 120</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-3.5 border border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black text-base shadow-2xs">
                            4
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold block">Dokter Jaga Aktif</span>
                            <span class="text-xs font-extrabold text-slate-800">3 Poli Beroperasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= 4 KEY PERFORMANCE METRIC CARDS ================= -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-7">
            <!-- 1. Pasien Terdaftar & Breakdown -->
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Arus Pasien Hari Ini</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-[#009669] flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline justify-between gap-2 flex-wrap">
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-black text-slate-900">86</span>
                            <span class="text-[11px] text-[#009669] font-extrabold bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100 shrink-0">▲ +14.2%</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Target kuota harian: 120 pasien</p>
                    
                    <!-- Breakdown Bar -->
                    <div class="w-full bg-slate-100 h-2 rounded-full mt-3 overflow-hidden flex shadow-2xs">
                        <div class="bg-[#009669] h-full" style="width: 49%;" title="42 Selesai"></div>
                        <div class="bg-blue-500 h-full" style="width: 21%;" title="18 Diperiksa"></div>
                        <div class="bg-amber-400 h-full" style="width: 30%;" title="26 Menunggu"></div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-1.5 text-[10px] text-slate-500 mt-2.5 font-bold">
                        <span class="text-emerald-700 flex items-center gap-1 shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-[#009669]"></span> 42 Selesai</span>
                        <span class="text-blue-700 flex items-center gap-1 shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> 18 Diperiksa</span>
                        <span class="text-amber-700 flex items-center gap-1 shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> 26 Antri</span>
                    </div>
                </div>
            </div>

            <!-- 2. Kecepatan Pelayanan (Cycle Time) -->
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kecepatan Pelayanan</span>
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-slate-900">27.5</span>
                        <span class="text-xs text-slate-500 font-bold whitespace-nowrap">Menit / Pasien</span>
                    </div>
                    <p class="text-xs text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                        <span>▼ 3.2 menit lebih cepat dari target</span>
                    </p>
                    
                    <div class="mt-3 p-2 rounded-xl bg-blue-50/60 border border-blue-100 flex items-center justify-between gap-2 text-xs">
                        <span class="text-blue-900 font-bold text-[11px] truncate">SLA Standar SOP:</span>
                        <span class="px-2 py-0.5 rounded-md bg-blue-600 text-white font-extrabold text-[10px] shrink-0 whitespace-nowrap">Maks 35 Menit</span>
                    </div>
                </div>
            </div>

            <!-- 3. Tingkat Okupansi Poli -->
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tingkat Okupansi Poli</span>
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-slate-900">82%</span>
                        <span class="text-xs text-purple-700 font-bold bg-purple-50 px-2 py-0.5 rounded-md border border-purple-100">Optimal</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Beban kerja dokter & ruang tindakan</p>

                    <div class="mt-3 flex items-center justify-between flex-wrap gap-1 text-[11px] font-semibold text-slate-600">
                        <span class="shrink-0">Poli Gigi: 86%</span>
                        <span class="shrink-0">Poli Umum: 76%</span>
                        <span class="shrink-0">Poli Anak: 60%</span>
                    </div>
                </div>
            </div>

            <!-- 4. Kepuasan Pasien & Resolusi -->
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kepuasan Pasien</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline justify-between gap-2 flex-wrap">
                        <span class="text-3xl font-black text-slate-900">98.4%</span>
                        <span class="text-[11px] text-amber-700 font-bold bg-amber-50 px-2 py-0.5 rounded-md border border-amber-100 shrink-0 whitespace-nowrap">★ 4.9 / 5.0</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Berdasarkan 64 umpan balik pasien</p>

                    <div class="mt-3 p-2 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-100 text-[11px] font-bold flex items-center justify-between gap-2">
                        <span class="truncate">Tingkat Resolusi Kasus:</span>
                        <span class="text-emerald-700 font-extrabold shrink-0 whitespace-nowrap">96.8% Tuntas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= SECTION TABS NAVIGATOR (#section-content) ================= -->
        <div id="section-content" class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <!-- Tabs Switcher Pills -->
            <div class="p-1 bg-slate-200/60 rounded-2xl inline-flex gap-1 border border-slate-200/50 w-full sm:w-auto">
                <button @click="activeTab = 'overview'" 
                        :class="activeTab === 'overview' ? 'bg-white text-[#137333] font-extrabold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                        class="flex-1 sm:flex-initial px-4 py-2 rounded-xl text-xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>Overview Analisis</span>
                </button>
                <button @click="activeTab = 'obat'" 
                        :class="activeTab === 'obat' ? 'bg-white text-[#137333] font-extrabold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                        class="flex-1 sm:flex-initial px-4 py-2 rounded-xl text-xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    <span>Sediaan Obat & Stok</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full bg-slate-100 font-bold" x-text="obatList.length"></span>
                </button>
                <button @click="activeTab = 'resep'" 
                        :class="activeTab === 'resep' ? 'bg-white text-[#137333] font-extrabold shadow-xs' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                        class="flex-1 sm:flex-initial px-4 py-2 rounded-xl text-xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>E-Resep & Farmasi</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full bg-slate-100 font-bold" x-text="resepList.length"></span>
                </button>
            </div>

            <!-- Tab Context Action -->
            <div class="flex items-center gap-2">
                <template x-if="activeTab === 'obat'">
                    <button @click="showObatModal = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-[#009669] hover:bg-[#007a55] text-white font-bold rounded-xl text-xs shadow-xs transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Obat</span>
                    </button>
                </template>
                <template x-if="activeTab === 'resep'">
                    <button @click="showResepModal = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>Buat E-Resep</span>
                    </button>
                </template>
                <template x-if="activeTab === 'overview'">
                    <button @click="openClinicModal('master')" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 transition-all cursor-pointer">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16"/></svg>
                        <span>Pusat Data Master</span>
                    </button>
                </template>
            </div>
        </div>

        <!-- ================= TAB 1: OVERVIEW ANALISIS ================= -->
        <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-7">
            
            <!-- ROW 1: HOURLY PATIENT TRAFFIC & POLIKLINIK CONDITIONS -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
                
                <!-- LEFT 7 COLS: Hourly Patient Traffic Chart -->
                <div class="xl:col-span-7 bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                    <div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
                            <div>
                                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#009669]"></span>
                                    Grafik Arus Kunjungan Pasien per Jam
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">Sebaran kedatangan pasien operasional 08:00 - 16:00 WIB</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs font-bold">
                                <span class="flex items-center gap-1.5 text-slate-600 shrink-0">
                                    <span class="w-3 h-3 rounded-md bg-[#009669]"></span> Normal
                                </span>
                                <span class="flex items-center gap-1.5 text-orange-600 shrink-0">
                                    <span class="w-3 h-3 rounded-md bg-orange-500"></span> Puncak (Peak)
                                </span>
                            </div>
                        </div>

                        <!-- Bar Chart Visual with Y-Axis Scale -->
                        <div class="pt-2 pb-2 px-1">
                            <div class="flex items-stretch h-56">
                                <!-- Dedicated Y-Axis Scale -->
                                <div class="w-10 sm:w-12 flex flex-col justify-between text-[11px] font-bold text-slate-400 pb-7 pr-2.5 text-right select-none border-r border-slate-200 shrink-0">
                                    <span>25</span>
                                    <span>20</span>
                                    <span>15</span>
                                    <span>10</span>
                                    <span>5</span>
                                    <span>0</span>
                                </div>

                                <!-- Chart Canvas Bars -->
                                <div class="flex-1 relative pl-2 sm:pl-4 flex items-end justify-between gap-1 sm:gap-3 border-b border-slate-200 pb-2">
                                    <!-- Background grid lines -->
                                    <div class="absolute inset-x-0 inset-y-0 flex flex-col justify-between pointer-events-none opacity-40 pb-7 pl-2 sm:pl-4">
                                        <div class="border-b border-dashed border-slate-200 w-full"></div>
                                        <div class="border-b border-dashed border-slate-200 w-full"></div>
                                        <div class="border-b border-dashed border-slate-200 w-full"></div>
                                        <div class="border-b border-dashed border-slate-200 w-full"></div>
                                        <div class="border-b border-dashed border-slate-200 w-full"></div>
                                    </div>

                                    <template x-for="item in trafficData" :key="item.jam">
                                        <div class="flex-1 min-w-0 flex flex-col items-center group relative z-10 h-full justify-end">
                                            <!-- Tooltip hover -->
                                            <div class="absolute -top-9 opacity-0 group-hover:opacity-100 transition-opacity bg-slate-900 text-white text-[10px] font-bold py-1 px-2.5 rounded-lg whitespace-nowrap pointer-events-none shadow-xl z-30">
                                                <span x-text="item.pasien + ' Pasien (' + item.jam + ')'"></span>
                                            </div>
                                            
                                            <!-- Value label on top of bar -->
                                            <span class="text-[11px] font-black mb-1.5 transition-colors shrink-0" 
                                                  :class="item.peak ? 'text-orange-600' : 'text-slate-700'" 
                                                  x-text="item.pasien"></span>

                                            <!-- Bar Pillar -->
                                            <div class="w-full max-w-[36px] sm:max-w-[42px] rounded-t-xl transition-all duration-300 group-hover:brightness-95 shadow-2xs"
                                                 :style="'height: ' + item.height"
                                                 :class="item.peak ? 'bg-orange-500' : 'bg-[#009669]'">
                                            </div>

                                            <!-- Hour Label -->
                                            <span class="text-[10px] font-extrabold text-slate-400 mt-2 block whitespace-nowrap" x-text="item.jam"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Insight Alert Box -->
                    <div class="mt-4 p-3.5 rounded-2xl bg-amber-50/70 border border-amber-200/70 flex items-start gap-3 text-xs">
                        <div class="p-1 rounded-lg bg-amber-500 text-white shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <span class="font-extrabold text-amber-900">Analisis Beban Puncak:</span>
                            <p class="text-amber-800/90 mt-0.5 leading-relaxed">
                                Puncak arus antrian terjadi pada rentang <strong>09:00 - 11:00 WIB</strong> (total 38 pasien, 44.1% dari kunjungan). Waktu tunggu rata-rata tetap stabil di bawah batas target SOP.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT 5 COLS: Kondisi Real-Time Poliklinik & Dokter Jaga -->
                <div class="xl:col-span-5 bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4 gap-2">
                            <div>
                                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                    Kondisi Poli & Dokter Jaga
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">Monitoring kuota & antrian per poliklinik</p>
                            </div>
                            <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0 whitespace-nowrap">
                                Semua Aktif
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-1 gap-3 mt-2">
                            <template x-for="p in poliStats" :key="p.id">
                                <div class="p-3.5 rounded-2xl border border-slate-150 hover:border-slate-300 transition-all bg-slate-50/50">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <h4 class="font-black text-sm text-slate-900 leading-tight" x-text="p.nama"></h4>
                                                <span class="text-[10px] font-bold text-slate-400 shrink-0" x-text="'(' + p.ruang + ')'"></span>
                                            </div>
                                            <p class="text-xs font-semibold text-slate-600 mt-1 flex items-center gap-1 truncate">
                                                <span class="text-slate-400 shrink-0">Dokter:</span> 
                                                <span class="text-slate-900 font-bold truncate" x-text="p.dokter"></span>
                                            </p>
                                        </div>
                                        <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-white border border-slate-200 text-slate-700 shrink-0 whitespace-nowrap" x-text="p.status"></span>
                                    </div>

                                    <div class="mt-3 pt-2 border-t border-slate-200/60 flex items-center justify-between text-xs gap-2">
                                        <div class="flex items-center gap-1.5 shrink-0">
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Antrian:</span>
                                            <span class="px-2 py-0.5 bg-slate-900 text-white font-mono font-black text-xs rounded-lg shadow-2xs" x-text="p.dipanggil"></span>
                                        </div>
                                        <div class="text-right shrink-0 text-[11px] font-bold">
                                            <span class="text-slate-500" x-text="'Sisa: ' + p.sisa"></span>
                                            <span class="text-emerald-700 font-extrabold ml-1.5" x-text="'• ' + p.avgWait"></span>
                                        </div>
                                    </div>

                                    <!-- Mini Capacity Bar -->
                                    <div class="w-full bg-slate-200 h-1.5 rounded-full mt-2.5 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500" :class="p.barColor" :style="'width: ' + Math.round((p.terisi / p.kuota) * 100) + '%'"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="mt-4 p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between text-xs text-slate-600 flex-wrap gap-2">
                        <span>Total Kapasitas Kuota: <strong class="text-slate-900 font-bold">200 Pasien</strong></span>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-black text-[10px]">Terpenuhi: 75.0%</span>
                    </div>
                </div>
            </div>

            <!-- ROW 2: TOP DIAGNOSIS, DEMOGRAFI & DURASI LAYANAN -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                
                <!-- 1. Top 5 Diagnosa & Kasus Medis Hari Ini -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                                    Kasus & Diagnosa Terbanyak
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">Rekapitulasi 5 besar ICD-10 pasien hari ini</p>
                            </div>
                        </div>

                        <div class="space-y-3.5 mt-3">
                            <template x-for="d in topDiagnosa" :key="d.icd">
                                <div>
                                    <div class="flex items-start justify-between text-xs mb-1.5 gap-2">
                                        <div class="flex items-baseline gap-1.5 min-w-0 flex-1">
                                            <span class="font-mono font-extrabold text-[10px] bg-slate-100 text-slate-700 px-1.5 py-0.5 rounded shrink-0" x-text="d.icd"></span>
                                            <span class="font-bold text-slate-800 leading-snug break-words" x-text="d.nama"></span>
                                        </div>
                                        <span class="font-black text-slate-900 shrink-0 whitespace-nowrap text-right ml-1" x-text="d.count + ' (' + d.pct + '%)'"></span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500" :class="d.barColor" :style="'width: ' + d.pct + '%'"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <p class="text-[11px] text-slate-400 mt-4 pt-3 border-t border-slate-100">
                        Data terhubung otomatis dengan modul Rekam Medis (EMR).
                    </p>
                </div>

                <!-- 2. Demografi Penjaminan & Kelompok Usia -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#009669]"></span>
                                    Demografi & Penjaminan Pasien
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">Distribusi skema penjaminan & rentang umur</p>
                            </div>
                        </div>

                        <!-- Skema Penjaminan Stacked -->
                        <div class="mt-3">
                            <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block mb-2">Tipe Jaminan Pasien</span>
                            <div class="w-full h-3.5 rounded-xl overflow-hidden flex shadow-2xs">
                                <div class="bg-[#009669] h-full" style="width: 58%;" title="BPJS: 58%"></div>
                                <div class="bg-indigo-600 h-full" style="width: 26%;" title="LPSK: 26%"></div>
                                <div class="bg-amber-500 h-full" style="width: 16%;" title="Umum: 16%"></div>
                            </div>
                            <div class="flex flex-wrap justify-between gap-1 text-[11px] mt-2.5 font-bold">
                                <span class="text-emerald-700 flex items-center gap-1 shrink-0"><span class="w-2 h-2 rounded-full bg-[#009669]"></span> BPJS 58%</span>
                                <span class="text-indigo-700 flex items-center gap-1 shrink-0"><span class="w-2 h-2 rounded-full bg-indigo-600"></span> LPSK 26%</span>
                                <span class="text-amber-700 flex items-center gap-1 shrink-0"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Umum 16%</span>
                            </div>
                        </div>

                        <!-- Kelompok Usia Breakdown -->
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block mb-2.5">Distribusi Kelompok Umur</span>
                            <div class="space-y-2.5">
                                <template x-for="u in demografiUsia" :key="u.grup">
                                    <div>
                                        <div class="flex justify-between items-center text-xs font-semibold mb-1 text-slate-700 gap-2">
                                            <span class="font-bold text-slate-800" x-text="u.grup"></span>
                                            <span class="font-black text-slate-900 shrink-0 whitespace-nowrap" x-text="u.count + ' Pasien (' + u.pct + '%)'"></span>
                                        </div>
                                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full" :class="u.color" :style="'width: ' + u.pct + '%'"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-2 text-[11px] text-slate-400">
                        Didominasi oleh usia produktif pegawai & terlindung LPSK.
                    </div>
                </div>

                <!-- 3. Alur Kecepatan Layanan Pasien -->
                <div class="lg:col-span-2 xl:col-span-1 bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-black text-slate-900 text-base flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span>
                                    Analisis Durasi Layanan Pasien
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">Waktu rata-rata per tahapan alur (SLA SOP)</p>
                            </div>
                        </div>

                        <div class="space-y-2.5 mt-3 relative before:absolute before:left-3 before:top-3 before:bottom-3 before:w-0.5 before:bg-slate-200">
                            <template x-for="(w, idx) in waktuLayanan" :key="w.tahap">
                                <div class="relative flex items-center gap-3 pl-0.5">
                                    <div class="w-5 h-5 rounded-full flex items-center justify-center font-black text-[10px] z-10 shrink-0 shadow-2xs" :class="w.iconBg">
                                        <span x-text="idx + 1"></span>
                                    </div>
                                    <div class="flex-1 min-w-0 p-3 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between gap-3">
                                        <div class="min-w-0 flex-1">
                                            <h5 class="text-xs font-bold text-slate-900 leading-snug" x-text="w.tahap"></h5>
                                            <p class="text-[10px] text-slate-400 font-medium mt-0.5" x-text="'Target SOP: ' + w.target"></p>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <span class="text-xs font-black text-[#009669] font-mono whitespace-nowrap block" x-text="w.durasi"></span>
                                            <span class="inline-block mt-0.5 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-100 text-[9px] font-extrabold uppercase whitespace-nowrap" x-text="w.status"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="mt-4 p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-100 flex items-center justify-between gap-3 flex-wrap">
                        <div>
                            <span class="text-xs font-black text-emerald-950 block">Total Waktu Alur</span>
                            <span class="text-[10px] text-emerald-700 font-medium">Door-to-Door Datang s/d Pulang</span>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="font-black text-[#009669] text-lg font-mono">27.5</span>
                            <span class="text-xs font-bold text-emerald-700 ml-0.5">Menit</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= TAB 2: SEDIAAN OBAT & STOK ================= -->
        <div x-show="activeTab === 'obat'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display: none;">
            
            <!-- Table Card -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
                <!-- Search & Filters -->
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white">
                    <div>
                        <h3 class="font-black text-slate-900 text-base">Inventaris Sediaan Obat & Stok Farmasi</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Pantau batas minimum sediaan dan ketersediaan obat klinik</p>
                    </div>
                    <div class="w-full sm:w-72">
                        <div class="relative">
                            <input x-model="searchObat" type="text" placeholder="Cari nama, kode, atau kategori..." class="w-full pl-9 pr-4 py-2 bg-[#f1f5f9] text-xs font-medium text-slate-700 rounded-xl border-0 focus:ring-2 focus:ring-emerald-500">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                <th class="py-3 px-5">Kode Obat</th>
                                <th class="py-3 px-5">Nama Sediaan</th>
                                <th class="py-3 px-5">Bentuk / Satuan</th>
                                <th class="py-3 px-5">Kategori / Golongan</th>
                                <th class="py-3 px-5 text-right">Stok Fisik</th>
                                <th class="py-3 px-5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-sans">
                            <template x-for="item in filteredObatList" :key="item.kode">
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-5 font-mono font-bold text-slate-700" x-text="item.kode"></td>
                                    <td class="py-3.5 px-5">
                                        <span class="font-bold text-slate-900 block" x-text="item.nama"></span>
                                        <span class="text-[10px] text-slate-400 font-medium" x-text="'Batas min: ' + item.minStok + ' ' + item.satuan"></span>
                                    </td>
                                    <td class="py-3.5 px-5 text-slate-600" x-text="item.sediaan + ' (' + item.satuan + ')'"></td>
                                    <td class="py-3.5 px-5 text-slate-600" x-text="item.kategori"></td>
                                    <td class="py-3.5 px-5 text-right font-black text-slate-900" x-text="item.stok + ' ' + item.satuan"></td>
                                    <td class="py-3.5 px-5 text-center">
                                        <span :class="item.status === 'Aman' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : (item.status === 'Menipis' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200')"
                                              class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border"
                                              x-text="item.status">
                                        </span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs text-slate-500">
                    <span x-text="'Menampilkan ' + filteredObatList.length + ' dari total ' + obatList.length + ' item obat'"></span>
                    <button @click="showObatModal = true" class="text-xs font-bold text-[#009669] hover:underline cursor-pointer">
                        + Tambah Sediaan Baru
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= TAB 3: E-RESEP & FARMASI ================= -->
        <div x-show="activeTab === 'resep'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display: none;">
            
            <!-- Resep Table Card -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] overflow-hidden">
                <!-- Search & Header -->
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white">
                    <div>
                        <h3 class="font-black text-slate-900 text-base">Antrian E-Resep & Penyerahan Obat</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Pantau status peracikan dan penyerahan obat ke pasien klinik</p>
                    </div>
                    <div class="w-full sm:w-72">
                        <div class="relative">
                            <input x-model="searchResep" type="text" placeholder="Cari nomor resep, pasien, dokter..." class="w-full pl-9 pr-4 py-2 bg-[#f1f5f9] text-xs font-medium text-slate-700 rounded-xl border-0 focus:ring-2 focus:ring-emerald-500">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                <th class="py-3 px-5">No. Resep</th>
                                <th class="py-3 px-5">Pasien</th>
                                <th class="py-3 px-5">Poli & Dokter</th>
                                <th class="py-3 px-5">Rincian Obat</th>
                                <th class="py-3 px-5 text-center">Status</th>
                                <th class="py-3 px-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-sans">
                            <template x-for="(r, idx) in filteredResepList" :key="r.no">
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-5">
                                        <span class="font-mono font-bold text-slate-800 block" x-text="r.no"></span>
                                        <span class="text-[10px] text-slate-400" x-text="r.waktu + ' WIB'"></span>
                                    </td>
                                    <td class="py-3.5 px-5 font-bold text-slate-900" x-text="r.pasien"></td>
                                    <td class="py-3.5 px-5">
                                        <span class="font-semibold text-slate-800 block" x-text="r.poli"></span>
                                        <span class="text-[10px] text-slate-400" x-text="r.dokter"></span>
                                    </td>
                                    <td class="py-3.5 px-5 text-slate-600 max-w-xs truncate" x-text="r.item"></td>
                                    <td class="py-3.5 px-5 text-center">
                                        <span :class="r.status === 'Diserahkan' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : (r.status === 'Siap Diambil' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-amber-50 text-amber-700 border-amber-200')"
                                              class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border"
                                              x-text="r.status">
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-5 text-right">
                                        <template x-if="r.status === 'Disiapkan'">
                                            <button @click="updateResepStatus(idx, 'Siap Diambil')" class="px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-[10px] font-bold shadow-2xs transition-colors cursor-pointer">
                                                Siap Diambil
                                            </button>
                                        </template>
                                        <template x-if="r.status === 'Siap Diambil'">
                                            <button @click="updateResepStatus(idx, 'Diserahkan')" class="px-2.5 py-1 bg-[#009669] hover:bg-[#007a55] text-white rounded-lg text-[10px] font-bold shadow-2xs transition-colors cursor-pointer">
                                                Serahkan
                                            </button>
                                        </template>
                                        <template x-if="r.status === 'Diserahkan'">
                                            <span class="text-[11px] text-slate-400 font-semibold">Tuntas</span>
                                        </template>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs text-slate-500">
                    <span x-text="'Menampilkan ' + filteredResepList.length + ' antrian resep'"></span>
                    <button @click="showResepModal = true" class="text-xs font-bold text-purple-600 hover:underline cursor-pointer">
                        + Terbitkan E-Resep Baru
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= MODALS ================= -->

        <!-- 1. MODAL TAMBAH OBAT & SEDIAAN -->
        <div x-show="showObatModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-xs"
             style="display: none;"
             x-transition>
            <div @click.away="showObatModal = false" class="bg-white w-full max-w-md rounded-3xl shadow-2xl border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-emerald-50/50">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Tambah Obat / Sediaan</h3>
                        <p class="text-[11px] text-slate-500">Input sediaan farmasi ke basis data klinik</p>
                    </div>
                    <button @click="showObatModal = false" class="text-slate-400 hover:text-slate-700 p-1 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form @submit.prevent="tambahObatSubmit()" class="p-5 space-y-3.5 font-sans">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Obat & Dosis</label>
                        <input x-model="newObat.nama" type="text" placeholder="Contoh: Amoxicillin 500mg" required class="w-full py-2.5 px-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Bentuk Sediaan</label>
                            <select x-model="newObat.sediaan" class="w-full py-2.5 px-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs bg-white">
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
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Satuan</label>
                            <input x-model="newObat.satuan" type="text" placeholder="Tablet/Botol" required class="w-full py-2.5 px-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Kategori / Golongan</label>
                        <input x-model="newObat.kategori" type="text" placeholder="Contoh: Antibiotik / Analgesik" required class="w-full py-2.5 px-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Stok Awal</label>
                            <input x-model="newObat.stok" type="number" placeholder="100" required class="w-full py-2.5 px-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Batas Minimum</label>
                            <input x-model="newObat.minStok" type="number" placeholder="20" required class="w-full py-2.5 px-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs">
                        </div>
                    </div>

                    <div class="pt-3 flex gap-2.5">
                        <button type="button" @click="showObatModal = false" class="flex-1 py-2.5 bg-white text-slate-700 font-bold border border-slate-200 rounded-xl text-xs transition-colors hover:bg-slate-50 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-2.5 bg-[#009669] text-white font-bold rounded-xl text-xs shadow-sm transition-colors hover:bg-[#007a55] cursor-pointer">
                            Simpan Obat
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 2. MODAL BUAT RESEP BARU -->
        <div x-show="showResepModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-xs"
             style="display: none;"
             x-transition>
            <div @click.away="showResepModal = false" class="bg-white w-full max-w-md rounded-3xl shadow-2xl border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-purple-50/50">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Buat E-Resep Baru</h3>
                        <p class="text-[11px] text-slate-500">Kirim resep digital ke bagian farmasi klinik</p>
                    </div>
                    <button @click="showResepModal = false" class="text-slate-400 hover:text-slate-700 p-1 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form @submit.prevent="tambahResepSubmit()" class="p-5 space-y-3.5 font-sans">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Pasien</label>
                        <input x-model="newResep.pasien" type="text" placeholder="Masukkan nama pasien & umur" required class="w-full py-2.5 px-3.5 rounded-xl border border-slate-200 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Poli Layanan</label>
                            <select x-model="newResep.poli" class="w-full py-2.5 px-3.5 rounded-xl border border-slate-200 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-xs bg-white">
                                <option value="Poli Umum">Poli Umum</option>
                                <option value="Poli Gigi">Poli Gigi</option>
                                <option value="Poli Anak">Poli Anak</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Dokter Peresep</label>
                            <select x-model="newResep.dokter" class="w-full py-2.5 px-3.5 rounded-xl border border-slate-200 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-xs bg-white">
                                <option value="dr. Rina Kusuma">dr. Rina Kusuma</option>
                                <option value="drg. Hendra P.">drg. Hendra P.</option>
                                <option value="dr. Budi Santoso">dr. Budi Santoso</option>
                                <option value="dr. Sari Dewi">dr. Sari Dewi</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Rincian Obat & Aturan Pakai</label>
                        <textarea x-model="newResep.item" rows="3" placeholder="Contoh: Paracetamol 500mg (3x1 tab sesudah makan), Cetirizine 10mg (1x1 malam)" required class="w-full py-2.5 px-3.5 rounded-xl border border-slate-200 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 text-xs"></textarea>
                    </div>

                    <div class="pt-3 flex gap-2.5">
                        <button type="button" @click="showResepModal = false" class="flex-1 py-2.5 bg-white text-slate-700 font-bold border border-slate-200 rounded-xl text-xs transition-colors hover:bg-slate-50 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-2.5 bg-purple-600 text-white font-bold rounded-xl text-xs shadow-sm transition-colors hover:bg-purple-700 cursor-pointer">
                            Kirim ke Farmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 3. MODAL DATA MASTER -->
        <div x-show="showMasterModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-xs"
             style="display: none;"
             x-transition>
            <div @click.away="showMasterModal = false" class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl border border-slate-100 overflow-hidden flex flex-col max-h-[90vh]">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Pusat Data Master Klinik</h3>
                        <p class="text-xs text-slate-500">Kelola master dokter, poli layanan, tindakan & tarif medis</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                @click="showMasterAddForm = !showMasterAddForm" 
                                class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shadow-2xs flex items-center gap-1.5 border cursor-pointer"
                                :class="showMasterAddForm ? 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' : 'bg-[#009669] text-white border-emerald-600 hover:bg-[#007a55]'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" :d="showMasterAddForm ? 'M6 18L18 6M6 6l12 12' : 'M12 4v16m8-8H4'"/>
                            </svg>
                            <span x-text="showMasterAddForm ? 'Tutup Form' : ('Tambah ' + (masterTab === 'dokter' ? 'Dokter' : (masterTab === 'poli' ? 'Poli' : 'Tindakan')))"></span>
                        </button>
                        <button type="button" @click="showMasterModal = false" class="text-slate-400 hover:text-slate-700 p-1 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Master Sub Tabs -->
                <div class="flex border-b border-slate-100 px-6 pt-3 gap-4 bg-slate-50/50">
                    <button @click="masterTab = 'dokter'" :class="masterTab === 'dokter' ? 'border-[#009669] text-[#137333] font-bold' : 'border-transparent text-slate-500 font-semibold'" class="pb-3 px-1 border-b-2 text-xs transition-colors cursor-pointer">
                        Master Dokter (<span x-text="masterDokter.length"></span>)
                    </button>
                    <button @click="masterTab = 'poli'" :class="masterTab === 'poli' ? 'border-[#009669] text-[#137333] font-bold' : 'border-transparent text-slate-500 font-semibold'" class="pb-3 px-1 border-b-2 text-xs transition-colors cursor-pointer">
                        Master Poli & Ruangan (<span x-text="masterPoli.length"></span>)
                    </button>
                    <button @click="masterTab = 'tindakan'" :class="masterTab === 'tindakan' ? 'border-[#009669] text-[#137333] font-bold' : 'border-transparent text-slate-500 font-semibold'" class="pb-3 px-1 border-b-2 text-xs transition-colors cursor-pointer">
                        Tindakan & Tarif (<span x-text="masterTindakan.length"></span>)
                    </button>
                </div>

                <!-- Expandable Form Tambah Data Master -->
                <div x-show="showMasterAddForm" x-transition class="p-5 bg-emerald-50/40 border-b border-emerald-100">
                    <!-- 1. Form Tambah Dokter -->
                    <form x-show="masterTab === 'dokter'" @submit.prevent="tambahMasterDokterSubmit()" class="space-y-3">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-black text-emerald-950 uppercase tracking-wide">Formulir Tambah Dokter Baru</span>
                            <span class="text-[11px] text-emerald-700 font-medium">Input ke Master Dokter</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar</label>
                                <input x-model="newMasterDokter.nama" type="text" placeholder="dr. Amanda Putri, Sp.JP" required class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nomor SIP</label>
                                <input x-model="newMasterDokter.sip" type="text" placeholder="SIP.446/115/DINKES/2024" required class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Spesialisasi</label>
                                <input x-model="newMasterDokter.spesialisasi" type="text" placeholder="Dokter Spesialis Jantung" required class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Poliklinik</label>
                                <select x-model="newMasterDokter.poli" class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                                    <option value="Poli Umum">Poli Umum</option>
                                    <option value="Poli Gigi">Poli Gigi</option>
                                    <option value="Poli Anak">Poli Anak</option>
                                    <option value="Poli Spesialis">Poli Spesialis</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-1">
                            <button type="button" @click="showMasterAddForm = false" class="px-3 py-1.5 bg-white text-slate-600 rounded-xl text-xs font-bold border border-slate-200 hover:bg-slate-50 cursor-pointer">Batal</button>
                            <button type="submit" class="px-4 py-1.5 bg-[#009669] hover:bg-[#007a55] text-white rounded-xl text-xs font-bold shadow-2xs cursor-pointer">Simpan Dokter</button>
                        </div>
                    </form>

                    <!-- 2. Form Tambah Poli & Ruangan -->
                    <form x-show="masterTab === 'poli'" @submit.prevent="tambahMasterPoliSubmit()" class="space-y-3">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-black text-emerald-950 uppercase tracking-wide">Formulir Tambah Poliklinik & Ruang</span>
                            <span class="text-[11px] text-emerald-700 font-medium">Input ke Master Poli</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Poliklinik</label>
                                <input x-model="newMasterPoli.nama" type="text" placeholder="Poli Jantung & Vaskular" required class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Lokasi Ruangan</label>
                                <input x-model="newMasterPoli.ruang" type="text" placeholder="Ruang 204 (Lantai 2)" required class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jam Layanan</label>
                                <input x-model="newMasterPoli.jam" type="text" placeholder="08:00 - 16:00" required class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Dokter Jaga Utama</label>
                                <input x-model="newMasterPoli.dokterJaga" type="text" placeholder="dr. Amanda Putri / dr. Budi S." required class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-1">
                            <button type="button" @click="showMasterAddForm = false" class="px-3 py-1.5 bg-white text-slate-600 rounded-xl text-xs font-bold border border-slate-200 hover:bg-slate-50 cursor-pointer">Batal</button>
                            <button type="submit" class="px-4 py-1.5 bg-[#009669] hover:bg-[#007a55] text-white rounded-xl text-xs font-bold shadow-2xs cursor-pointer">Simpan Poliklinik</button>
                        </div>
                    </form>

                    <!-- 3. Form Tambah Tindakan Medis -->
                    <form x-show="masterTab === 'tindakan'" @submit.prevent="tambahMasterTindakanSubmit()" class="space-y-3">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-black text-emerald-950 uppercase tracking-wide">Formulir Tambah Tindakan Medis & Tarif</span>
                            <span class="text-[11px] text-emerald-700 font-medium">Input ke Master Tindakan</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Kode Tindakan</label>
                                <input x-model="newMasterTindakan.kode" type="text" placeholder="Otomatis (contoh: TDK-007)" class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Tindakan Medis</label>
                                <input x-model="newMasterTindakan.nama" type="text" placeholder="Elektrokardiogram (EKG)" required class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Poli Layanan</label>
                                <input x-model="newMasterTindakan.poli" type="text" placeholder="Poli Umum / Gigi" required class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Tarif (Rp)</label>
                                <input x-model="newMasterTindakan.tarif" type="text" placeholder="125.000" required class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Kategori</label>
                                <input x-model="newMasterTindakan.kategori" type="text" placeholder="Tindakan / Pemeriksaan" required class="w-full py-2 px-3 rounded-xl border border-slate-200 text-xs focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-1">
                            <button type="button" @click="showMasterAddForm = false" class="px-3 py-1.5 bg-white text-slate-600 rounded-xl text-xs font-bold border border-slate-200 hover:bg-slate-50 cursor-pointer">Batal</button>
                            <button type="submit" class="px-4 py-1.5 bg-[#009669] hover:bg-[#007a55] text-white rounded-xl text-xs font-bold shadow-2xs cursor-pointer">Simpan Tindakan</button>
                        </div>
                    </form>
                </div>

                <!-- Master Tab Content Area -->
                <div class="p-6 overflow-y-auto flex-1 space-y-3">
                    <!-- Tab Dokter -->
                    <div x-show="masterTab === 'dokter'" class="space-y-2.5">
                        <template x-for="d in masterDokter" :key="d.nama">
                            <div class="p-3.5 rounded-2xl border border-slate-150 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm" x-text="d.nama"></h4>
                                    <p class="text-xs text-emerald-700 font-semibold mt-0.5" x-text="d.spesialisasi + ' • ' + d.poli"></p>
                                    <p class="text-[11px] text-slate-400" x-text="d.sip"></p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200" x-text="d.status"></span>
                                    <p class="text-[11px] text-slate-500 mt-1 font-semibold" x-text="'Sisa Cuti: ' + d.sisaCuti"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Tab Poli -->
                    <div x-show="masterTab === 'poli'" class="space-y-2.5">
                        <template x-for="p in masterPoli" :key="p.nama">
                            <div class="p-3.5 rounded-2xl border border-slate-150 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm" x-text="p.nama"></h4>
                                    <p class="text-xs text-slate-600 mt-0.5" x-text="p.ruang"></p>
                                    <p class="text-[11px] text-slate-400" x-text="'Dokter: ' + p.dokterJaga"></p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold border border-blue-200" x-text="p.jam"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Tab Tindakan -->
                    <div x-show="masterTab === 'tindakan'" class="space-y-2.5">
                        <template x-for="t in masterTindakan" :key="t.kode">
                            <div class="p-3.5 rounded-2xl border border-slate-150 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-extrabold text-slate-700 bg-slate-100 px-2 py-0.5 rounded border border-slate-200" x-text="t.kode"></span>
                                        <h4 class="font-bold text-slate-900 text-sm" x-text="t.nama"></h4>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1" x-text="t.poli + ' • ' + t.kategori"></p>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-black text-[#009669]" x-text="t.tarif"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button @click="showMasterModal = false" class="px-5 py-2 bg-slate-900 text-white font-bold rounded-xl text-xs hover:bg-slate-800 transition-colors cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <div class="h-8"></div>
    </div>
</x-app-layout>
