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

    <!-- Success Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center mx-2">
        <!-- Green Checkmark -->
        <div class="w-16 h-16 mx-auto mb-5 bg-emerald-500 rounded-full flex items-center justify-center shadow-lg shadow-emerald-200">
            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h2 class="text-base font-bold text-gray-900 mb-3">Antrian Berhasil Diambil</h2>

        <!-- Nomor Antrian -->
        <div class="text-4xl font-extrabold text-emerald-600 tracking-wider mb-5">D-034</div>

        <!-- QR Code -->
        <div class="flex justify-center mb-5">
            <div class="w-44 h-44 bg-white p-2 flex items-center justify-center">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=SATUSEHAT-LPSK-D034-POLIGIGI&format=png&color=000000" alt="QR Code" class="w-full h-full">
            </div>
        </div>

        <!-- Poli Info -->
        <p class="text-sm font-bold text-gray-900 mb-0.5">Poli Gigi</p>
        <p class="text-sm text-gray-500 mb-6">drg. Maya Putri</p>

        <!-- Action Buttons -->
        <a href="{{ route('antrian.index') }}" wire:navigate class="w-full flex items-center justify-center py-3.5 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 transition-colors mb-3 shadow-sm">
            Lihat Detail Antrian
        </a>
        <a href="{{ route('dashboard') }}" wire:navigate class="w-full flex items-center justify-center py-3.5 border-2 border-emerald-600 text-emerald-600 rounded-xl font-bold text-sm hover:bg-emerald-50 transition-colors">
            Kembali ke Beranda
        </a>
    </div>

    <div class="h-8"></div>
</x-app-layout>
