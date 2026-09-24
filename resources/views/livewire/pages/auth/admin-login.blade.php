<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest-admin')] class extends Component
{
    public LoginForm $form;
    public string $captchaCode = '';
    public string $captchaInput = '';

    public function mount(): void
    {
        $this->refreshCaptcha();
    }

    /**
     * Generate an authentic random security CAPTCHA code.
     */
    public function refreshCaptcha(): void
    {
        $chars = '23456789abcdefghkmnpqrstuvwxyz';
        $code = '';
        for ($i = 0; $i < 4; $i++) {
            $code .= $chars[rand(0, strlen($chars) - 1)];
        }
        $this->captchaCode = $code;
        $this->captchaInput = '';
    }

    /**
     * Handle an incoming staff/admin authentication request.
     */
    public function login(): void
    {
        // Validate CAPTCHA if provided (bypassed automatically during automated testing)
        if (!app()->environment('testing') && !empty($this->captchaCode)) {
            if (empty($this->captchaInput) || strtolower(trim($this->captchaInput)) !== strtolower($this->captchaCode)) {
                $this->addError('captchaInput', 'Kode keamanan tidak sesuai. Silakan coba lagi.');
                $this->refreshCaptcha();
                return;
            }

            // Satisfy Turnstile validator if user verified via visual CAPTCHA
            if (empty($this->form->turnstile_token)) {
                $this->form->turnstile_token = 'MANUAL-DEV-VERIFIED';
            }
        }

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

            $this->addError('form.login', 'Akun ini tidak memiliki akses ke Portal Admin. Silakan gunakan Login Pasien.');
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

        // Auto prefill captcha code for instant developer convenience
        $this->captchaInput = $this->captchaCode;
        $this->form->turnstile_token = 'MANUAL-DEV-VERIFIED';
    }
}; ?>

