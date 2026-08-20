<x-app-layout>
    <div x-data="{ 
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
            name: '',
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
            if (!this.newPatient.name.trim()) return;
            
            // Generate queue prefix based on poli
            let prefix = 'A';
            if (this.newPatient.poli === 'Poli Gigi') prefix = 'B';
            else if (this.newPatient.poli === 'Poli Anak') prefix = 'C';

            // Count existing queues of this prefix
            let count = this.queues.filter(q => q.no.startsWith(prefix)).length + 1;
            let queueNo = prefix + '-' + String(count).padStart(3, '0');

            this.queues.unshift({
                no: queueNo,
                name: this.newPatient.name,
                poli: this.newPatient.poli,
                doctor: this.newPatient.doctor,
                status: 'Menunggu',
                wait_time: '20 menit',
                status_color: 'yellow'
            });

            this.newPatient.name = '';
            this.showTambahPasienModal = false;
        },
        triggerCall(queueNo) {
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
        },
        callNextAvailable() {
            // Find first queue with status 'Menunggu'
            let nextQ = this.queues.slice().reverse().find(q => q.status === 'Menunggu');
            if (nextQ) {
                this.triggerCall(nextQ.no);
            } else {
                alert('Tidak ada antrian menunggu saat ini.');
            }
        },
        finishQueue(queueNo) {
            let qIndex = this.queues.findIndex(q => q.no === queueNo);
            if (qIndex !== -1) {
                this.queues[qIndex].status = 'Selesai';
                this.queues[qIndex].status_color = 'green';
                this.queues[qIndex].wait_time = '-';
            }
        },
        get filteredQueues() {
            return this.queues.filter(q => {
                let matchSearch = q.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || q.no.toLowerCase().includes(this.searchQuery.toLowerCase());
                let matchPoli = this.currentFilter === 'Semua Poli' || q.poli === this.currentFilter;
                return matchSearch && matchPoli;
            });
        }
    }">

        <!-- Top Header & Action Buttons -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 leading-tight">Antrian Hari Ini</h2>
                <p class="text-gray-500 mt-1">Pantau status antrian pasien secara real-time.</p>
            </div>
            <div class="flex items-center gap-3 font-sans">
                <button @click="showTambahPasienModal = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white text-emerald-600 font-semibold rounded-xl border border-emerald-600 hover:bg-emerald-50 focus:outline-none focus:ring-4 focus:ring-emerald-100 transition-all duration-200 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pasien
                </button>
                <button @click="callNextAvailable()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 transition-all duration-200 text-sm shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                    </svg>
                    Panggil Antrian
                </button>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white rounded-2xl border border-gray-150 p-4 mb-6 flex flex-col md:flex-row gap-4 justify-between items-center shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
                <template x-for="poli in ['Semua Poli', 'Poli Umum', 'Poli Gigi', 'Poli Anak']">
                    <button @click="currentFilter = poli" 
                            :class="currentFilter === poli ? 'bg-emerald-50 text-emerald-600 font-bold border-emerald-100' : 'text-gray-500 hover:bg-gray-50 border-transparent'" 
                            class="px-4 py-2 rounded-xl border text-xs font-semibold whitespace-nowrap transition-colors"
                            x-text="poli">
                    </button>
                </template>
            </div>
            <div class="relative w-full md:w-64">
                <input x-model="searchQuery" type="text" placeholder="Cari nama atau no antrian..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>

        <!-- Active Queues Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <template x-for="q in filteredQueues" :key="q.no">
                <div class="bg-white rounded-3xl border border-gray-150 p-5 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between transition-all duration-200 hover:shadow-md relative overflow-hidden"
                     :class="q.status === 'Diperiksa' ? 'border-l-4 border-l-blue-500' : (q.status === 'Selesai' ? 'border-l-4 border-l-emerald-500' : 'border-l-4 border-l-amber-500')">
                    
                    <!-- Card Header -->
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1" x-text="q.poli"></div>
                            <div class="text-3xl font-black text-gray-900 tracking-tight" x-text="q.no"></div>
                        </div>
                        
                        <!-- Status Badge -->
                        <span :class="q.status === 'Diperiksa' ? 'bg-blue-50 text-blue-700 border-blue-200' : (q.status === 'Selesai' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200')"
                              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border"
                              x-text="q.status">
                        </span>
                    </div>
                    
                    <!-- Card Details -->
                    <div class="space-y-3 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 font-black text-xs" x-text="q.name.substring(0,2).toUpperCase()"></div>
                            <div>
                                <div class="text-sm font-bold text-gray-900 leading-tight" x-text="q.name"></div>
                                <div class="text-[10px] text-gray-400">Pasien Terdaftar</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900 leading-tight" x-text="q.doctor"></div>
                                <div class="text-[10px] text-gray-400">Dokter Bertugas</div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="text-xs text-gray-400">
                            Waktu: <span class="font-bold text-gray-700" x-text="q.wait_time"></span>
                        </div>
                        <div class="flex gap-2">
                            <template x-if="q.status === 'Menunggu'">
                                <button @click="triggerCall(q.no)" class="text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 py-1.5 px-3 rounded-lg shadow-sm transition-colors">
                                    Panggil
                                </button>
                            </template>
                            <template x-if="q.status === 'Diperiksa'">
                                <button @click="finishQueue(q.no)" class="text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 py-1.5 px-3 rounded-lg shadow-sm transition-colors">
                                    Selesaikan
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- ================= MODALS ================= -->

        <!-- 1. Tambah Pasien Modal -->
        <div x-show="showTambahPasienModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
             style="display: none;"
             x-transition>
            <div @click.away="showTambahPasienModal = false" class="bg-white w-full max-w-md rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-emerald-50">
                    <h3 class="font-extrabold text-gray-900 text-lg">Registrasi Antrian Baru</h3>
                    <button @click="showTambahPasienModal = false" class="text-gray-400 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form @submit.prevent="addPatientSubmit()" class="p-6 space-y-4 font-sans">
                    <!-- Name -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama Pasien</label>
                        <input x-model="newPatient.name" type="text" placeholder="Masukkan nama pasien" required class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm">
                    </div>
                    <!-- Poli Selection -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Poli Klinik</label>
                        <select x-model="newPatient.poli" @change="updateDoctors()" class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm bg-white">
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Gigi">Poli Gigi</option>
                            <option value="Poli Anak">Poli Anak</option>
                        </select>
                    </div>
                    <!-- Doctor -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Dokter Pemeriksa</label>
                        <select x-model="newPatient.doctor" class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm bg-white">
                            <template x-for="doc in doctorsMap[newPatient.poli]">
                                <option :value="doc" x-text="doc"></option>
                            </template>
                        </select>
                    </div>
                    <!-- Type -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Jenis Pasien</label>
                        <select x-model="newPatient.type" class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm bg-white">
                            <option value="Pasien Umum">Pasien Umum</option>
                            <option value="Pasien BPJS/LPSK">Pasien BPJS / LPSK</option>
                        </select>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showTambahPasienModal = false" class="flex-1 py-3 bg-white text-gray-700 font-bold border border-gray-200 rounded-xl text-sm transition-colors hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white font-bold rounded-xl text-sm shadow-sm transition-colors hover:bg-emerald-700">
                            Daftarkan Pasien
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 2. Panggil Antrian Modal (Simulasi) -->
        <div x-show="showPanggilAntrianModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
             style="display: none;"
             x-transition>
            <div @click.away="showPanggilAntrianModal = false" class="bg-white w-full max-w-sm rounded-3xl shadow-xl border border-gray-100 overflow-hidden text-center p-6">
                <!-- Megaphone Animated Icon -->
                <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-emerald-100"
                     :class="callSoundPlaying ? 'animate-ping' : ''">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                    </svg>
                </div>
                
                <h3 class="font-extrabold text-gray-900 text-lg mb-1">Memanggil Antrian</h3>
                <p class="text-xs text-gray-400 mb-4">Pengeras Suara Klinik LPSK Aktif</p>
                
                <!-- Display Queue Number -->
                <div class="bg-emerald-50/50 rounded-2xl py-6 mb-6 border border-emerald-100">
                    <div class="text-4xl font-black text-emerald-600 tracking-wider" x-text="callingNumber"></div>
                    <div class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Harap Menuju Loket Poli</div>
                </div>

                <div class="flex flex-col gap-2">
                    <button @click="playNotification()" class="w-full py-3 bg-emerald-600 text-white font-bold rounded-xl text-sm shadow-sm hover:bg-emerald-700 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 18.75V21m-6-6h1.5L12 18.75V5.25L7.5 9H6a1 1 0 00-1 1v4a1 1 0 001 1z"/></svg>
                        Bunyikan Bell
                    </button>
                    <button @click="showPanggilAntrianModal = false" class="w-full py-3 bg-white text-gray-700 font-bold border border-gray-200 rounded-xl text-sm transition-colors hover:bg-gray-50">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
