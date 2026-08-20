<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register" class="space-y-4">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1" />
            <x-text-input wire:model="name" id="name" class="block w-full py-3 px-4 text-sm" type="text" name="name" placeholder="Nama Lengkap Anda" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1" />
            <x-text-input wire:model="email" id="email" class="block w-full py-3 px-4 text-sm" type="email" name="email" placeholder="contoh@email.com" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1" />
            <x-text-input wire:model="password" id="password" class="block w-full py-3 px-4 text-sm"
                            type="password"
                            name="password"
                            placeholder="Buat password baru"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block w-full py-3 px-4 text-sm"
                            type="password"
                            name="password_confirmation" 
                            placeholder="Ulangi password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Register Button -->
        <div class="pt-2">
            <button type="submit" class="w-full flex items-center justify-center py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition-colors shadow-sm">
                Daftar Akun Baru
            </button>
        </div>

        <!-- Footer / Login Link -->
        <div class="text-center pt-4">
            <p class="text-xs text-gray-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 font-bold" wire:navigate>
                    Masuk Sekarang
                </a>
            </p>
        </div>
    </form>
</div>

