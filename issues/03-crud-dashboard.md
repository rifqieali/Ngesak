# Issue 3: Buat Sistem Pencatatan (CRUD) dan Dashboard (Blade + Tailwind)

## Deskripsi
Ini adalah bagian utama dari aplikasi (Business Logic dan Antarmuka Pengguna). Kita akan membuat halaman agar user bisa menambah, mengedit, menghapus (CRUD) transaksi mereka. Setelah transaksi diinput, data tersebut harus direkap dan ditampilkan di halaman Dashboard (yang sudah dibuat oleh Breeze).

## Langkah-langkah Implementasi

### 1. Persiapan Controller & Routing
- Buat controller untuk `Category` dan `Transaction`:
  ```bash
  php artisan make:controller CategoryController --resource
  php artisan make:controller TransactionController --resource
  ```
- Di `routes/web.php`, daftarkan rute-rute ini di dalam *middleware group* `auth` agar hanya bisa diakses oleh user yang sudah login:
  ```php
  Route::middleware('auth')->group(function () {
      Route::resource('categories', CategoryController::class);
      Route::resource('transactions', TransactionController::class);
  });
  ```

### 2. Implementasi CRUD pada `TransactionController`
- **Method `create()`:** Kirim data kategori milik user (`Category::where('user_id', auth()->id())->get()`) ke *View* agar user bisa memilih kategori di dropdown form.
- **Method `store()`:** 
  - Validasi *Request* (pastikan `amount` berbentuk angka, `transaction_date` berbentuk date).
  - Simpan data dengan menyisipkan `user_id` otomatis dari user yang sedang login (`auth()->id()`).
  - *Redirect* ke index dengan pesan sukses.
- **Method `index()`:** Ambil semua transaksi milik user (`Transaction::where('user_id', auth()->id())->with('category')->latest()->get()`) lalu lempar ke *View*.

### 3. Pembuatan Views (Blade & TailwindCSS)
Gunakan folder `resources/views/transactions/` untuk menyimpan antarmuka.
- **`index.blade.php`:** Buat tabel untuk menampilkan riwayat (Tanggal, Tipe, Kategori, Catatan, Jumlah). Gunakan styling class Tailwind. Beri tombol 'Edit' dan 'Hapus'.
- **`create.blade.php` / `edit.blade.php`:** Buat form inputan.
  - Terdapat dropdown 'Tipe' (Pengeluaran, Penghasilan, dll).
  - Dropdown 'Kategori' yang mengambil data dari tabel `categories`.
  - Input angka untuk Jumlah (`amount`).

### 4. Merombak Halaman Dashboard
- Buka file `resources/views/dashboard.blade.php`.
- Di bagian route `dashboard` (dalam `web.php`), Anda bisa mengambil total pengeluaran dan penghasilan bulan ini.
  - Contoh kueri: `Transaction::where('user_id', auth()->id())->where('type', 'pengeluaran')->whereMonth('transaction_date', date('m'))->sum('amount');`
  - Lempar variabel `$totalPengeluaran` dan `$totalPenghasilan` ke dalam view dashboard.
- Modifikasi UI dashboard agar menampilkan blok/kartu informasi ringkasan tersebut secara jelas menggunakan TailwindCSS (misal membuat desain card dengan warna hijau untuk penghasilan, merah untuk pengeluaran).

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] User bisa menambah, mengedit, dan menghapus Transaksi keuangan.
- [ ] User hanya bisa melihat dan memanipulasi datanya sendiri (bukan milik user lain).
- [ ] Halaman Dashboard sudah menampilkan rekap total pemasukan dan pengeluaran secara kalkulatif.
- [ ] Tampilan responsif minimal menggunakan TailwindCSS bawaan dari instalasi.
