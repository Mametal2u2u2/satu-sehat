<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        Keamanan & Database
                    </span>
                    <span class="text-xs text-slate-300">•</span>
                    <span class="text-xs font-medium text-slate-500">SIMRS e-Klinik</span>
                </div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight mt-1">
                    Cadangan Database Klinik
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Pengelolaan pencadangan dan pemulihan data rekam medis, antrean, dan master obat klinik.
                </p>
            </div>

            <!-- Create Backup Form / Button -->
            <form method="POST" action="{{ route('admin.backup.create') }}" onsubmit="this.querySelector('button').disabled = true;">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-md bg-teal-700 hover:bg-teal-800 text-white font-medium text-xs shadow-2xs transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Buat Cadangan Baru</span>
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
        
        <!-- Database Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Metric 1: Database Type -->
            <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tipe Database</span>
                    <span class="w-7 h-7 rounded bg-slate-100 text-slate-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16"/>
                        </svg>
                    </span>
                </div>
                <p class="text-xl font-bold text-slate-900 mt-2 uppercase">{{ $dbDriver }}</p>
                <p class="text-[11px] text-slate-500 mt-0.5 truncate" title="{{ $dbFile }}">{{ basename($dbFile) }}</p>
            </div>

            <!-- Metric 2: Current DB Size -->
            <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Ukuran Database</span>
                    <span class="w-7 h-7 rounded bg-teal-50 text-teal-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </span>
                </div>
                <p class="text-xl font-bold text-slate-900 mt-2">{{ $dbSize }}</p>
                <p class="text-[11px] text-emerald-700 font-medium mt-0.5 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Aktif & Terbaca Normal
                </p>
            </div>

            <!-- Metric 3: Total Tables -->
            <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Jumlah Tabel</span>
                    <span class="w-7 h-7 rounded bg-blue-50 text-blue-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </span>
                </div>
                <p class="text-xl font-bold text-slate-900 mt-2">{{ $tableCount }} Tabel</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Skema EMR & Master Data</p>
            </div>

            <!-- Metric 4: Total Backups Stored -->
            <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Berkas Cadangan</span>
                    <span class="w-7 h-7 rounded bg-purple-50 text-purple-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </span>
                </div>
                <p class="text-xl font-bold text-slate-900 mt-2">{{ count($backups) }} File</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Penyimpanan Server Lokal</p>
            </div>
        </div>

        <!-- Backups List Table -->
        <div class="bg-white rounded-lg border border-slate-200 shadow-2xs overflow-hidden">
            <div class="p-4 border-b border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Riwayat Berkas Cadangan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar arsip database yang siap diunduh secara offline atau digunakan saat pemulihan.</p>
                </div>
                <span class="text-xs text-slate-600 font-medium">
                    Total: <strong class="text-slate-900 font-semibold">{{ count($backups) }}</strong> file tersimpan
                </span>
            </div>

            @if(count($backups) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-semibold text-slate-600 uppercase tracking-wider">
                                <th class="py-3 px-4">Nama Berkas Cadangan</th>
                                <th class="py-3 px-4">Waktu Pembuatan</th>
                                <th class="py-3 px-4">Ukuran</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-150 text-xs font-medium text-slate-700">
                            @foreach($backups as $b)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded bg-teal-50 text-teal-700 border border-teal-200 flex items-center justify-center shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-slate-900 block font-mono text-xs">
                                                    {{ $b['name'] }}
                                                </span>
                                                <span class="text-[10px] text-slate-500">
                                                    SQLite Database Snapshot
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-slate-900">
                                                {{ $b['created_at']->translatedFormat('d F Y, H:i:s') }}
                                            </span>
                                            <span class="text-[10px] text-slate-500">
                                                {{ $b['created_at']->diffForHumans() }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 font-medium text-slate-800">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[11px] font-mono border border-slate-200">
                                            {{ $b['size'] }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="inline-flex items-center gap-1.5">
                                            <!-- Download Button -->
                                            <a href="{{ route('admin.backup.download', ['filename' => $b['name']]) }}" 
                                               class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-teal-50 hover:bg-teal-100 text-teal-800 font-medium text-xs border border-teal-200 transition-colors"
                                               title="Unduh Berkas Cadangan">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                                <span>Unduh</span>
                                            </a>

                                            <!-- Delete Form -->
                                            <form method="POST" 
                                                  action="{{ route('admin.backup.delete', ['filename' => $b['name']]) }}" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus berkas backup ini? Tindakan ini tidak dapat dibatalkan.');"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-rose-50 hover:bg-rose-100 text-rose-700 font-medium text-xs border border-rose-200 transition-colors cursor-pointer"
                                                        title="Hapus Berkas Cadangan">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <div class="w-10 h-10 rounded-md bg-slate-100 text-slate-500 flex items-center justify-center mx-auto mb-3 border border-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-slate-800">Belum Ada Berkas Cadangan</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">
                        Sistem belum memiliki salinan backup database. Klik tombol "Buat Cadangan Baru" untuk mengamankan data pertama kali.
                    </p>
                </div>
            @endif
        </div>

        <!-- Restoration Guide Card -->
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-xs text-amber-900 flex items-start gap-3">
            <div class="w-7 h-7 rounded bg-amber-100 text-amber-800 flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="space-y-1 leading-relaxed">
                <h4 class="font-bold text-xs text-amber-950 uppercase tracking-wide">SOP & Petunjuk Pemulihan (Disaster Recovery):</h4>
                <p>
                    1. Berkas cadangan berformat <code class="bg-amber-100 px-1 py-0.5 rounded font-mono text-amber-900">.sqlite</code> dapat dipulihkan dengan menimpa berkas aktif di <code class="bg-amber-100 px-1 py-0.5 rounded font-mono text-amber-900">database/database.sqlite</code> saat layanan aplikasi dalam kondisi pemeliharaan (maintenance mode).
                </p>
                <p>
                    2. Disarankan menyalin berkas cadangan secara berkala ke media penyimpanan eksternal atau server backup terpisah guna mematuhi protokol pencegahan kehilangan data.
                </p>
                <p>
                    3. Berkas cadangan memuat data medis dan identitas pasien (PHI), simpan dengan enkripsi dan batasi akses hanya untuk administrator berwenang.
                </p>
            </div>
        </div>

    </div>
</x-app-layout>
