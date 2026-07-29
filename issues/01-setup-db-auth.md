# Issue 1: Setup Database (SQLite) & Authentication

## Deskripsi
Tugas ini adalah langkah awal dalam pembuatan aplikasi pencatat keuangan. Kita perlu mengatur database menggunakan SQLite (bawaan Laravel yang ringan untuk development) dan mengatur sistem autentikasi pengguna agar setiap pengguna memiliki data keuangannya masing-masing secara privat.

## Langkah-langkah Implementasi

1. **Konfigurasi Database (SQLite):**
   - Buka file `.env`.
   - Pastikan konfigurasi database di-set ke SQLite:
     ```env
     DB_CONNECTION=sqlite
     # Hapus atau comment baris DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
     ```
   - *Note:* Laravel 11 secara otomatis akan membuat file `database/database.sqlite` jika tidak ada saat migrasi dijalankan.

2. **Instalasi Sistem Autentikasi (Laravel Breeze):**
   - Di terminal, jalankan perintah untuk menginstall package Breeze:
     ```bash
     composer require laravel/breeze --dev
     ```
   - Lakukan instalasi Breeze dengan stack Blade (standar Laravel dengan Alpine.js dan TailwindCSS):
     ```bash
     php artisan breeze:install blade
     ```
   - (Pilih opsi default jika ada prompt, seperti dukungan Dark Mode atau Pest/PHPUnit).

3. **Migrasi Database Awal:**
   - Jalankan perintah migrasi untuk membuat tabel bawaan Laravel (tabel `users`, `password_reset_tokens`, dll):
     ```bash
     php artisan migrate
     ```

4. **Compile Assets Frontend:**
   - Instal dependensi Node.js dan build asset TailwindCSS:
     ```bash
     npm install
     npm run build
     ```
   - Coba jalankan server backend (`php artisan serve`) dan pastikan halaman registrasi (`/register`) dan login (`/login`) bawaan Breeze sudah bisa diakses dan berfungsi.

## Kriteria Penerimaan (Acceptance Criteria)
- [x] Pengguna bisa mendaftar (register) ke dalam aplikasi.
- [x] Pengguna bisa login dan diarahkan ke halaman `/dashboard` bawaan Breeze.
- [x] Database SQLite telah berhasil dibuat dan terisi tabel-tabel auth standar.