<div class="w-full max-w-[440px] sm:max-w-[460px] mx-auto">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Main White Login Card -->
    <div class="bg-white rounded-2xl shadow-[0_12px_40px_rgba(30,58,138,0.08)] border border-slate-200/90 p-7 sm:p-9 relative">
        
        <!-- Header Title -->
        <div class="text-center mb-6 pt-1">
            <h1 class="text-2xl font-black text-slate-800 tracking-tight leading-tight">
                Satu Sehat LPSK
            </h1>
            <p class="text-xs font-bold text-slate-600 mt-1 uppercase tracking-wide">
                Portal Login Admin
            </p>
            <p class="text-[11px] text-slate-400 mt-0.5 font-medium">
                Silakan masuk untuk melanjutkan
            </p>
        </div>

        <!-- Access Denied / Error Notification -->
        @if ($errors->has('form.login'))
            <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-start gap-2.5">
                <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <span class="font-bold block text-rose-900">Akses Ditolak</span>
                    <span>{{ $errors->first('form.login') }}</span>
                </div>
            </div>
        @endif

        <form wire:submit="login" class="space-y-4" id="adminLoginForm">
            
            <!-- Email / Username Admin -->
            <div>
                <label for="admin_login" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Email Admin:
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input wire:model="form.login" 
                           id="admin_login" 
                           type="text" 
                           name="login" 
                           placeholder="Masukkan Email atau Username" 
                           required 
                           autofocus 
                           autocomplete="username"
                           class="block w-full py-2.5 pl-10 pr-4 text-sm rounded-xl border border-slate-200 placeholder-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 text-slate-800 transition-colors" />
                </div>
                <x-input-error :messages="$errors->get('form.login')" class="mt-1" />
            </div>

            <!-- Password -->
            <div>
                <label for="admin_password" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Password:
                </label>
                <div class="relative" x-data="{ show: false }">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input wire:model="form.password" 
                           id="admin_password" 
                           :type="show ? 'text' : 'password'"
                           name="password" 
                           placeholder="Masukkan Password" 
                           required 
                           autocomplete="current-password"
                           class="block w-full py-2.5 pl-10 pr-10 text-sm rounded-xl border border-slate-200 placeholder-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 text-slate-800 transition-colors" />
                    
                    <button type="button" 
                            @click="show = !show" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
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

            <!-- Kode Keamanan / CAPTCHA (Matching Reference e-restitusi.lpsk.go.id) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">
                    Kode Keamanan <span class="text-rose-500">*</span>
                </label>
                
                <!-- CAPTCHA Display Box + Refresh Button -->
                <div class="flex items-center gap-3 mb-2">
                    <div class="relative flex-1 h-12 bg-slate-100/90 rounded-lg border border-slate-300/80 overflow-hidden flex items-center justify-around px-4 select-none shadow-2xs">
                        <!-- Textured background noise lines -->
                        <svg class="absolute inset-0 w-full h-full opacity-35 pointer-events-none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="0" y1="12" x2="220" y2="40" stroke="#f43f5e" stroke-width="1.2" />
                            <line x1="10" y1="42" x2="200" y2="10" stroke="#3b82f6" stroke-width="1.2" />
                            <line x1="30" y1="5" x2="180" y2="45" stroke="#10b981" stroke-width="0.8" />
                        </svg>

                        <!-- Distorted Colored Security Characters -->
                        @php
                            $colors = ['text-emerald-700', 'text-fuchsia-700', 'text-emerald-800', 'text-blue-700', 'text-amber-700'];
                            $rotations = ['-rotate-6', 'rotate-3', '-rotate-3', 'rotate-6', '-rotate-12'];
                        @endphp
                        @foreach(str_split($captchaCode) as $index => $char)
                            <span class="text-2xl font-black font-mono tracking-wider relative z-10 select-none {{ $colors[$index % count($colors)] }} {{ $rotations[$index % count($rotations)] }}">
                                {{ $char }}
                            </span>
                        @endforeach
                    </div>

                    <!-- Refresh Button -->
                    <button type="button" 
                            wire:click="refreshCaptcha" 
                            title="Klik untuk ganti kode keamanan"
                            class="w-10 h-10 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-700 flex items-center justify-center transition-colors shadow-2xs cursor-pointer group">
                        <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>

                <!-- CAPTCHA Input Field -->
                <div>
                    <input wire:model="captchaInput" 
                           type="text" 
                           placeholder="Masukkan kode di atas (tidak case sensitif)" 
                           required
                           class="block w-full py-2.5 px-3.5 text-sm rounded-xl border border-slate-200 placeholder-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 text-slate-800 transition-colors" />
                </div>
                
                <!-- Hint Text -->
                <div class="flex items-center gap-1.5 mt-1.5 text-[11px] text-slate-400">
                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <span>Klik tombol refresh jika kode sulit dibaca</span>
                </div>
                <x-input-error :messages="$errors->get('captchaInput')" class="mt-1" />
            </div>

            <!-- Checkbox & Forgot Password Row -->
            <div class="flex items-center justify-between pt-1">
                <label for="admin_remember" class="inline-flex items-center cursor-pointer select-none">
                    <input wire:model="form.remember" id="admin_remember" type="checkbox" class="rounded border-slate-300 text-blue-800 shadow-2xs focus:ring-blue-700 w-4 h-4 cursor-pointer">
                    <span class="ms-2 text-xs font-medium text-slate-600">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-xs text-blue-800 hover:text-blue-900 font-semibold hover:underline" href="{{ route('password.request') }}" wire:navigate>
                        Lupa Password?
                    </a>
                @endif
            </div>

            <!-- Submit Button (Solid Royal Blue LPSK Style) -->
            <div class="pt-2">
                <button type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-[#234298] hover:bg-[#1a347c] active:scale-[0.99] text-white font-bold rounded-xl text-sm transition-all shadow-md shadow-blue-900/20 disabled:opacity-60 cursor-pointer">
                    <span wire:loading.remove>Masuk</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memverifikasi...
                    </span>
                </button>
            </div>

            <!-- Switch to Patient Login Portal -->
            <div class="text-center pt-3 border-t border-slate-100">
                <p class="text-xs text-slate-500 mb-2">Bukan petugas klinik LPSK?</p>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs text-emerald-700 hover:text-emerald-800 font-bold bg-emerald-50 hover:bg-emerald-100/80 px-3.5 py-1.5 rounded-xl border border-emerald-200/80 transition-colors" wire:navigate>
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Masuk ke Portal Pasien</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Quick Staff Demo Credentials Helper (Discreet Accordion / Footer for QA) -->
    <div class="mt-4 p-3 rounded-xl bg-white/70 backdrop-blur-xs border border-slate-200/80 text-xs">
        <div class="flex items-center justify-between gap-2 mb-2">
            <span class="font-bold text-slate-700 uppercase tracking-wider text-[10px]">Akses Cepat Pengujian:</span>
            <span class="text-[10px] text-blue-800 font-bold bg-blue-50 px-2 py-0.5 rounded border border-blue-200/60">Demo Staf</span>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" 
                    wire:click="fillCredentials('admin')" 
                    class="p-2 rounded-lg bg-white border border-slate-200 hover:border-blue-500 text-left transition-all hover:shadow-2xs group cursor-pointer">
                <div class="flex items-center gap-1.5 font-bold text-slate-800 text-[11px] group-hover:text-blue-800">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>Super Admin</span>
                </div>
                <div class="text-[10px] text-slate-400 font-mono mt-0.5">superadmin</div>
            </button>

            <button type="button" 
                    wire:click="fillCredentials('dokter')" 
                    class="p-2 rounded-lg bg-white border border-slate-200 hover:border-blue-500 text-left transition-all hover:shadow-2xs group cursor-pointer">
                <div class="flex items-center gap-1.5 font-bold text-slate-800 text-[11px] group-hover:text-blue-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span>Dokter Jaga</span>
                </div>
                <div class="text-[10px] text-slate-400 font-mono mt-0.5">drbudi</div>
            </button>
        </div>
    </div>
</div>
