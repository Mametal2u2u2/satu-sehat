<x-app-layout>
    <div x-data="{
        init() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('modal') === 'tambah' || urlParams.get('modal') === 'tambah-jadwal') {
                this.showTambahJadwalModal = true;
            }
        },
        showTambahJadwalModal: false,
        selectedDay: 'Semua Hari',
        selectedPoli: 'Semua Poli',
        schedules: [
            {hari: 'Senin', nama: 'dr. Rina Kusuma', poli: 'Poli Umum', jam: '08:00 - 14:00', status: 'Aktif', kuota: '20/30', savedKuota: '20/30'},
            {hari: 'Senin', nama: 'drg. Hendra P.', poli: 'Poli Gigi', jam: '09:00 - 15:00', status: 'Aktif', kuota: '15/20', savedKuota: '15/20'},
            {hari: 'Selasa', nama: 'dr. Budi Santoso', poli: 'Poli Umum', jam: '10:00 - 16:00', status: 'Aktif', kuota: '10/15', savedKuota: '10/15'},
            {hari: 'Rabu', nama: 'dr. Rina Kusuma', poli: 'Poli Umum', jam: '08:00 - 14:00', status: 'Cuti', kuota: '0/30', savedKuota: '20/30'},
            {hari: 'Kamis', nama: 'drg. Hendra P.', poli: 'Poli Gigi', jam: '09:00 - 15:00', status: 'Aktif', kuota: '5/20', savedKuota: '5/20'},
            {hari: 'Jumat', nama: 'dr. Sari Dewi', poli: 'Poli Anak', jam: '13:00 - 17:00', status: 'Aktif', kuota: '25/25', savedKuota: '25/25'},
        ],
        doctorLeaveQuota: {
            'dr. Rina Kusuma': 11,
            'drg. Hendra P.': 12,
            'dr. Budi Santoso': 12,
            'dr. Sari Dewi': 12
        },
        newSchedule: {
            hari: 'Senin',
            nama: '',
            poli: 'Poli Umum',
            jam: '08:00 - 14:00',
            status: 'Aktif',
            kuota: '30',
            kuotaCuti: '12'
        },
        getDoctorLeaveQuota(nama) {
            if (this.doctorLeaveQuota[nama] === undefined) {
                this.doctorLeaveQuota[nama] = 12;
            }
            return this.doctorLeaveQuota[nama];
        },
        addScheduleSubmit() {
            if (!this.newSchedule.nama.trim()) return;

            let doctorName = this.newSchedule.nama.trim();
            if (this.doctorLeaveQuota[doctorName] === undefined) {
                this.doctorLeaveQuota[doctorName] = parseInt(this.newSchedule.kuotaCuti) || 12;
            }

            this.schedules.unshift({
                hari: this.newSchedule.hari,
                nama: doctorName,
                poli: this.newSchedule.poli,
                jam: this.newSchedule.jam,
                status: this.newSchedule.status,
                kuota: '0/' + this.newSchedule.kuota,
                savedKuota: '0/' + this.newSchedule.kuota
            });

            this.newSchedule.nama = '';
            this.showTambahJadwalModal = false;
        },
        toggleCuti(item) {
            let currentLeaveQuota = this.getDoctorLeaveQuota(item.nama);
            if (item.status === 'Aktif') {
                if (currentLeaveQuota <= 0) {
                    alert('Sisa kuota cuti untuk ' + item.nama + ' sudah habis (0 hari)!');
                    return;
                }
                item.status = 'Cuti';
                this.doctorLeaveQuota[item.nama] = currentLeaveQuota - 1;

                // Simpan kuota pasien sebelum cuti, ubah kuota hari ini menjadi 0
                item.savedKuota = item.kuota;
                let maxQuota = item.kuota.includes('/') ? item.kuota.split('/')[1] : item.kuota;
                item.kuota = '0/' + maxQuota;
            } else {
                item.status = 'Aktif';
                this.doctorLeaveQuota[item.nama] = currentLeaveQuota + 1;

                // Kembalikan kuota pasien seperti semula
                if (item.savedKuota) {
                    item.kuota = item.savedKuota;
                }
            }
        },
        get filteredSchedules() {
            return this.schedules.filter(s => {
                let matchDay = this.selectedDay === 'Semua Hari' || s.hari === this.selectedDay;
                let matchPoli = this.selectedPoli === 'Semua Poli' || s.poli === this.selectedPoli;
                return matchDay && matchPoli;
            });
        }
    }"
    x-on:open-modal.window="if ($event.detail.name === 'tambah-jadwal' || $event.detail.name === 'tambah') showTambahJadwalModal = true;"
    >

        <!-- Top Header & Action Buttons -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 leading-tight">Jadwal Praktik Dokter</h2>
                <p class="text-gray-500 mt-1">Kelola jadwal praktik dan ketersediaan dokter klinik.</p>
            </div>
            <div class="flex items-center gap-3">
                <button @click="showTambahJadwalModal = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 transition-all duration-200 text-sm shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Jadwal
                </button>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white rounded-2xl border border-gray-150 p-4 mb-6 flex flex-col md:flex-row gap-4 justify-between items-center shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
                <template x-for="day in ['Semua Hari', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']">
                    <button @click="selectedDay = day" 
                            :class="selectedDay === day ? 'bg-emerald-50 text-emerald-600 font-bold border-emerald-100' : 'text-gray-500 hover:bg-gray-50 border-transparent'" 
                            class="px-4 py-2 rounded-xl border text-xs font-semibold whitespace-nowrap transition-colors"
                            x-text="day">
                    </button>
                </template>
            </div>
            <div class="relative w-full md:w-64">
                <select x-model="selectedPoli" class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm appearance-none bg-white font-semibold text-gray-700">
                    <option value="Semua Poli">Semua Poli</option>
                    <option value="Poli Umum">Poli Umum</option>
                    <option value="Poli Gigi">Poli Gigi</option>
                    <option value="Poli Anak">Poli Anak</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3.5 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>

        <!-- Schedule Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <template x-for="(j, index) in filteredSchedules" :key="index">
                <div class="bg-white rounded-3xl border border-gray-150 p-5 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex flex-col justify-between transition-all duration-200 hover:shadow-md relative overflow-hidden">
                    <div x-show="j.status === 'Cuti'" class="absolute inset-0 bg-red-500/5 pointer-events-none" style="display: none;"></div>
                    
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div>
                            <!-- Header Info -->
                            <div class="flex justify-between items-start mb-4">
                                <span :class="j.status === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200'"
                                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border"
                                      x-text="j.status">
                                </span>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide" x-text="j.hari"></span>
                            </div>
                            
                            <!-- Doctor Info -->
                            <div class="flex items-center gap-3.5 mb-5">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center font-black text-lg"
                                     x-text="j.nama.replace('dr. ', '').replace('drg. ', '').substring(0,2).toUpperCase()">
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-bold text-gray-900 leading-tight truncate" x-text="j.nama"></h3>
                                    <p class="text-xs text-emerald-600 font-bold tracking-wide uppercase mt-0.5" x-text="j.poli"></p>
                                </div>
                            </div>

                            <!-- Schedule details -->
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Jam Praktik: <span class="font-bold text-gray-900 ml-1" x-text="j.jam"></span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Kuota Pasien: <span class="font-bold ml-1" :class="j.status === 'Cuti' ? 'text-gray-400' : 'text-gray-900'" x-text="j.status === 'Cuti' ? j.kuota + ' (Tutup)' : j.kuota"></span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Sisa Kuota Cuti: <span class="font-bold ml-1" :class="getDoctorLeaveQuota(j.nama) <= 2 ? 'text-red-600 font-extrabold' : 'text-emerald-700'" x-text="getDoctorLeaveQuota(j.nama) + ' Hari'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div class="flex gap-2 pt-4 border-t border-gray-100">
                            <button @click="toggleCuti(j)"
                                    :class="j.status === 'Aktif' ? 'text-red-600 border-red-200 hover:bg-red-50 focus:ring-red-150' : 'text-emerald-600 border-emerald-200 hover:bg-emerald-50 focus:ring-emerald-150'"
                                    class="flex-1 py-2 text-xs font-bold justify-center rounded-xl border transition-all text-center"
                                    x-text="j.status === 'Aktif' ? 'Set Cuti' : 'Aktifkan'">
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- ================= MODALS ================= -->

        <!-- Tambah Jadwal Modal -->
        <div x-show="showTambahJadwalModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
             style="display: none;"
             x-transition>
            <div @click.away="showTambahJadwalModal = false" class="bg-white w-full max-w-md rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-emerald-50">
                    <h3 class="font-extrabold text-gray-900 text-lg">Tambah Jadwal Dokter</h3>
                    <button @click="showTambahJadwalModal = false" class="text-gray-400 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form @submit.prevent="addScheduleSubmit()" class="p-6 space-y-4 font-sans">
                    <!-- Doctor Name -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama Dokter</label>
                        <input x-model="newSchedule.nama" type="text" placeholder="Masukkan nama dokter (misal: dr. Anton)" required class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm">
                    </div>
                    <!-- Poli -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Poli Klinik</label>
                        <select x-model="newSchedule.poli" class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm bg-white">
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Gigi">Poli Gigi</option>
                            <option value="Poli Anak">Poli Anak</option>
                        </select>
                    </div>
                    <!-- Day -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Hari Kerja</label>
                        <select x-model="newSchedule.hari" class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm bg-white">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                        </select>
                    </div>
                    <!-- Working Hours -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Jam Praktik</label>
                        <input x-model="newSchedule.jam" type="text" placeholder="Contoh: 08:00 - 14:00" required class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Quota -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kuota Pasien</label>
                            <input x-model="newSchedule.kuota" type="number" placeholder="30" required class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm">
                        </div>
                        <!-- Leave Quota -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kuota Cuti (Hari)</label>
                            <input x-model="newSchedule.kuotaCuti" type="number" placeholder="12" class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm">
                        </div>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showTambahJadwalModal = false" class="flex-1 py-3 bg-white text-gray-700 font-bold border border-gray-200 rounded-xl text-sm transition-colors hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white font-bold rounded-xl text-sm shadow-sm transition-colors hover:bg-emerald-700">
                            Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
