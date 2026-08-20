# Redesign UI "Satu Sehat" & Integrasi Google Login

Berdasarkan referensi desain yang Anda berikan, saya akan merombak tampilan UI agar terlihat persis seperti aplikasi mobile "Satu Sehat" (tema hijau putih, mobile-first, bottom navigation, card antrian dengan QR code). Saya juga akan menambahkan fitur **Login with Google** menggunakan Laravel Socialite.

## Open Questions / Kebutuhan Akses
> [!IMPORTANT]
> Untuk mengaktifkan **Login with Google**, Anda perlu membuat Google OAuth 2.0 Client ID di Google Cloud Console. Apakah Anda sudah memilikinya? Jika belum, saya bisa memberikan panduan cara membuatnya. Setelah selesai, kita perlu memasukkan `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` ke dalam file `.env`.

## Proposed Changes

### 1. Integrasi Google Login (Laravel Socialite)
Saya akan menginstal package `laravel/socialite` dan melakukan setup otentikasi Google.

#### [NEW] app/Http/Controllers/Auth/GoogleController.php
- Membuat controller baru untuk menangani redirect ke Google dan callback dari Google.
- Jika email sudah ada, akan otomatis login. Jika belum, akan otomatis mendaftarkan user baru.

#### [MODIFY] routes/web.php
- Menambahkan route `/auth/google` (redirect) dan `/auth/google/callback` (handler).

#### [MODIFY] config/services.php
- Menambahkan konfigurasi `google` (client_id, client_secret, redirect).

#### [MODIFY] database/migrations/xxx_create_users_table.php (atau membuat migration baru)
- Menambahkan kolom `google_id` dan mengubah password menjadi `nullable` (karena login via google tidak butuh password).

#### [MODIFY] resources/views/livewire/pages/auth/login.blade.php
- Menambahkan tombol **"Login dengan Google"** yang cantik dan sesuai dengan tema.

---

### 2. Redesign UI & Layout (Mobile-First "Satu Sehat" Theme)
Sistem ini akan dioptimalkan untuk tampilan smartphone/mobile-first, dengan warna identitas **Hijau Tua (Emerald)**.

#### [MODIFY] tailwind.config.js & resources/css/app.css
- Mengubah warna utama dari `blue/sky` menjadi `emerald/green` yang identik dengan Satu Sehat.
- Menambahkan utility class untuk card dengan border hijau tipis.

#### [MODIFY] resources/views/layouts/app.blade.php & navigation.blade.php
- **Menghapus Sidebar** dan menggantinya dengan **Bottom Navigation Bar** khas aplikasi mobile (Beranda, Antrian, Jadwal, Akun).
- Header atas yang rapi dengan logo "Satu Sehat LPSK" dan icon lonceng (notifikasi).

#### [MODIFY] resources/views/dashboard.blade.php
- Mengubah dashboard menjadi tampilan "Home" seperti di gambar Kiri:
  - Header sapaan pasien dengan latar belakang ilustrasi gedung LPSK.
  - Grid 4 menu utama: Cek Antrian, Jadwal Dokter, Pengingat, Riwayat (dengan icon yang sesuai).
  - Card "Antrian Saya" yang menampilkan status antrian aktif (Nomor A-034, Estimasi Jam) dengan border hijau dan tombol "Lihat Detail Antrian".

#### [NEW] resources/views/antrian/detail.blade.php
- Membuat halaman baru persis seperti gambar Kanan ("Ambil Antrian" / Detail).
- Menampilkan pesan sukses, nomor antrian raksasa berwarna hijau.
- Menampilkan gambar/komponen **QR Code**.
- Menampilkan nama dokter dan poli di bawah QR code.
- Tombol action besar berwarna hijau.

## Verification Plan
1. **Google Login:** Mencoba klik tombol "Login dengan Google" di halaman login, memverifikasi proses OAuth, dan memastikan user otomatis terdaftar/masuk ke dashboard.
2. **UI Check:** Mensimulasikan tampilan browser ke mode Mobile (Inspect Element) untuk melihat apakah layout bottom bar, card antrian, dan QR code tampil persis dengan proporsi desain referensi.
