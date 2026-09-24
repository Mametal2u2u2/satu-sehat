@php
    $user = auth()->user();
    $isStaff = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Fisioterapis', 'Apoteker', 'Approver']);
@endphp

<x-app-layout>
    <div x-data="{ 
        init() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('modal') === 'tambah' || urlParams.get('modal') === 'tambah-pasien' || urlParams.get('modal') === 'daftar') {
                this.showTambahPasienModal = true;
            }
            @if($isStaff)
            if (urlParams.get('modal') === 'panggil') {
                this.showPanggilAntrianModal = true;
            }
            @endif
        },
        showTambahPasienModal: false, 
        showPanggilAntrianModal: false, 
        searchQuery: '', 
        currentFilter: 'Semua Poli', 
        callingNumber: '',
        callSoundPlaying: false,
        queues: [
            {no: 'A-013', name: 'Ahmad Fauzi', poli: 'Poli Umum', doctor: 'dr. Rina Kusuma', status: 'Diperiksa', wait_time: '10 menit', status_color: 'blue'},
            {no: 'B-008', name: 'Siti Rahayu', poli: 'Poli Gigi', doctor: 'drg. Hendra P.', status: 'Menunggu', wait_time: '25 menit', status_color: 'yellow'},
            {no: 'C-005', name: 'Dewi Lestari', poli: 'Poli Anak', doctor: 'dr. Sari Dewi', status: 'Menunggu', wait_time: '40 menit', status_color: 'yellow'},
            {no: 'A-014', name: 'Rudi Hermawan', poli: 'Poli Umum', doctor: 'dr. Budi S.', status: 'Menunggu', wait_time: '55 menit', status_color: 'yellow'},
            {no: 'A-012', name: 'Budi Santoso', poli: 'Poli Umum', doctor: 'dr. Rina Kusuma', status: 'Selesai', wait_time: '-', status_color: 'green'},
            {no: 'B-007', name: 'Indra Wijaya', poli: 'Poli Gigi', doctor: 'drg. Hendra P.', status: 'Selesai', wait_time: '-', status_color: 'green'},
        ],
        newPatient: {
            name: '{{ $isStaff ? '' : addslashes(auth()->user()?->name ?? '') }}',
            poli: 'Poli Umum',
            doctor: 'dr. Rina Kusuma',
            type: 'Pasien Umum'
        },
        doctorsMap: {
            'Poli Umum': ['dr. Rina Kusuma', 'dr. Budi S.'],
            'Poli Gigi': ['drg. Hendra P.', 'drg. Maya Putri'],
            'Poli Anak': ['dr. Sari Dewi']
        },
        updateDoctors() {
            this.newPatient.doctor = this.doctorsMap[this.newPatient.poli][0];
        },
        playNotification() {
            try {
                let ctx = new (window.AudioContext || window.webkitAudioContext)();
                
                // C#5 Chime note
                let osc1 = ctx.createOscillator();
                let gain1 = ctx.createGain();
                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(554.37, ctx.currentTime);
                gain1.gain.setValueAtTime(0.3, ctx.currentTime);
                gain1.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.4);
                osc1.start(ctx.currentTime);
                osc1.stop(ctx.currentTime + 0.4);

                // A4 Chime note
                let osc2 = ctx.createOscillator();
                let gain2 = ctx.createGain();
                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(440.00, ctx.currentTime + 0.25);
                gain2.gain.setValueAtTime(0.3, ctx.currentTime + 0.25);
                gain2.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.7);
                osc2.start(ctx.currentTime + 0.25);
                osc2.stop(ctx.currentTime + 0.7);
            } catch (e) {
                console.error(e);
            }
        },
        addPatientSubmit() {
            if (!this.newPatient.name.trim()) {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { type: 'error', title: 'Input Gagal', message: 'Nama pasien wajib diisi untuk menerbitkan nomor antrian!' }
                }));
                return;
            }
            
            // Generate queue prefix based on poli
            let prefix = 'A';
            if (this.newPatient.poli === 'Poli Gigi') prefix = 'B';
            else if (this.newPatient.poli === 'Poli Anak') prefix = 'C';

            // Count existing queues of this prefix
            let count = this.queues.filter(q => q.no.startsWith(prefix)).length + 1;
            let queueNo = prefix + '-' + String(count).padStart(3, '0');
            let patientName = this.newPatient.name;

            this.queues.unshift({
                no: queueNo,
                name: patientName,
                poli: this.newPatient.poli,
                doctor: this.newPatient.doctor,
                status: 'Menunggu',
                wait_time: '20 menit',
                status_color: 'yellow'
            });

            this.showTambahPasienModal = false;

            window.dispatchEvent(new CustomEvent('notify', {
                detail: { type: 'success', title: 'Nomor Antrian Terbit', message: 'Antrian ' + queueNo + ' (' + patientName + ') berhasil didaftarkan.' }
            }));
        },
        triggerCall(queueNo) {
            @if($isStaff)
            this.callingNumber = queueNo;
            this.showPanggilAntrianModal = true;
            this.playNotification();
            
            // Visual calling ring effect
            this.callSoundPlaying = true;
            setTimeout(() => { this.callSoundPlaying = false; }, 1000);
            
            // Find and update status of called queue to 'Diperiksa' if it was 'Menunggu'
            let qIndex = this.queues.findIndex(q => q.no === queueNo);
            if (qIndex !== -1 && this.queues[qIndex].status === 'Menunggu') {
                this.queues[qIndex].status = 'Diperiksa';
                this.queues[qIndex].status_color = 'blue';
            }

            window.dispatchEvent(new CustomEvent('notify', {
                detail: { type: 'info', title: 'Panggilan Antrian', message: 'Memanggil nomor ' + queueNo + ' menuju ruang pemeriksaan.' }
            }));
            @endif
        },
        callNextAvailable() {
            @if($isStaff)
            // Find first queue with status 'Menunggu'
            let nextQ = this.queues.slice().reverse().find(q => q.status === 'Menunggu');
            if (nextQ) {
                this.triggerCall(nextQ.no);
            } else {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { type: 'warning', title: 'Antrian Kosong', message: 'Tidak ada antrian dengan status menunggu saat ini.' }
                }));
            }
            @endif
        },
        finishQueue(queueNo) {
            @if($isStaff)
            let qIndex = this.queues.findIndex(q => q.no === queueNo);
            if (qIndex !== -1) {
                this.queues[qIndex].status = 'Selesai';
                this.queues[qIndex].status_color = 'green';
                this.queues[qIndex].wait_time = '-';
            }
            @endif
        },
        get filteredQueues() {
            return this.queues.filter(q => {
                let matchSearch = q.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || q.no.toLowerCase().includes(this.searchQuery.toLowerCase());
                let matchPoli = this.currentFilter === 'Semua Poli' || q.poli === this.currentFilter;
                return matchSearch && matchPoli;
            });
        }
    }"
    x-on:open-modal.window="if ($event.detail.name === 'tambah-pasien' || $event.detail.name === 'tambah' || $event.detail.name === 'daftar') showTambahPasienModal = true; @if($isStaff) if ($event.detail.name === 'panggil-antrian' || $event.detail.name === 'panggil') showPanggilAntrianModal = true; @endif"
    >

        <!-- Top Header & Action Buttons -->
        <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200">
            <div>
                <h2 class="text-lg font-bold text-slate-900 leading-tight">
                    @if($isStaff)
                        Manajemen Antrean Klinik
                    @else
                        Antrean Layanan Pasien
                    @endif
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    @if($isStaff)
                        Monitoring kedatangan pasien dan kontrol pemanggilan loket pemeriksaan.
                    @else
                        Status antrean berjalan dan pendaftaran tiket konsultasi dokter.
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2 font-sans">
                @if($isStaff)
                    <button @click="showTambahPasienModal = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-white text-slate-700 font-medium rounded-md border border-slate-300 hover:bg-slate-50 transition-colors text-xs cursor-pointer shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Registrasi Antrean</span>
                    </button>
                    <button @click="callNextAvailable()" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 bg-teal-700 text-white font-medium rounded-md hover:bg-teal-800 transition-colors text-xs shadow-2xs cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                        </svg>
                        <span>Panggil Berikutnya</span>
                    </button>
                @else
                    <button @click="showTambahPasienModal = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 bg-teal-700 text-white font-medium rounded-md hover:bg-teal-800 transition-colors text-xs shadow-2xs cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Daftar Berobat</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white rounded-lg border border-slate-200 p-3 mb-5 flex flex-col md:flex-row gap-3 justify-between items-center shadow-2xs">
            <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto">
                <template x-for="poli in ['Semua Poli', 'Poli Umum', 'Poli Gigi', 'Poli Anak']">
                    <button @click="currentFilter = poli" 
                            :class="currentFilter === poli ? 'bg-teal-50 text-teal-900 font-semibold border-teal-200' : 'text-slate-600 hover:bg-slate-50 border-slate-200'" 
                            class="px-3 py-1.5 rounded-md border text-xs whitespace-nowrap transition-colors cursor-pointer"
                            x-text="poli">
                    </button>
                </template>
            </div>
            <div class="relative w-full md:w-64">
                <input x-model="searchQuery" type="text" placeholder="Cari nama atau nomor tiket..." class="w-full pl-8 pr-3 py-1.5 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>

        <!-- Active Queues Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="q in filteredQueues" :key="q.no">
                <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-2xs flex flex-col justify-between hover:border-slate-300 transition-colors">
                    
                    <!-- Card Header -->
                    <div class="flex justify-between items-start mb-3 pb-2.5 border-b border-slate-100">
                        <div>
                            <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider block" x-text="q.poli"></span>
                            <span class="text-2xl font-bold font-mono text-slate-900 tracking-tight" x-text="q.no"></span>
                        </div>
                        
                        <!-- Status Badge -->
                        <span :class="q.status === 'Diperiksa' ? 'bg-blue-50 text-blue-800 border-blue-200' : (q.status === 'Selesai' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-amber-50 text-amber-800 border-amber-200')"
                              class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium border"
                              x-text="q.status">
                        </span>
                    </div>
                    
                    <!-- Card Details -->
                    <div class="space-y-2 mb-4 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Pasien</span>
                            <span class="font-medium text-slate-900" x-text="q.name"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Dokter</span>
                            <span class="text-slate-700" x-text="q.doctor"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Estimasi Tunggu</span>
                            <span class="font-mono text-slate-700" x-text="q.wait_time"></span>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">Loket Aktif</span>
                        @if($isStaff)
                            <div class="flex gap-1.5">
                                <template x-if="q.status === 'Menunggu'">
                                    <button @click="triggerCall(q.no)" class="text-[11px] font-medium text-white bg-teal-700 hover:bg-teal-800 py-1 px-2.5 rounded transition-colors cursor-pointer shadow-2xs">
                                        Panggil
                                    </button>
                                </template>
                                <template x-if="q.status === 'Diperiksa'">
                                    <button @click="finishQueue(q.no)" class="text-[11px] font-medium text-white bg-slate-800 hover:bg-slate-900 py-1 px-2.5 rounded transition-colors cursor-pointer shadow-2xs">
                                        Selesaikan
                                    </button>
                                </template>
                            </div>
                        @else
                            <div>
                                <span class="text-[10px] font-medium px-2 py-0.5 rounded"
                                      :class="q.status === 'Diperiksa' ? 'bg-blue-50 text-blue-800' : (q.status === 'Selesai' ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-100 text-slate-700')">
                                    <span x-text="q.status === 'Diperiksa' ? 'Sedang Dilayani' : (q.status === 'Selesai' ? 'Selesai' : 'Dalam Antrean')"></span>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </template>
        </div>

        <!-- ================= MODALS ================= -->

        <!-- 1. Tambah Pasien / Daftar Berobat Modal -->
        <div x-show="showTambahPasienModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/50"
             style="display: none;"
             x-transition>
            <div @click.away="showTambahPasienModal = false" class="bg-white w-full max-w-md rounded-lg shadow-xl border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                    <div>
                        <h3 class="font-semibold text-slate-900 text-sm">
                            @if($isStaff)
                                Registrasi Antrean Baru
                            @else
                                Pendaftaran Kunjungan Berobat
                            @endif
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">
                            @if($isStaff)
                                Penerbitan nomor antrean loket periksa klinik
                            @else
                                Ambil nomor tiket antrean pemeriksaan dokter secara online
                            @endif
                        </p>
                    </div>
                    <button @click="showTambahPasienModal = false" class="text-slate-400 hover:text-slate-700 cursor-pointer p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form @submit.prevent="addPatientSubmit()" class="p-5 space-y-3 font-sans">
                    <!-- Name -->
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Nama Pasien <span class="text-rose-600">*</span></label>
                        <input x-model="newPatient.name" type="text" placeholder="Masukkan nama lengkap pasien" required class="w-full py-1.5 px-3 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs">
                    </div>
                    <!-- Poli Selection -->
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Poli Tujuan <span class="text-rose-600">*</span></label>
                        <select x-model="newPatient.poli" @change="updateDoctors()" class="w-full py-1.5 px-2.5 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs bg-white">
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Gigi">Poli Gigi & Mulut</option>
                            <option value="Poli Anak">Poli Anak (Pediatri)</option>
                        </select>
                    </div>
                    <!-- Doctor -->
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Dokter Pemeriksa <span class="text-rose-600">*</span></label>
                        <select x-model="newPatient.doctor" class="w-full py-1.5 px-2.5 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs bg-white">
                            <template x-for="doc in doctorsMap[newPatient.poli]">
                                <option :value="doc" x-text="doc"></option>
                            </template>
                        </select>
                    </div>
                    <!-- Type -->
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Skema Penjaminan <span class="text-rose-600">*</span></label>
                        <select x-model="newPatient.type" class="w-full py-1.5 px-2.5 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs bg-white">
                            <option value="Pasien Umum">Pasien Umum / Mandiri</option>
                            <option value="Pasien BPJS/LPSK">Pasien BPJS / LPSK</option>
                        </select>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex justify-end gap-2">
                        <button type="button" @click="showTambahPasienModal = false" class="px-3 py-1.5 bg-white text-slate-700 font-medium border border-slate-300 rounded-md text-xs hover:bg-slate-50 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-1.5 bg-teal-700 text-white font-medium rounded-md text-xs shadow-2xs hover:bg-teal-800 transition-colors cursor-pointer">
                            @if($isStaff)
                                Daftarkan Pasien
                            @else
                                Konfirmasi & Ambil Tiket
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($isStaff)
        <!-- 2. Panggil Antrian Modal (Khusus Admin / Petugas Medis) -->
        <div x-show="showPanggilAntrianModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/50"
             style="display: none;"
             x-transition>
            <div @click.away="showPanggilAntrianModal = false" class="bg-white w-full max-w-sm rounded-lg shadow-xl border border-slate-200 overflow-hidden text-center p-5">
                <div class="w-10 h-10 bg-teal-50 border border-teal-200 rounded-full flex items-center justify-center mx-auto mb-3 text-teal-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                    </svg>
                </div>
                
                <h3 class="font-semibold text-slate-900 text-sm mb-0.5">Pemanggilan Antrean</h3>
                <p class="text-[11px] text-slate-500 mb-4">Pengeras suara loket klinik aktif</p>
                
                <!-- Display Queue Number -->
                <div class="bg-slate-50 rounded-md py-4 mb-4 border border-slate-200">
                    <div class="text-3xl font-bold font-mono text-teal-800 tracking-wider" x-text="callingNumber"></div>
                    <div class="text-[10px] text-slate-500 font-medium uppercase tracking-wider mt-1">Harap Menuju Loket Poli</div>
                </div>

                <div class="flex gap-2">
                    <button @click="playNotification()" class="flex-1 py-1.5 bg-teal-700 text-white font-medium rounded-md text-xs hover:bg-teal-800 transition-colors flex items-center justify-center gap-1.5 cursor-pointer shadow-2xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 18.75V21m-6-6h1.5L12 18.75V5.25L7.5 9H6a1 1 0 00-1 1v4a1 1 0 001 1z"/></svg>
                        <span>Bunyikan Chime</span>
                    </button>
                    <button @click="showPanggilAntrianModal = false" class="px-3 py-1.5 bg-white text-slate-700 font-medium border border-slate-300 rounded-md text-xs hover:bg-slate-50 cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
