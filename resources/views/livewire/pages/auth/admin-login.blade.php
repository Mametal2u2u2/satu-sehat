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
     * Handle an incoming staff/admin authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $user = auth()->user();
        $adminRoles = ['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Apoteker', 'Approver', 'Fisioterapis'];

        // Strict role validation: Pasien cannot log in via internal admin portal
        if ($user && ! $user->hasAnyRole($adminRoles)) {
            Auth::guard('web')->logout();
            Session::invalidate();
            Session::regenerateToken();

            $this->addError('form.login', 'Akses Ditolak: Akun Anda terdaftar sebagai Pasien. Silakan login melalui Portal Pasien.');
            return;
        }

        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
    }

    /**
     * Fill quick credentials for internal staff testing.
     */
    public function fillCredentials(string $role): void
    {
        if ($role === 'dokter') {
            $this->form->login = 'drbudi';
            $this->form->password = 'password';
        } else {
            $this->form->login = 'superadmin';
            $this->form->password = 'password';
        }
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Admin Portal Header Indicator -->
    <div class="mb-5 p-3.5 rounded-2xl bg-slate-900 text-white border border-slate-800 shadow-sm flex items-center justify-between gap-3">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-emerald-600 flex items-center justify-center font-black text-xs text-white">
                🔒
            </div>
            <div>
                <span class="text-xs font-black tracking-wide block">Portal Khusus Staf & Dokter</span>
                <span class="text-[10px] text-slate-400 block">Akses Terbatas Internal Klinik LPSK</span>
            </div>
        </div>
        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
            Internal
        </span>
    </div>

    <!-- Quick Staff Credentials for Demo Testing -->
    <div class="mb-5 p-3 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs">
        <div class="flex items-center justify-between gap-2 mb-2">
            <span class="font-black text-slate-800 uppercase tracking-wider text-[10px]">Akses Cepat Petugas:</span>
            <span class="text-[10px] text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200/60">Demo Staf</span>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" 
                    wire:click="fillCredentials('admin')" 
                    class="p-2 rounded-xl bg-white border border-slate-200 hover:border-emerald-500 text-left transition-all hover:shadow-xs group">
                <div class="flex items-center gap-1.5 font-bold text-slate-800 text-[11px] group-hover:text-emerald-700">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Super Admin</span>
                </div>
                <div class="text-[10px] text-slate-500 font-mono mt-0.5">superadmin</div>
            </button>

            <button type="button" 
                    wire:click="fillCredentials('dokter')" 
                    class="p-2 rounded-xl bg-white border border-slate-200 hover:border-emerald-500 text-left transition-all hover:shadow-xs group">
                <div class="flex items-center gap-1.5 font-bold text-slate-800 text-[11px] group-hover:text-emerald-700">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <span>Dokter Jaga</span>
                </div>
                <div class="text-[10px] text-slate-500 font-mono mt-0.5">drbudi</div>
            </button>
        </div>
    </div>

    <form wire:submit="login" class="space-y-4" id="adminLoginForm">
        <!-- Email or Username -->
        <div>
            <x-input-label for="admin_login" :value="__('NIP / Username / Email Petugas')" class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-1" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-text-input wire:model="form.login" 
                              id="admin_login" 
                              class="block w-full py-2.5 pl-10 pr-4 text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500" 
                              type="text" 
                              name="login" 
                              placeholder="Masukkan username staf atau email..." 
                              required 
                              autofocus 
                              autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('form.login')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="admin_password" :value="__('Kata Sandi Petugas')" class="text-xs font-bold text-slate-700 uppercase tracking-wider" />
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
                       id="admin_password" 
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
            <label for="admin_remember" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.remember" id="admin_remember" type="checkbox" class="rounded border-slate-300 text-emerald-600 shadow-xs focus:ring-emerald-500 w-4 h-4">
                <span class="ms-2 text-xs font-medium text-slate-600">Ingat sesi kerja di perangkat ini</span>
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
                        Proteksi Keamanan Internal
                    </span>
                    <span class="text-[10px] text-slate-400 font-mono">Turnstile</span>
                </div>

                <!-- Turnstile Container -->
                <div wire:ignore class="flex flex-col justify-center min-h-[65px] items-center">
                    <div id="cf-turnstile-container-admin"
                         class="cf-turnstile" 
                         data-sitekey="{{ config('services.turnstile.key', '3x00000000000000000000FF') }}" 
                         data-callback="turnstileCallbackAdmin"
                         data-expired-callback="turnstileExpiredCallbackAdmin"
                         data-theme="light">
                    </div>

                    <!-- Manual Fallback Verification (jika Turnstile diblokir/offline) -->
                    <div id="cf-fallback-container-admin" class="hidden mt-2 p-2.5 bg-white border border-slate-200 rounded-xl shadow-xs items-center gap-2.5">
                        <input type="checkbox" id="cf_manual_verify_admin" class="rounded border-slate-300 text-slate-800 focus:ring-slate-700 w-4 h-4 cursor-pointer" onchange="manualTurnstileToggleAdmin(this)">
                        <label for="cf_manual_verify_admin" class="text-xs font-semibold text-slate-700 cursor-pointer select-none">
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
                    class="w-full flex items-center justify-center gap-2 py-3.5 px-4 bg-slate-900 hover:bg-slate-800 active:scale-[0.99] text-white font-extrabold rounded-xl text-sm transition-all shadow-md shadow-slate-900/15 disabled:opacity-60 cursor-pointer">
                <svg wire:loading.remove class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove>Masuk ke Dashboard Staf</span>
                <span wire:loading>Memverifikasi Kredensial...</span>
            </button>
        </div>

        <!-- Back to Public Link -->
        <div class="text-center pt-3 border-t border-slate-150">
            <a href="{{ url('/') }}" class="text-xs text-slate-500 hover:text-slate-800 font-medium transition-colors inline-flex items-center gap-1">
                <span>&larr; Kembali ke Website Publik e-Klinik</span>
            </a>
        </div>
    </form>
</div>

<script>
    function turnstileCallbackAdmin(token) {
        @this.set('form.turnstile_token', token);
    }

    function turnstileExpiredCallbackAdmin() {
        @this.set('form.turnstile_token', '');
    }

    function manualTurnstileToggleAdmin(checkbox) {
        if (checkbox.checked) {
            @this.set('form.turnstile_token', 'MANUAL-DEV-VERIFIED');
        } else {
            @this.set('form.turnstile_token', '');
        }
    }

    function checkTurnstileStatusAdmin() {
        setTimeout(function () {
            const container = document.getElementById('cf-turnstile-container-admin');
            const fallback = document.getElementById('cf-fallback-container-admin');
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

    document.addEventListener('DOMContentLoaded', checkTurnstileStatusAdmin);
    document.addEventListener('livewire:navigated', function () {
        checkTurnstileStatusAdmin();
        if (typeof turnstile !== 'undefined') {
            const container = document.getElementById('cf-turnstile-container-admin');
            if (container && !container.hasChildNodes()) {
                try {
                    turnstile.render(container, {
                        sitekey: '{{ config('services.turnstile.key', '3x00000000000000000000FF') }}',
                        callback: turnstileCallbackAdmin,
                        'expired-callback': turnstileExpiredCallbackAdmin,
                        theme: 'light'
                    });
                } catch (e) {
                    console.warn('Turnstile render warning:', e);
                }
            }
        }
    });
</script>
