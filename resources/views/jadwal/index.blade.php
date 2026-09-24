@php
    $user = auth()->user();
    $isStaff = $user && $user->hasAnyRole(['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Fisioterapis', 'Apoteker', 'Approver']);
@endphp

<x-app-layout>
    <div x-data="{
        init() {
            const urlParams = new URLSearchParams(window.location.search);
            @if($isStaff)
            if (urlParams.get('modal') === 'tambah' || urlParams.get('modal') === 'tambah-jadwal') {
                this.showTambahJadwalModal = true;
            }
            @endif
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
        <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200">
            <div>
                <h2 class="text-lg font-bold text-slate-900 leading-tight">Jadwal Praktik Dokter</h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    @if($isStaff)
                        Kelola alokasi jadwal bertugas dan status ketersediaan dokter klinik.
                    @else
                        Jadwal konsultasi dokter klinik dan ketersediaan kuota pemeriksaan.
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                @if($isStaff)
                    <button @click="showTambahJadwalModal = true" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 bg-teal-700 text-white font-medium rounded-md hover:bg-teal-800 transition-colors text-xs shadow-2xs cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Tambah Jadwal</span>
                    </button>
                @else
                    <a href="{{ route('antrian.index', ['modal' => 'daftar']) }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 bg-teal-700 text-white font-medium rounded-md hover:bg-teal-800 transition-colors text-xs shadow-2xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Daftar Berobat</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white rounded-lg border border-slate-200 p-3 mb-5 flex flex-col md:flex-row gap-3 justify-between items-center shadow-2xs">
            <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto">
                <template x-for="day in ['Semua Hari', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']">
                    <button @click="selectedDay = day" 
                            :class="selectedDay === day ? 'bg-teal-50 text-teal-900 font-semibold border-teal-200' : 'text-slate-600 hover:bg-slate-50 border-slate-200'" 
                            class="px-3 py-1.5 rounded-md border text-xs whitespace-nowrap transition-colors cursor-pointer"
                            x-text="day">
                    </button>
                </template>
            </div>
            <div class="relative w-full md:w-56">
                <select x-model="selectedPoli" class="w-full pl-3 pr-8 py-1.5 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs bg-white text-slate-800">
                    <option value="Semua Poli">Semua Poliklinik</option>
                    <option value="Poli Umum">Poli Umum</option>
                    <option value="Poli Gigi">Poli Gigi & Mulut</option>
                    <option value="Poli Anak">Poli Anak</option>
                </select>
            </div>
        </div>

        <!-- Schedule Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <template x-for="(j, index) in filteredSchedules" :key="index">
                <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-2xs flex flex-col justify-between hover:border-slate-300 transition-colors">
                    <div>
                        <!-- Header Info -->
                        <div class="flex justify-between items-start mb-3 pb-2.5 border-b border-slate-100">
                            <div>
                                <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider block" x-text="j.hari"></span>
                                <span class="text-xs font-semibold text-teal-800 block" x-text="j.poli"></span>
                            </div>
                            <span :class="j.status === 'Aktif' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-rose-50 text-rose-800 border-rose-200'"
                                  class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium border"
                                  x-text="j.status">
                            </span>
                        </div>
                        
                        <!-- Doctor Info -->
                        <div class="mb-3">
                            <h3 class="font-semibold text-sm text-slate-900 leading-tight truncate" x-text="j.nama"></h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">Dokter Pelayanan Terjadwal</p>
                        </div>

                        <!-- Schedule details -->
                        <div class="space-y-1.5 mb-4 text-xs">
                            <div class="flex items-center justify-between text-slate-600">
                                <span class="text-slate-500">Jam Praktik</span>
                                <span class="font-mono text-slate-900" x-text="j.jam"></span>
                            </div>
                            <div class="flex items-center justify-between text-slate-600">
                                <span class="text-slate-500">Kuota Terisi</span>
                                <span class="font-mono text-slate-900" :class="j.status === 'Cuti' ? 'text-slate-400' : 'text-slate-900'" x-text="j.status === 'Cuti' ? j.kuota + ' (Tutup)' : j.kuota"></span>
                            </div>
                            @if($isStaff)
                            <div class="flex items-center justify-between text-slate-600">
                                <span class="text-slate-500">Sisa Cuti</span>
                                <span class="font-mono" :class="getDoctorLeaveQuota(j.nama) <= 2 ? 'text-rose-700 font-semibold' : 'text-teal-800 font-medium'" x-text="getDoctorLeaveQuota(j.nama) + ' Hari'"></span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="pt-3 border-t border-slate-100">
                        @if($isStaff)
                            <button @click="toggleCuti(j)"
                                    :class="j.status === 'Aktif' ? 'text-rose-700 border-rose-300 hover:bg-rose-50' : 'text-teal-800 border-teal-300 hover:bg-teal-50'"
                                    class="w-full py-1.5 text-xs font-medium rounded-md border transition-colors text-center cursor-pointer"
                                    x-text="j.status === 'Aktif' ? 'Tandai Cuti' : 'Aktifkan Kembali'">
                            </button>
                        @else
                            <template x-if="j.status === 'Aktif'">
                                <a href="{{ route('antrian.index', ['modal' => 'daftar']) }}" 
                                   class="w-full py-1.5 text-xs font-medium rounded-md bg-teal-700 hover:bg-teal-800 text-white transition-colors text-center shadow-2xs flex items-center justify-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    <span>Ambil Tiket</span>
                                </a>
                            </template>
                            <template x-if="j.status !== 'Aktif'">
                                <div class="w-full py-1.5 text-xs text-slate-400 bg-slate-100 rounded-md text-center font-medium">
                                    Sedang Cuti
                                </div>
                            </template>
                        @endif
                    </div>
                </div>
            </template>
        </div>

        @if($isStaff)
        <!-- ================= MODALS (Khusus Staf/Admin) ================= -->

        <!-- Tambah Jadwal Modal -->
        <div x-show="showTambahJadwalModal" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/50"
             style="display: none;"
             x-transition>
            <div @click.away="showTambahJadwalModal = false" class="bg-white w-full max-w-md rounded-lg shadow-xl border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                    <div>
                        <h3 class="font-semibold text-slate-900 text-sm">Tambah Jadwal Praktik Dokter</h3>
                        <p class="text-[11px] text-slate-500">Konfigurasi hari jaga dan kuota pasien poliklinik</p>
                    </div>
                    <button @click="showTambahJadwalModal = false" class="text-slate-400 hover:text-slate-700 p-1 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form @submit.prevent="addScheduleSubmit()" class="p-5 space-y-3 font-sans">
                    <!-- Doctor Name -->
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Nama Dokter <span class="text-rose-600">*</span></label>
                        <input x-model="newSchedule.nama" type="text" placeholder="Contoh: dr. Anton Wijaya" required class="w-full py-1.5 px-3 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs">
                    </div>
                    <!-- Poli -->
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Unit Poliklinik <span class="text-rose-600">*</span></label>
                        <select x-model="newSchedule.poli" class="w-full py-1.5 px-2.5 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs bg-white">
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Gigi">Poli Gigi & Mulut</option>
                            <option value="Poli Anak">Poli Anak</option>
                        </select>
                    </div>
                    <!-- Day -->
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Hari Bertugas <span class="text-rose-600">*</span></label>
                        <select x-model="newSchedule.hari" class="w-full py-1.5 px-2.5 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs bg-white">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                        </select>
                    </div>
                    <!-- Working Hours -->
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Jam Praktik <span class="text-rose-600">*</span></label>
                        <input x-model="newSchedule.jam" type="text" placeholder="Contoh: 08:00 - 14:00" required class="w-full py-1.5 px-3 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Quota -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Kuota Maksimal <span class="text-rose-600">*</span></label>
                            <input x-model="newSchedule.kuota" type="number" placeholder="30" required class="w-full py-1.5 px-3 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs">
                        </div>
                        <!-- Leave Quota -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Jatah Cuti (Hari)</label>
                            <input x-model="newSchedule.kuotaCuti" type="number" placeholder="12" class="w-full py-1.5 px-3 rounded-md border border-slate-300 focus:outline-hidden focus:ring-1 focus:ring-teal-600 focus:border-teal-600 text-xs">
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex justify-end gap-2">
                        <button type="button" @click="showTambahJadwalModal = false" class="px-3 py-1.5 bg-white text-slate-700 font-medium border border-slate-300 rounded-md text-xs hover:bg-slate-50 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-1.5 bg-teal-700 text-white font-medium rounded-md text-xs shadow-2xs hover:bg-teal-800 transition-colors cursor-pointer">
                            Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
