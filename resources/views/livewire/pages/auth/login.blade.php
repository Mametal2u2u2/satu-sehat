<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request for Patient Portal.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $user = auth()->user();

        $adminRoles = ['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Apoteker', 'Approver', 'Fisioterapis'];
        
        // Strict role validation: Admin/Petugas/Staff CANNOT log in via Patient Portal
        if ($user && $user->hasAnyRole($adminRoles)) {
            Auth::guard('web')->logout();
            Session::invalidate();
            Session::regenerateToken();

            $this->addError('form.login', 'Akun ini tidak memiliki akses ke Portal Pasien. Silakan gunakan Login Admin.');
            return;
        }

        $this->redirectIntended(default: route('patient.dashboard', absolute: false), navigate: true);
    }

    /**
     * Fill quick credentials for demo testing.
     */
    public function fillCredentials(): void
    {
        $this->form->login = 'pasien';
        $this->form->password = 'password';
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Patient Portal Identity Header -->
    <div class="mb-5 p-3.5 rounded-2xl bg-gradient-to-r from-emerald-800 to-teal-800 text-white border border-emerald-700/60 shadow-sm flex items-center justify-between gap-3">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center font-bold text-sm text-white">
                👤
            </div>
            <div>
                <span class="text-xs font-black tracking-wide block">Portal Pasien Resmi</span>
                <span class="text-[10px] text-emerald-200 block">Layanan Terpadu Satu Sehat LPSK</span>
            </div>
        </div>
        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-emerald-500/30 text-emerald-100 border border-emerald-400/30">
            Pasien
        </span>
    </div>

    <!-- Quick Patient Demo Access -->
    <div class="mb-5 p-3 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs">
        <div class="flex items-center justify-between gap-2 mb-2">
            <span class="font-black text-slate-800 uppercase tracking-wider text-[10px]">Akses Masuk Cepat Pasien:</span>
            <span class="text-[10px] text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200/60">Demo Pasien</span>
        </div>
        <div>
            <button type="button" 
                    wire:click="fillCredentials" 
                    class="w-full p-2.5 rounded-xl bg-white border border-slate-200 hover:border-emerald-500 text-left transition-all hover:shadow-xs group flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <div>
                        <div class="font-bold text-slate-800 text-xs group-hover:text-emerald-700">Akun Pasien Terdaftar</div>
                        <div class="text-[10px] text-slate-500 font-mono mt-0.5">Username: pasien • Sandi: password</div>
                    </div>
                </div>
                <span class="text-xs font-bold text-emerald-700 group-hover:translate-x-0.5 transition-transform">&rarr;</span>
            </button>
        </div>
    </div>

    <form wire:submit="login" class="space-y-4" id="loginForm">
        @if ($errors->has('form.login'))
            <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-start gap-2.5">
                <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <span class="font-bold block text-rose-900">Akses Ditolak</span>
                    <span>{{ $errors->first('form.login') }}</span>
                </div>
            </div>
        @endif

        <!-- Email or Username -->
        <div>
            <x-input-label for="login" :value="__('Email atau Username')" class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-1" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-text-input wire:model="form.login" 
                              id="login" 
                              class="block w-full py-2.5 pl-10 pr-4 text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500" 
                              type="text" 
                              name="login" 
                              placeholder="Masukkan username atau email..." 
                              required 
                              autofocus 
                              autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('form.login')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="password" :value="__('Password')" class="text-xs font-bold text-slate-700 uppercase tracking-wider" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-emerald-700 hover:text-emerald-800 font-bold hover:underline" href="{{ route('password.request') }}" wire:navigate>
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative" x-data="{ show: false }">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input wire:model="form.password" 
                       id="password" 
                       class="block w-full py-2.5 pl-10 pr-10 text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500"
                       :type="show ? 'text' : 'password'"
                       name="password"
                       placeholder="••••••••"
                       required 
                       autocomplete="current-password" />
                <button type="button" 
                        @click="show = !show" 
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-0.5">
            <label for="remember" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-slate-300 text-emerald-600 shadow-xs focus:ring-emerald-500 w-4 h-4">
                <span class="ms-2 text-xs font-medium text-slate-600">Ingat saya di perangkat ini</span>
            </label>
        </div>

        <!-- Cloudflare Turnstile Bot Protection Widget -->
        <div class="pt-2 pb-1">
            <div class="p-3 bg-slate-50/80 rounded-2xl border border-slate-200/90 text-center">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold text-slate-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Proteksi Keamanan
                    </span>
                    <span class="text-[10px] text-slate-400 font-mono">Cloudflare Turnstile</span>
                </div>

                <!-- Turnstile Container -->
                <div wire:ignore class="flex flex-col justify-center min-h-[65px] items-center">
                    <div id="cf-turnstile-container"
                         class="cf-turnstile" 
                         data-sitekey="{{ config('services.turnstile.key', '3x00000000000000000000FF') }}" 
                         data-callback="turnstileCallback"
                         data-expired-callback="turnstileExpiredCallback"
                         data-theme="light">
                    </div>

                    <!-- Manual Fallback Verification (jika Turnstile diblokir/offline) -->
                    <div id="cf-fallback-container" class="hidden mt-2 p-2.5 bg-white border border-slate-200 rounded-xl shadow-xs items-center gap-2.5">
                        <input type="checkbox" id="cf_manual_verify" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4 cursor-pointer" onchange="manualTurnstileToggle(this)">
                        <label for="cf_manual_verify" class="text-xs font-semibold text-slate-700 cursor-pointer select-none">
                            Saya bukan robot (Verifikasi Manual)
                        </label>
                    </div>
                </div>

                <x-input-error :messages="$errors->get('form.turnstile_token')" class="mt-2 text-center text-xs" />
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full flex items-center justify-center gap-2 py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 active:scale-[0.99] text-white font-extrabold rounded-xl text-sm transition-all shadow-md shadow-emerald-800/15 disabled:opacity-60 cursor-pointer">
                <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove>Login Pasien</span>
                <span wire:loading>Memverifikasi Pasien...</span>
            </button>
        </div>
        
        <!-- Separator -->
        <div class="flex items-center my-3">
            <span class="border-b w-full border-slate-200"></span>
            <span class="text-[10px] text-slate-400 font-bold px-3 uppercase tracking-wider whitespace-nowrap">Atau Masuk Cepat</span>
            <span class="border-b w-full border-slate-200"></span>
        </div>

        <!-- Google Login -->
        <div>
            <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center py-3 border border-slate-200 hover:border-slate-300 rounded-xl text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 transition-colors shadow-2xs">
                <svg class="h-4 w-4 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Masuk Akun Google
            </a>
        </div>

        <!-- Footer / Register & Admin Switch Link -->
        <div class="text-center pt-3 border-t border-slate-100 space-y-2.5">
            <p class="text-xs text-slate-500">
                Belum terdaftar sebagai pasien? 
                <a href="{{ route('register') }}" class="text-emerald-700 hover:text-emerald-800 font-bold hover:underline" wire:navigate>
                    Daftar Akun Baru
                </a>
            </p>
            <div class="pt-1">
                <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-600 hover:text-slate-900 font-semibold bg-slate-100 hover:bg-slate-200 px-3.5 py-1.5 rounded-xl border border-slate-200 transition-colors" wire:navigate>
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>Login sebagai Admin / Petugas</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    function turnstileCallback(token) {
        @this.set('form.turnstile_token', token);
    }

    function turnstileExpiredCallback() {
        @this.set('form.turnstile_token', '');
    }

    function manualTurnstileToggle(checkbox) {
        if (checkbox.checked) {
            @this.set('form.turnstile_token', 'MANUAL-DEV-VERIFIED');
        } else {
            @this.set('form.turnstile_token', '');
        }
    }

    function checkTurnstileStatus() {
        setTimeout(function () {
            const container = document.getElementById('cf-turnstile-container');
            const fallback = document.getElementById('cf-fallback-container');
            // If Cloudflare script is not loaded or container is completely empty after timeout, show manual fallback
            if (container && fallback) {
                if (typeof turnstile === 'undefined' || !container.hasChildNodes()) {
                    fallback.classList.remove('hidden');
                    fallback.classList.add('flex');
                } else {
                    fallback.classList.add('hidden');
                    fallback.classList.remove('flex');
                }
            }
        }, 2000);
    }

    document.addEventListener('DOMContentLoaded', checkTurnstileStatus);
    document.addEventListener('livewire:navigated', function () {
        checkTurnstileStatus();
        if (typeof turnstile !== 'undefined') {
            const container = document.getElementById('cf-turnstile-container');
            if (container && !container.hasChildNodes()) {
                try {
                    turnstile.render(container, {
                        sitekey: '{{ config('services.turnstile.key', '3x00000000000000000000FF') }}',
                        callback: turnstileCallback,
                        'expired-callback': turnstileExpiredCallback,
                        theme: 'light'
                    });
                } catch (e) {
                    console.warn('Turnstile render warning:', e);
                }
            }
        }
    });
</script>
