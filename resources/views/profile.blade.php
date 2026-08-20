<x-app-layout>
    <!-- Header with Back Button -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard') }}" wire:navigate class="p-2 text-gray-500 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="font-bold text-lg text-gray-900">Profil Saya</h1>
    </div>

    <div class="space-y-6 px-1">
        <!-- Update Profile Info Card -->
        <div class="p-5 bg-white border border-gray-150 rounded-3xl shadow-sm">
            <h3 class="font-bold text-sm text-gray-950 mb-4 border-b border-gray-50 pb-2">Informasi Profil</h3>
            <livewire:profile.update-profile-information-form />
        </div>

        <!-- Update Password Card -->
        <div class="p-5 bg-white border border-gray-150 rounded-3xl shadow-sm">
            <h3 class="font-bold text-sm text-gray-950 mb-4 border-b border-gray-50 pb-2">Ubah Kata Sandi</h3>
            <livewire:profile.update-password-form />
        </div>

        <!-- Delete User Card -->
        <div class="p-5 bg-white border border-gray-150 rounded-3xl shadow-sm">
            <h3 class="font-bold text-sm text-red-600 mb-4 border-b border-gray-50 pb-2">Hapus Akun</h3>
            <livewire:profile.delete-user-form />
        </div>
    </div>

    <div class="h-8"></div>
</x-app-layout>

