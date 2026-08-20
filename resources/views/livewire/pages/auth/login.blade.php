<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1" />
            <x-text-input wire:model="form.email" id="email" class="block w-full py-3 px-4 text-sm" type="email" name="email" placeholder="contoh@email.com" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="password" :value="__('Password')" class="text-xs font-bold text-gray-500 uppercase tracking-wider" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-emerald-600 hover:text-emerald-700 font-bold" href="{{ route('password.request') }}" wire:navigate>
                        Lupa password?
                    </a>
                @endif
            </div>
            <x-text-input wire:model="form.password" id="password" class="block w-full py-3 px-4 text-sm"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-200 text-emerald-600 shadow-sm focus:ring-emerald-500 w-4.5 h-4.5" name="remember">
                <span class="ms-2 text-xs font-medium text-gray-500">Ingat saya</span>
            </label>
        </div>

        <!-- Login Button -->
        <div class="pt-2">
            <button type="submit" class="w-full flex items-center justify-center py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition-colors shadow-sm">
                Masuk ke Akun
            </button>
        </div>
        
        <!-- Separator -->
        <div class="flex items-center my-3">
            <span class="border-b w-full border-gray-100"></span>
            <span class="text-[10px] text-gray-400 font-bold px-3 uppercase tracking-wider whitespace-nowrap">Atau</span>
            <span class="border-b w-full border-gray-100"></span>
        </div>

        <!-- Google Login -->
        <div>
            <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center py-3.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="h-5 w-5 mr-2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Masuk dengan Google
            </a>
        </div>

        <!-- Footer / Register Link -->
        <div class="text-center pt-4">
            <p class="text-xs text-gray-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-700 font-bold" wire:navigate>
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </form>
</div>

