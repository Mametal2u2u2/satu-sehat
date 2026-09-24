<x-app-layout>
    <!-- Top Navigation / Breadcrumb -->
    <div class="flex items-center gap-2 mb-4 text-xs text-slate-500">
        <a href="{{ route('dashboard') }}" wire:navigate class="hover:text-slate-800 flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Beranda</span>
        </a>
        <span>/</span>
        <a href="{{ route('antrian.index') }}" wire:navigate class="hover:text-slate-800">Antrean</a>
        <span>/</span>
        <span class="text-slate-800 font-medium">Bukti Antrean</span>
    </div>

    <!-- Detail Card Container -->
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-2xs border border-slate-200 p-6 text-center">
            
            <div class="w-12 h-12 mx-auto mb-3 bg-teal-50 border border-teal-200 rounded-full flex items-center justify-center text-teal-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h2 class="text-base font-semibold text-slate-900 mb-0.5">Tiket Antrean Berhasil Terbit</h2>
            <p class="text-xs text-slate-500 mb-5">Tunjukkan bukti nomor antrean ini saat tiba di loket klinik.</p>

            <!-- Nomor Antrian Ticket Box -->
            <div class="bg-slate-50 rounded-md border border-slate-200 py-4 px-6 mb-5">
                <span class="text-[11px] font-semibold text-slate-500 block uppercase tracking-wider mb-1">Nomor Antrean Anda</span>
                <span class="text-4xl font-bold font-mono text-teal-800 tracking-wider">D-034</span>
                <span class="text-[11px] text-slate-500 block mt-1">Status: Menunggu Pemeriksaan</span>
            </div>

            <!-- QR Code Box -->
            <div class="flex justify-center mb-5">
                <div class="w-40 h-40 bg-white p-2 rounded-md border border-slate-200 flex items-center justify-center">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=SATUSEHAT-LPSK-D034-POLIGIGI&format=png&color=0f766e" alt="QR Code Tiket Antrean" class="w-full h-full object-contain">
                </div>
            </div>

            <!-- Detail Information Table -->
            <div class="bg-slate-50 rounded-md border border-slate-200 p-3 mb-5 text-left text-xs space-y-1.5 text-slate-600">
                <div class="flex justify-between py-1 border-b border-slate-200">
                    <span class="text-slate-500">Unit Layanan</span>
                    <span class="font-medium text-slate-900">Poli Gigi & Mulut</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-200">
                    <span class="text-slate-500">Dokter Bertugas</span>
                    <span class="font-medium text-slate-900">drg. Maya Putri</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-500">Estimasi Pelayanan</span>
                    <span class="font-semibold text-teal-800">10:15 WIB</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2 font-sans">
                <a href="{{ route('antrian.index') }}" wire:navigate class="w-full flex items-center justify-center py-2 bg-teal-700 text-white rounded-md font-medium text-xs hover:bg-teal-800 transition-colors shadow-2xs">
                    Pantau Layar Antrean
                </a>
                <a href="{{ route('dashboard') }}" wire:navigate class="w-full flex items-center justify-center py-2 border border-slate-300 text-slate-700 rounded-md font-medium text-xs hover:bg-slate-50 transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <div class="h-8"></div>
</x-app-layout>
