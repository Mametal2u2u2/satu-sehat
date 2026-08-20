<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Satu Sehat LPSK') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">
        <!-- Top Navbar for Web / Large Screens (Hidden on Mobile) -->
        <nav class="hidden md:block bg-white border-b border-gray-200 sticky top-0 z-50 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm p-1.5 border border-emerald-100">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/e/ea/Logo_Garuda_Pancasila_Emas.svg" alt="Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <span class="font-extrabold text-gray-900 tracking-tight block">Satu Sehat LPSK</span>
                            <span class="text-[9px] text-emerald-600 font-bold block -mt-1 uppercase tracking-wide">Melayani dengan Hati</span>
                        </div>
                    </div>
                    <!-- Desktop Menu Links -->
                    <div class="flex space-x-2 items-center">
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold py-2 px-3.5 rounded-xl transition-all {{ request()->routeIs('dashboard') || request()->routeIs('pasien.dashboard') ? 'text-emerald-600 bg-emerald-50/50' : 'text-gray-500 hover:text-emerald-600 hover:bg-emerald-50/30' }}">Beranda</a>
                        <a href="{{ route('antrian.index') }}" class="text-sm font-semibold py-2 px-3.5 rounded-xl transition-all {{ request()->routeIs('antrian.*') ? 'text-emerald-600 bg-emerald-50/50' : 'text-gray-500 hover:text-emerald-600 hover:bg-emerald-50/30' }}">Antrian</a>
                        <a href="{{ route('jadwal.index') }}" class="text-sm font-semibold py-2 px-3.5 rounded-xl transition-all {{ request()->routeIs('jadwal.*') ? 'text-emerald-600 bg-emerald-50/50' : 'text-gray-500 hover:text-emerald-600 hover:bg-emerald-50/30' }}">Jadwal</a>
                        <a href="{{ route('rekam-medis.index') }}" class="text-sm font-semibold py-2 px-3.5 rounded-xl transition-all {{ request()->routeIs('rekam-medis.*') ? 'text-emerald-600 bg-emerald-50/50' : 'text-gray-500 hover:text-emerald-600 hover:bg-emerald-50/30' }}">Rekam Medis</a>
                        <a href="{{ route('profile') }}" class="text-sm font-semibold py-2 px-3.5 rounded-xl transition-all {{ request()->routeIs('profile') ? 'text-emerald-600 bg-emerald-50/50' : 'text-gray-500 hover:text-emerald-600 hover:bg-emerald-50/30' }}">Profil</a>
                        
                        <div class="h-6 w-px bg-gray-200 mx-2"></div>

                        <!-- Portal View Selector -->
                        <a href="{{ request()->routeIs('admin.dashboard') ? route('dashboard') : route('admin.dashboard') }}" 
                           class="text-xs font-semibold py-1.5 px-3 rounded-lg border transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100' : 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' }}"
                           title="Ganti Mode Tampilan Portal">
                            {{ request()->routeIs('admin.dashboard') ? '👤 Ke Portal Pasien' : '🛡️ Ke Portal Admin' }}
                        </a>

                        <!-- User Profile tag -->
                        <span class="text-xs font-semibold text-gray-600 bg-gray-100 py-1.5 px-3.5 rounded-full mr-2">
                            {{ auth()->user()?->name ?? 'User' }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-700 py-2 px-3.5 rounded-xl hover:bg-red-50 transition-colors">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Wrapper -->
        <!-- On mobile: constraints to full 100vh app style. On desktop: expands naturally as a wide web page. -->
        <div class="flex-1 w-full max-w-7xl mx-auto bg-white min-h-[calc(100vh-4rem)] md:shadow-md md:border-x md:border-gray-100 flex flex-col relative">
            
            <!-- Content Area -->
            <div class="flex-1 md:overflow-visible pb-20 md:pb-8 overflow-y-auto">
                <main class="p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>

            <!-- Bottom Navigation Bar for Mobile Only -->
            <div class="md:hidden">
                <livewire:layout.navigation />
            </div>
            
        </div>
    </body>

</html>
