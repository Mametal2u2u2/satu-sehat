<x-app-layout>
    <div class="space-y-6">
        
        <!-- Header & Action Card -->
        <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold border border-emerald-400/30 mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16"/>
                        </svg>
                        <span>Sistem Keamanan & Cadangan Data</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                        Cadangan Database Klinik
                    </h1>
                    <p class="text-emerald-100/80 text-xs sm:text-sm mt-1 max-w-xl leading-relaxed">
                        Kelola pencadangan berkala database rekam medis, antrian, akun staf, dan data sediaan obat klinik untuk menjaga keamanan operasional.
                    </p>
                </div>

                <!-- Create Backup Form / Button -->
                <form method="POST" action="{{ route('admin.backup.create') }}" onsubmit="this.querySelector('button').disabled = true;">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-emerald-500 hover:bg-emerald-400 active:scale-95 text-emerald-950 font-black text-xs sm:text-sm shadow-lg shadow-emerald-950/30 transition-all cursor-pointer hover:shadow-emerald-400/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Buat Backup Baru Sekarang</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Database Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Metric 1: Database Type -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500">Tipe Database</span>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16"/>
                        </svg>
                    </span>
                </div>
                <p class="text-xl font-black text-slate-900 mt-2 uppercase">{{ $dbDriver }}</p>
                <p class="text-[11px] text-slate-500 mt-1 truncate" title="{{ $dbFile }}">{{ basename($dbFile) }}</p>
            </div>

            <!-- Metric 2: Current DB Size -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500">Ukuran Data Aktif</span>
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </span>
                </div>
                <p class="text-xl font-black text-slate-900 mt-2">{{ $dbSize }}</p>
                <p class="text-[11px] text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Kondisi Sehat & Terbaca
                </p>
            </div>

            <!-- Metric 3: Total Tables -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500">Jumlah Tabel</span>
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </span>
                </div>
                <p class="text-xl font-black text-slate-900 mt-2">{{ $tableCount }} Tabel</p>
                <p class="text-[11px] text-slate-500 mt-1">Skema EMR & Master Data</p>
            </div>

            <!-- Metric 4: Total Backups Stored -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500">File Cadangan</span>
                    <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </span>
                </div>
                <p class="text-xl font-black text-slate-900 mt-2">{{ count($backups) }} File</p>
                <p class="text-[11px] text-slate-500 mt-1">Tersimpan di Penyimpanan Lokal</p>
            </div>
        </div>

        <!-- Backups List Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-150 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Riwayat Berkas Cadangan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar file cadangan database yang siap diunduh atau dipulihkan.</p>
                </div>
                <span class="text-xs text-slate-400 font-medium">
                    Total: <strong class="text-slate-700 font-bold">{{ count($backups) }}</strong> file tersimpan
                </span>
            </div>

            @if(count($backups) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-6">Nama Berkas Cadangan</th>
                                <th class="py-3.5 px-6">Waktu Pembuatan</th>
                                <th class="py-3.5 px-6">Ukuran</th>
                                <th class="py-3.5 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-150 text-xs font-medium text-slate-700">
                            @foreach($backups as $b)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="font-extrabold text-slate-900 block font-mono text-xs">
                                                    {{ $b['name'] }}
                                                </span>
                                                <span class="text-[10px] text-slate-400">
                                                    Database Snapshot Format SQLite
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800">
                                                {{ $b['created_at']->translatedFormat('d F Y, H:i:s') }}
                                            </span>
                                            <span class="text-[10px] text-slate-400">
                                                {{ $b['created_at']->diffForHumans() }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 font-bold text-slate-800">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[11px] font-mono">
                                            {{ $b['size'] }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <!-- Download Button -->
                                            <a href="{{ route('admin.backup.download', ['filename' => $b['name']]) }}" 
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs border border-emerald-200 transition-colors shadow-2xs"
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
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-700 font-bold text-xs border border-red-200 transition-colors cursor-pointer"
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
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 border border-emerald-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 5h16M9 4v16"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800">Belum Ada File Cadangan</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">
                        Sistem belum memiliki salinan backup database. Klik tombol "Buat Backup Baru Sekarang" untuk membuat salinan data pertama Anda.
                    </p>
                </div>
            @endif
        </div>

        <!-- Restoration Guide Card -->
        <div class="bg-amber-50/70 border border-amber-200/80 rounded-3xl p-6 text-xs text-amber-900 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="space-y-1 leading-relaxed">
                <h4 class="font-extrabold text-sm text-amber-950">Petunjuk Pemulihan (Restore) Database:</h4>
                <p>
                    1. Berkas cadangan berformat <strong>.sqlite</strong> dapat dipulihkan dengan mengganti berkas <code class="bg-amber-200/60 px-1 py-0.5 rounded font-mono">database/database.sqlite</code> saat server dalam kondisi jeda.
                </p>
                <p>
                    2. Selalu simpan salinan cadangan di perangkat eksternal atau cloud yang aman untuk mengantisipasi kegagalan perangkat keras lokal.
                </p>
                <p>
                    3. Berkas cadangan memuat data sensitif pasien rekam medis, pastikan hak akses berkas ini dijaga sesuai standar kepatuhan privasi data medis Kemenkes.
                </p>
            </div>
        </div>

    </div>
</x-app-layout>
