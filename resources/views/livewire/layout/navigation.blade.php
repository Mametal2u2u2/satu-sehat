<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="absolute bottom-0 left-0 right-0 z-50">
    <div class="relative bg-white border-t border-gray-100 shadow-[0_-2px_15px_rgba(0,0,0,0.04)] px-4 pt-2 pb-4 flex justify-around items-end">
        
        <!-- Beranda -->
        <a href="{{ route('patient.dashboard') }}" class="flex flex-col items-center gap-0.5 min-w-[56px] {{ request()->routeIs('patient.dashboard') || request()->routeIs('dashboard') || request()->routeIs('pasien.dashboard') || request()->is('pasien*') ? 'text-emerald-600' : 'text-gray-400' }}" wire:navigate>
            <svg class="w-6 h-6" fill="{{ request()->routeIs('patient.dashboard') || request()->routeIs('dashboard') || request()->routeIs('pasien.dashboard') || request()->is('pasien*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('patient.dashboard') || request()->routeIs('dashboard') || request()->routeIs('pasien.dashboard') || request()->is('pasien*') ? '0' : '1.8' }}">
                @if(request()->routeIs('patient.dashboard') || request()->routeIs('dashboard') || request()->routeIs('pasien.dashboard') || request()->is('pasien*'))
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                @endif
            </svg>
            <span class="text-[10px] font-semibold">Beranda</span>
        </a>

        <!-- Daftar Berobat -->
        <a href="{{ route('antrian.index', ['modal' => 'daftar']) }}" class="flex flex-col items-center gap-0.5 min-w-[56px] {{ request()->routeIs('antrian.*') && (request('modal') === 'daftar' || request('modal') === 'tambah') ? 'text-emerald-600' : 'text-gray-400' }}" wire:navigate>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-[10px] font-semibold">Daftar</span>
        </a>

        <!-- Floating Antrean Saya Center Button -->
        <div class="relative -top-5">
            <a href="{{ route('antrian.index') }}" title="Antrean Saya" class="flex items-center justify-center w-14 h-14 bg-emerald-600 rounded-full shadow-lg shadow-emerald-600/30 text-white hover:bg-emerald-700 transition-all hover:scale-105 border-4 border-white" wire:navigate>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 13h6v6H3v-6zm2 2v2h2v-2H5zm11-2h1v1h-1v-1zm-3 0h1v3h-1v-3zm5 0h1v1h-1v-1zm-1 2h1v1h-1v-1zm2 0h1v3h-1v-3zm-4 2h2v1h-2v-1zm2 1h1v1h-1v-1z"/>
                </svg>
            </a>
        </div>

        <!-- Jadwal Kunjungan -->
        <a href="{{ route('jadwal.index') }}" class="flex flex-col items-center gap-0.5 min-w-[56px] {{ request()->routeIs('jadwal.*') ? 'text-emerald-600' : 'text-gray-400' }}" wire:navigate>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-[10px] font-semibold">Jadwal</span>
        </a>

        <!-- Akun -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="flex flex-col items-center gap-0.5 min-w-[56px] {{ request()->routeIs('profile') ? 'text-emerald-600' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="text-[10px] font-semibold">Akun</span>
            </button>
            
            <!-- Dropdown Menu -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                 class="absolute bottom-full right-0 mb-3 w-48 rounded-2xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 overflow-hidden"
                 style="display: none;">
                <div class="px-4 py-3">
                    <p class="text-xs text-gray-400">Telah masuk sebagai</p>
                    <p class="text-sm font-bold text-gray-900 truncate" x-data="{{ json_encode(['name' => auth()->user()?->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></p>
                </div>
                <div class="py-1">
                    <a href="{{ route('profile') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50" wire:navigate>
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>
                    <button wire:click="logout" class="flex w-full items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
