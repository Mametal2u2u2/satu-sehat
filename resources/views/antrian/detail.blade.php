<x-app-layout>
    <!-- Top Header with Back Button -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard') }}" wire:navigate class="p-2 text-gray-500 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="font-bold text-lg text-gray-900">Ambil Antrian</h1>
    </div>

    <!-- Detail Card Container -->
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-3xl shadow-[0_4px_25px_rgba(0,0,0,0.03)] border border-slate-100 p-8 text-center">
            <!-- Green Checkmark -->
            <div class="w-16 h-16 mx-auto mb-5 bg-[#009669] rounded-full flex items-center justify-center shadow-lg shadow-emerald-200/50">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h2 class="text-lg font-black text-slate-900 mb-1">Antrian Berhasil Diambil</h2>
            <p class="text-xs text-slate-500 mb-4">Simpan bukti nomor antrian ini saat tiba di klinik.</p>

            <!-- Nomor Antrian -->
            <div class="inline-block px-6 py-2 bg-emerald-50 rounded-2xl border border-emerald-100 mb-6">
                <span class="text-xs font-semibold text-emerald-600 block uppercase tracking-wider">Nomor Antrian Anda</span>
                <span class="text-4xl font-black text-[#009669] tracking-tight">D-034</span>
            </div>

            <!-- QR Code Box -->
            <div class="flex justify-center mb-6">
                <div class="w-48 h-48 bg-white p-3 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-center">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=SATUSEHAT-LPSK-D034-POLIGIGI&format=png&color=000000" alt="QR Code" class="w-full h-full object-contain">
                </div>
            </div>

            <!-- Poli & Dokter Info -->
            <div class="bg-slate-50 rounded-2xl p-3.5 mb-6 border border-slate-100">
                <p class="text-sm font-black text-slate-900 mb-0.5">Poli Gigi & Mulut</p>
                <p class="text-xs text-slate-500 font-medium">drg. Maya Putri • Estimasi Jam: 10:15 WIB</p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2.5 font-sans">
                <a href="{{ route('antrian.index') }}" wire:navigate class="w-full flex items-center justify-center py-3 bg-[#009669] text-white rounded-2xl font-bold text-xs hover:bg-[#007a55] active:scale-[0.99] transition-all shadow-sm">
                    Lihat Daftar Antrian
                </a>
                <a href="{{ route('dashboard') }}" wire:navigate class="w-full flex items-center justify-center py-3 border border-slate-200 text-slate-700 rounded-2xl font-bold text-xs hover:bg-slate-50 transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <div class="h-8"></div>
</x-app-layout>
